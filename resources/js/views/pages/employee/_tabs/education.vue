<template>
    <div class="fs-accordion" :class="accordionClasses">
        <div class="card panel panel-default ks-information ks-light">
            <div class="card-header" @click.stop="toggleAccordion">
                <h4 class="ks-text" id="education">Education</h4>
                <Can I="add" a="employee_education">
                    <a href="#education" class="btn ks-light ks-no-text" @click.stop="addEducation">
                        <span class="la la-plus-square ks-icon"></span>
                    </a>
                </Can>
            </div>

            <div class="card-block fs-accordion-content">
                <div class="row" v-for="educ in getEducationData(employee)" v-bind:style="cssStyles.rowDivBottom" v-bind:key="educ.id">
                    <div class="col-lg-12">
                        <div class="card fs-card">
                            <div class="card-block fs-card-block" style="padding: 0">
                                <div class="image">
                                    <i class="la la-university"></i>
                                </div>
                                <div class="fs-card-info">
                                    <h5 class="card-title">{{ educ.course_degree }}</h5>
                                    <p class="card-text">{{ educ.school_university }}</p>
                                    <p class="card-text">{{ educ.is_present == 1 ? 'Present' : educ.year_completed }}</p>
                                </div>
                            </div>
                            <div class="education-edit-button" style="cursor:auto">
                                <Can I="update" a="employee_education">
                                    <a href="#education" class="fs-button" @click="editEducation(educ.id)">
                                        <span class="la la-edit ks-icon"></span>
                                    </a>
                                </Can>
                                &nbsp;
                                <Can I="delete" a="employee_education">
                                    <a href="#education" class="fs-button" @click="removeEducation(educ.id)">
                                        <span class="la la-trash-o ks-icon"></span>
                                    </a>
                                </Can>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN MODAL DIALOG -->
        <education-modal
                :form="form"
                :attainmentOptions="attainments"
                :openModal="open"
                @success="updateEducationData"
                @close="closingDialog"
        ></education-modal>
        <!-- END MODAL DIALOG -->
    </div>
</template>

<script>
import { EmployeeEducation } from '@common/model/EmployeeEducation';
import EmployeeEducationMixin from '@common/mixin/EmployeeEducationMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import AccordionMixin from '@common/mixin/AccordionMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import ModalDialog from '@components/modal-dialog.vue';
import EducationModal from '@views/pages/employee/_modals/education.vue';
import { mapGetters, mapActions } from 'vuex';
import _ from 'lodash';

export default {
    data() {
        return {
            modal: {
                width: '800px',
                height: '465px!important'
            },
            data_edu: {
                rows: [],
                attainmentOptions: []
            },
            cssStyles: {
                rowDivBottom: {
                    "padding-bottom": '5px!important'
                }
            },
            form: {
                id: '',
                employee_id: '',
                schoolUniversity: '',
                courseDegree: '',
                yearCompleted: '',
                educationalAttainment: '',
                is_present: '',
            },
            open: false
        }
    },
    created() {
        this.clearForm();
        this.getYears({min: 2000, max: new Date().getFullYear()});
        this.loadEmployeeEducation();
    },
    computed: {
        ...mapGetters({
            attainments: 'educationalAttainments/active',
            employee: 'employees/single'
        })
    },
    methods: {
        ...mapActions({
            getActiveEducationalAttainments: 'educationalAttainments/getActiveEducationalAttainments',
            getEmployee: 'employees/getEmployee',
            getYears: 'years/getYears',
            reOrder: 'educations/reOrder'
        }),
        getEducationData() {
            let educations = [];
            try{
                if(this.employee.educations.data.filter(a => a.is_present == 1).length) {
                    this.employee.educations.data.filter(a => a.is_present == 1).forEach(function(education){
                        educations.push(education);
                    });
                }
                return educations.concat(_.orderBy(this.employee.educations.data.filter(a => a.is_present != 1),'year_completed','desc'));
            }catch(e){
                return [];
            }
        },
        async addEducation(){
            await this.clearForm();
            await this.reloadEducationAttainments();
            this.open = true;
        },
        loadEmployeeEducation() {
            this.$emit('success');
        },
        async updateEducationData() {
            this.open = false;
            this.clearForm();
            this.loadEmployeeEducation();
        },
        async editEducation(id){
            await this.reloadEducationAttainments();
            await this.loadEmployeeEducationForm(id);
            this.open=true;
        },
        removeEducation(edu_id){
            this.confirmDialog("Removing Education...", "Are you sure you want to delete?", "Yes", "Cancel", "sm").then((res)=>{
                if(res.ok){
                    let edu = new EmployeeEducation({id: edu_id});
                    edu.delete().then((res)=>{
                        this.updateEducationData();
                        this.notifyDialog('error', 'Successfully deleted!');
                    });
                }
            });
        },
        async loadEmployeeEducationForm(id){
            let obj = this.employee.educations.data.filter( obj => obj.id == id )[0];
            if(obj){
                this.form.id                    = obj.id;
                this.form.employee_id           = obj.employee_id;
                this.form.educationalAttainment = obj.educational_attainment_id;
                this.form.courseDegree          = obj.course_degree;
                this.form.schoolUniversity      = obj.school_university;
                this.form.yearCompleted         = obj.year_completed == 0 ? '' : obj.year_completed;
                this.form.is_present            = obj.is_present == 1 ? true : false;
            }
        },
        clearForm(){
            this.form.id = '';
            this.form.employee_id = '';
            this.form.schoolUniversity = '';
            this.form.courseDegree = '';
            this.form.yearCompleted = '';
            this.form.educationalAttainment = '';
            this.form.is_present = '';
        },
        closingDialog(){
            this.clearForm();
            this.open=false;
            this.updateEducationData();
        },
        move(level) {
            console.log(level, '__LEVEL__');
        },
        reloadEducationAttainments(){
            this.getActiveEducationalAttainments({query: {orderBy: 'level|asc'},extra: {}});
        }
    },
    mixins: [
        AlertMixin,
        EmployeeEducationMixin,
        ModalDialogMixin,
        AccordionMixin
    ],
    components: {
        EducationModal,
        ModalDialog
    }
}
</script>
