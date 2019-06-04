<template>
    <div class="fs-accordion" :class="accordionClasses">
        <div class="fs-field">
            <div class="card panel panel-default ks-information ks-light">
                <div class="card-header" @click.stop="toggleAccordion">
                    <h4 id="work-experience" class="ks-text">Work Experience</h4>
                    <Can I="add" a="work_experience">
                        <a href="#work-experience" class="btn ks-light ks-no-text" @click.stop="addData">
                            <span class="la la-plus-square ks-icon"></span>
                        </a>
                    </Can>
                </div>
                <div class="card-block fs-accordion-content" v-if="employee.workExperiences">
                    <div v-for="(experience) in employee.workExperiences.data" class="fs-card" v-bind:key="experience.id">
                        <div class="fs-card-block">
                            <div class="image">
                                <i class="la la-building-o"></i>
                            </div>
                            <div class="fs-card-info">
                                <h5 class="card-title">{{ experience.job_title }}</h5>
                                <!-- <p class="card-text">No. of Assigned Projects: {{ experience.portfolios.data.length }}</p> -->
                                <p class="card-text">{{ experience.company_name }}</p>
                                <p class="card-text">{{ formatDate(experience.start_date, 'MMM YYYY') }} - {{ formatDate(experience.end_date, 'MMM YYYY') }}</p>
                                <p class="card-text pre-wrap">{{ experience.description }}</p>
                            </div>
                        </div>
                        <div class>
                            <Can I="update" a="work_experience">
                                <a href="#work-experience" class="fs-button" @click="editData(experience.id)">
                                    <span class="la la-edit ks-icon"></span>
                                </a>
                            </Can>
                            <Can I="delete" a="work_experience">
                                <a href="#work-experience" class="fs-button" @click="removeData(experience.id)">
                                    <span class="la la-trash-o ks-icon"></span>
                                </a>
                            </Can>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN WORK EXPERIENCE DIALOG -->
        <work-experience-modal
                :openModal="open"
                v-if="open"
                :experienceId="experienceId"
                @success="updateData"
                @close="closingDialog"
        ></work-experience-modal>
        <!-- END WORK DETAIL DIALOG -->
    </div>
</template>

<style type="scss" scoped>
    .experience-options-container {
        padding-bottom: 15px;
        text-align: right;
    }
</style>

<script>
import ModalDialogMixin from "@common/mixin/ModalDialogMixin";
import WorkExperienceModal from "@views/pages/employee/_modals/work-experience.vue";
import EmployeeMixin from "@common/mixin/EmployeeMixin";
import AccordionMixin from "@common/mixin/AccordionMixin";
import DateMixin from "@common/mixin/DateMixin";
import AlertMixin from "@common/mixin/AlertMixin";
import { Employee } from "@common/model/Employee";
import { WorkExperience } from "@common/model/WorkExperience";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            modal: {
                width: "800px",
                height: "650px"
            },
            form: {
                key: "work-experience",
                name: "Work Experience"
            },
            experienceId: 0,
            open: false
        };
    },
    components: {
        WorkExperienceModal
    },
    computed: {
        ...mapGetters({
            employee: "employees/single"
        })
    },
    methods: {
        updateData() {
            this.open = false;
            this.$emit("success");
        },
        addData(){
            this.experienceId = 0;
            this.open = true;
        },
        editData(work_id) {
            this.experienceId = work_id;
            this.open = true;
        },
        toggleDetails() {
            this.showDetails = !this.showDetails;
        },
        closingDialog() {
            this.open = false;
            this.$emit("success");
        },
        // START NEW REMOVE VALIDATION
        removeData(work_id) {
            this.confirmDialog(
                "Removing Work Experience...",
                "Are you sure you want to delete?",
                "Yes",
                "Cancel",
                "sm"
            ).then(res => {
                if (res.ok) {
                    let exp = new WorkExperience({ id: work_id });
                    exp.delete().then(res => {
                        this.updateData();
                        this.notifyDialog('error', 'Successfully deleted!');
                    });
                }
            });
        }
        // END NEW REMOVE VALIDATION
    },
    mixins: [ModalDialogMixin, EmployeeMixin, AlertMixin, AccordionMixin]
};
</script>
