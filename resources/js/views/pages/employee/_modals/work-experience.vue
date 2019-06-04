<template>
    <modal-dialog v-show="openModal" :options="option" :title="'Work Experience'" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" @action="add" :disabled="!valid || invalidDate">{{ experienceId ? 'Update' : 'Save' }}</save-button>
        </template>
        <template slot="body">
            <div class="row form-group" v-if="validationErrorMessage">
                <div class="col-sm">
                    <span class="help-block form-error" v-html="validationErrorMessage"></span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-6">
                    <label>Position<span class="error">*</span></label>
                    <input type="text" v-validate="'required'" name="role"  class="form-control" v-model="formData.jobTitle" v-on:input="toggleIsDuplicate" />
                    <span v-show="errors.has('role')" class="help-block form-error">{{ errors.first('role') }}</span>
                </div>
                <div class="col-lg-6">
                    <label>Company Name<span class="error">*</span></label>
                    <input type="text" v-validate="'required'" name="company_name" class="form-control" v-model="formData.companyName" v-on:input="toggleIsDuplicate" />
                    <span v-show="errors.has('company_name')" class="help-block form-error">{{ errors.first('company_name') }}</span>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-6"><label>Period<span class="error">*</span></label>
                    <flat-pickr name="date_start" placeholder="Start Date"
                        v-model="formData.dateStart"
                        :config="getConfig(true, false, {allowInput:true})"
                        v-validate="'required'"
                        v-on:input="toggleIsDuplicate"
                    />
                    <span v-show="errors.has('date_start')" class="help-block form-error" >{{ errors.first('date_start') }}</span>
                    <span v-show="invalidDate" class="help-block form-error">Invalid Date Range</span>
                </div>
                <div class="col-lg-6">
                    <label>&nbsp;</label>
                    <flat-pickr name="date_end" placeholder="End Date"
                        v-model="formData.dateEnd"
                        :config="getConfig(true, false, {allowInput:true})"
                        v-validate="'required'"
                        v-on:input="toggleIsDuplicate"
                    />
                    <span v-show="errors.has('date_end')" class="help-block form-error">{{ errors.first('date_end') }}</span>
                    <span v-show="invalidDate" class="help-block form-error">Invalid Date Range</span>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-12">
                    <label>Description</label>
                    <textarea v-model="formData.description" class="form-control" name="description" rows="5" id="description"></textarea>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-12">
                    <label>Reason for Leaving</label>
                    <textarea v-model="formData.reasonForLeaving" class="form-control" name="reason_for_leaving" rows="5" id="reason_for_leaving"></textarea>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped>
    .form-error {
        color: red;
    }
    .custom-shift {
        display: flex;
        flex-direction: row;
        margin-top: 10px;
    }
    .custom-shift .time-selection:first-child {
        margin-right: 10px;
    }
    .position-level {
        display: flex;
        flex-direction: column;
        width: 300px;
    }
    .position-el {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .current-position {
        display: flex;
        flex-direction: row;
    }
    .position {
        width: 380px;
    }
    footer[class="modal-footer"] {
        display: none !important;
    }
</style>

<script>
import { Validator } from "vee-validate";
import DateMixin from "@common/mixin/DateMixin";
import ModalDialog from "@components/modal-dialog.vue";
import ModalDialogMixin from "@common/mixin/ModalDialogMixin";
import EmployeeMixin from "@common/mixin/EmployeeMixin";
import DatePickerMixin from "@common/mixin/DatePicker";
import AlertMixin from "@common/mixin/AlertMixin";
import SaveButton from "@components/form/button.vue";
import VueTagsInput from "@johmun/vue-tags-input";
import Select2 from "@components/select2.vue";
import { WorkShift } from "@common/model/WorkShift";
import { JobPosition } from "@common/model/JobPosition";
import { WorkExperience } from "@common/model/WorkExperience";
import StringHelperMixin from "@common/mixin/StringHelperMixin";
import _ from "lodash";
import FlatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { mapActions, mapGetters } from "vuex";

export default {
    props: {
        experienceId: {
            type: Number,
            required: false,
            default: 0
        }
    },
    watch: {
        employee: function() {
            this.updateFormData();
        }
    },
    data() {
        return {
            loading: false,
            invalidDate: false,
            validationErrorMessage: '',
            isDuplicate: false,
            formData: {
                jobTitle: '',
                dateStart: '',
                dateEnd: '',
                companyName: '',
                reasonForLeaving: '',
                description: ''
            },
            option: {
                width: '800px'
            },
            validation: [
                { path: 'jobTitle',     name: 'role',           rule: 'required',           msg: { requred: 'Role is required'          }},
                { path: "companyName",  name: "company_name",   rule: "required",           msg: { requred: "Company Name is required"  }},
                { path: "dateStart",    name: "date_start",     rule: "required|validDate", msg: { requred: "Start Date is required"    }},
                { path: "dateEnd",      name: "date_end",       rule: "required",           msg: { requred: "End Date is required"      }}
            ]
        };
    },
    created() {
        this.updateFormData();
    },
    computed: {
        ...mapGetters({
            employee: "employees/single"
        }),
        valid: function() {
            let valid = true;
            // check validation form validation set rule
            _.each(this.validation, form => {
                // break validation rule
                let rules = form.rule.split("|");
                // validate accordingly
                _.each(rules, rule => {
                    if (rule == "required") {
                        if (this.isEmpty(_.get(this.formData, form.path))) {
                            valid = false;
                            return;
                        }
                    }

                    if (rule == "validDate") {
                        if (!this.isEmpty(_.get(this.formData, form.path)) && !this.isEmpty(this.formData, "dateEnd")) {
                            const dateStart = moment(this.formData.dateStart).unix();
                            const dateEnd = moment(this.formData.dateEnd).unix();

                            if (!isNaN(dateStart) && !isNaN(dateEnd)) {
                                if (dateStart > dateEnd) {
                                    this.invalidDate = true;
                                    return;
                                } else {
                                    this.invalidDate = false;
                                }
                            }
                        }
                    }
                });

                if(this.isDuplicate) {
                    valid = false;
                }

                if (!valid) return;
            });
            return valid;
        }
    },
    async created() {
        this.updateFormData();
    },
    methods: {
        ...mapActions({
            getEmployee: 'employees/getEmployee'
        }),
        add() {
            this.loading = true;
            let promises = [];
            let workExperience = new WorkExperience();

            if(this.experienceId) {
                workExperience = new WorkExperience({id: this.experienceId});
            }

            let data = {
                id: this.experienceId === 0 ? '' : this.experienceId,
                employee_id: this.employee.id,
                job_title: this.formData.jobTitle,
                company_name: this.formData.companyName,
                description: this.formData.description,
                reason_for_leaving: this.formData.reasonForLeaving,
                start_date: this.formData.dateStart,
                end_date: this.formData.dateEnd
            };

            promises.push(workExperience.save(data));
            Promise.all(promises).then((res) => {
                this.$emit('success');
                this.loading = false;
                this.notifyDialog('success', 'Successfully saved!');
            }).catch(error => {
                let res = error.response;

                _.each(res.data.message, msg => {
                    _.each(msg, (value) => {
                        this.validationErrorMessage += value + '<br>';
                    });
                });

                if (res.status == 400) {
                    this.isDuplicate = true;
                    this.loading = false;
                }
                console.log('save error occurred');
            });
        },
        updateFormData() {
            if (this.experienceId != 0) {
                const workExperience = this.employee.workExperiences.data.filter(
                    w => w.id == this.experienceId
                );

                // console.log(workExperience, "__WE__");
                if (workExperience.length) {
                    this.formData.jobTitle = workExperience[0].job_title;
                    this.formData.companyName = workExperience[0].company_name;
                    this.formData.dateStart = workExperience[0].start_date;
                    this.formData.dateEnd = workExperience[0].end_date;
                    this.formData.description = workExperience[0].description;
                    this.formData.reasonForLeaving = workExperience[0].reason_for_leaving;
                }
            }
        },
        toggleIsDuplicate() {
            this.isDuplicate = false;
            this.validationErrorMessage = '';
            this.loading = false;
        }
    },
    components: {
        SaveButton,
        VueTagsInput,
        Select2,
        FlatPickr,
        ModalDialog
    },
    mixins: [
        DateMixin,
        EmployeeMixin,
        DatePickerMixin,
        ModalDialogMixin,
        StringHelperMixin,
        AlertMixin
    ]
}
</script>
