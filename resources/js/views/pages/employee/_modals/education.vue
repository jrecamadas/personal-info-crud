<template>
    <modal-dialog :options="modal" v-show="openModal" :title="'Education'" @close="closeModal">
        <template slot="button">
            <add-button :loading="loading" :options="button" :disabled="!valid" @action="add">{{ form.id ? 'Update' : 'Add' }} Education</add-button>
        </template>
        <template slot="body">
            <div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-wrapper">
                            <span>Educational Attainment<span class="error">*</span></span>
                            <div class="form-group">
                                <div v-for="a in attainmentOptions" :key="a.id" class="custom-control custom-radio">
                                    <input :id="'a' + a.id" v-model="form.educationalAttainment" type="radio" :value="a.id" class="custom-control-input" />
                                    <label class="custom-control-label" :for="'a' + a.id">{{ a.attainment }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Year Completed:</label>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <input type="text" name="year_completed" id="year_completed" class="form-control" placeholder="yyyy"
                                            v-validate="'required|numeric|date_format:YYYY|date_between:1899,' + (currentYear + 1) +''" 
                                            maxlength="4"
                                            :disabled="form.is_present == '' ? false : true"
                                            v-model="form.yearCompleted">
                                        <span v-show="errors.has('year_completed')" class="help-block form-error">{{ replaceText(errors.first('year_completed'),'year_completed','Year Completed') }}</span>
                                    </div>
                                    <div class="col-sm-7">
                                        <span class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="is_present" id="is_present" 
                                            :checked="currentlySchooling == 'yes' ? true : false" 
                                            @click="controlYearCompleted"
                                            v-model="form.is_present">
                                            <label for="is_present" class="custom-control-label">Currently Schooling</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-wrapper">
                            <div class="form-group">
                                <label>Course/Degree<span class="error">*</span></label>
                                <input type="text" v-validate="'required'" name="course_degree" class="form-control" v-model="form.courseDegree" />
                                <span v-show="errors.has('course_degree')" class="help-block form-error">{{ replaceText(errors.first('course_degree'),'course_degree','Course/Degree') }}</span>
                            </div>
                        </div>
                        <div class="form-wrapper">
                            <div class="form-group">
                                <label>School/University/Agency/NGO<span class="error">*</span></label>
                                <input type="text" v-validate="'required'" name="school_university" class="form-control" v-model="form.schoolUniversity" />
                                <span v-show="errors.has('school_university')" class="help-block form-error">{{ replaceText(errors.first('school_university'),'school_university','School/University') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped>
.form-wrapper:first-child {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
.form-wrapper:first-child .form-group:last-child {
    width: 300px;
}
.custom-control-label::after {
    left: -23px !important;
}
.form-error {
    color: red;
}
.custom-control.custom-checkbox {
    margin-top: .7em;
}
</style>

<script>
import AddButton from '@components/form/button.vue';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import { EmployeeEducation } from '@common/model/EmployeeEducation';
import { EducationalAttainment } from '@common/model/EducationalAttainment';
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import { mapGetters } from 'vuex';

export default {
    props: {
        info: {
            type: Array,
            required: false
        },
        edit: {
            type: Boolean,
            default: false
        },
        form: {
            type: Object,
            required: false
        },
        attainmentOptions: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            loading: false,
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            modal: {
                width: '800px'
            },
            alpha_space: /^[a-zA-Z][a-zA-Z\s ]+$/,
            currentYear: new Date().getFullYear(),
            currentlySchooling: 'no'
        }
    },
    computed: {
        ...mapGetters({
            years: 'years/formatted'
        }),
        valid: function() {
            if (this.form.is_present) {
                this.currentlySchooling = 'yes';
                this.errors.items = [];
            }

            return  !this.isEmpty(this.form.educationalAttainment) &&
                    !this.isEmpty(this.form.courseDegree) &&
                    !this.isEmpty(this.form.schoolUniversity) &&
                    ((!this.isEmpty(this.form.yearCompleted) && this.isEmpty(this.errors.items)) ||
                    ((this.isEmpty(this.form.yearCompleted) || !this.isEmpty(this.errors.items)) && 
                    this.form.is_present)) /* &&
                    this.form.courseDegree.match(this.alpha_space)!=null && //Remove Alpha and Space validation for Course/Degree and School/University
                    this.form.schoolUniversity.match(this.alpha_space)!=null*/;
        },
    },
    async created(){

    },
    methods: {
        add() {
            this.loading = true;
            let year = this.form.is_present ? 0 : this.form.yearCompleted;
            let isPresent = this.form.is_present ? 1 : 0;

            let ee=(this.form.id!=null&&!this.isEmpty(this.form.id))?new EmployeeEducation({id: this.form.id}):new EmployeeEducation();
            let edu_data = {
                employee_id:                this.getEmployeeID(),
                educational_attainment_id:  this.form.educationalAttainment,
                course_degree:              this.form.courseDegree,
                school_university:          this.form.schoolUniversity,
                year_completed:             year,
                is_present:                 isPresent,
            };

            ee.save(edu_data).then((res)=>{
                this.loading = false;
                this.$emit('success');
                this.notifyDialog('success', 'Successfully saved!');
            });
        },
        getEmployeeID(){
            return this.$route.params.id;
        },
        replaceText(str,look,replace){
            if(str!=null && str!=''){
                return str.replace(look,replace);
            } return "";
        },
        controlYearCompleted() {
            setTimeout(()=>{
                if(this.form.is_present){
                    this.form.yearCompleted = '';
                }
            },20);
        }
    },
    components: {
        ModalDialog,
        AddButton
    },
    mixins: [
        ModalDialogMixin,
        StringHelperMixin,
        AlertMixin
    ]
}
</script>
