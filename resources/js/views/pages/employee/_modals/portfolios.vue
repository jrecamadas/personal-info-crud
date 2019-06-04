<template>
    <modal-dialog :options="option" v-show="openModal" @close="closeModal" :title="'Portfolio'">
        <template slot="button">
            <save-button class="btn btn-primary" :loading="loading" :disabled="!valid || dateInvalid" @action="save">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Project Name<span class="error">*</span></label>
                        <input class="form-control" v-validate="'required'" name="project-name" type="text" v-model="formData.name">
                        <span v-show="errors.has('project-name')" class="help-block form-error">{{ errors.first('project-name') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Project Url</label>
                        <input v-validate="'url'" class="form-control" name="url" type="text" v-model="formData.url">
                        <span v-show="errors.has('url')" class="help-block form-error">{{ errors.first('url') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Experience:</label>
                        <select name="" v-model="formData.experienceId" id="" class="form-control">
                            <option value="">----</option>
                            <option v-if="employee.workExperiences" :value="exp.id" v-for="(exp, k) in employee.workExperiences.data">{{exp.company_name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Start Date<span class="error">*</span></label>
                        <flat-pickr
                            v-model="formData.dateStart"
                            :config="getConfig(true, false, {allowInput:true})"
                            placeholder="Start Date"
                            name="start-date"
                            v-validate="'required'"
                        />
                        <span v-if="this.dateInvalid" class="help-block form-error">Invalid Date Range</span>
                        <span v-show="errors.has('start-date')" class="help-block form-error">{{ errors.first('start-date') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">End Date<span class="error">*</span></label>
                        <flat-pickr
                            v-model="formData.dateEnd"
                            :config="getConfig(true, false, {allowInput:true})"
                            placeholder="End Date"
                            name="end-date"
                            v-validate="'required'"
                        />
                        <span v-if="this.dateInvalid" class="help-block form-error">Invalid Date Range</span>
                        <span v-show="errors.has('end-date')" class="help-block form-error">{{ errors.first('end-date') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Description<span class="error">*</span></label>
                <textarea v-validate="'required'" class="form-control" name="description" v-model="formData.description" id="" cols="30" rows="10"></textarea>
                <span v-show="errors.has('description')" class="help-block form-error">{{ errors.first('description') }}</span>
            </div>
        </template>
    </modal-dialog>
</template>
<style scoped>
.form-error {
    color: red;
}
</style>
<script>
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import FlatPickr from 'vue-flatpickr-component';
import DateMixin from '@common/mixin/DateMixin';
import DatePickerMixin from '@common/mixin/DatePicker';
import AlertMixin from '@common/mixin/AlertMixin';
import 'flatpickr/dist/flatpickr.css';
import { EmployeePortfolio } from '@common/model/EmployeePortfolio';
import SaveButton from '@components/form/button.vue';
import { mapGetters } from 'vuex';
import _ from 'lodash';
import { Validator } from 'vee-validate';
import StringHelperMixin from '@common/mixin/StringHelperMixin';

// custom validator rule
Validator.extend('url', {
    getMessage: field => `Invalid url`,
    validate: function(value) {
        let regx = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;
        return regx.test(value);
    }
});

export default {
    watch: {
        'formData.dateStart': {
            handler: function(val, oldVal) {
                if(val==''){
                    this.dateInvalid = false;
                }
            },
            deep: true
        },
        'formData.dateEnd': {
            handler: function(val, oldVal) {
                if(val==''){
                    this.dateInvalid = false;
                }
            },
            deep: true
        }
    },
    props: {
        id: {
            type: Number,
            required: false,
            default: function() {
                return null;
            }
        }
    },
    data() {
        return {
            loading: false,
            dateInvalid: false,
            option: {
                width:'800px'
            },
            formData: {
                name: '',
                description: '',
                url: '',
                dateStart: '',
                dateEnd: '',
                experienceId:''
            },
            validation: [
                {path: 'name', name: 'project-name', rule: 'required', msg: {requred: 'Name is required'}},
                {path: 'description', name: 'description', rule: 'required', msg: {required: 'Description is required'}},
                {path: 'url', name: 'url', rule: 'url', msg: {required: 'Url is invalid'}},
                {path: 'date', name: 'date', rule: 'validDate', msg: {required: 'Invalid date range'}},
                {path: 'dateStart', name: 'start-date', rule: 'required', msg: {required: 'start date is required'}},
                {path: 'dateEnd', name: 'end-date', rule: 'required', msg: {required: 'end date is required'}}
            ]
        }
    },
    async created() {
        if(this.id){
            const portfolio = await this.employee.portfolios.data.filter(portfolio => portfolio.id == this.id)[0];
            this.formData = {
                name: portfolio.name,
                description: portfolio.description,
                url: portfolio.url,
                dateStart: portfolio.start_date,
                dateEnd: portfolio.end_date,
                experienceId: (portfolio.experience) ? portfolio.experience.id : ''
            }
        }
    },
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        }),
        valid: function() {
            let valid = true;
            // check validation form validation set rule
            _.each(this.validation, (form) => {
                // break validation rule
                let rules = form.rule.split('|');
                // validate accordingly
                _.each(rules, (rule) => {
                    if (rule == 'required') {
                        if (this.isEmpty(_.get(this.formData, form.path))) {
                            valid = false;
                            return;
                        }
                    }

                    if(rule == 'url') {
                        if(this.errors.items.length) {
                            valid = false;
                            return;
                        }
                    }

                    if (rule == 'validDate') {
                        if(this.formData.dateStart != '' || this.formData.dateEnd != '') {
                            const dateStart = moment(this.formData.dateStart).unix();
                            const dateEnd = moment(this.formData.dateEnd).unix();

                            if (!isNaN(dateStart) && !isNaN(dateEnd)) {
                                if (dateStart > dateEnd) {
                                    this.dateInvalid = true;
                                    valid = false;
                                    return;
                                } else {
                                    this.dateInvalid = false;
                                }
                            }
                        }
                    }
                });
                if (!valid) return;
            });


            return valid;
        }
    },
    methods: {
        save() {
            this.loading = true;

            let employeePortfolio = new EmployeePortfolio();
            if(this.id) {
                employeePortfolio = new EmployeePortfolio({id: this.id });
            }
            employeePortfolio.save({
                employee_id: this.$route.params.id,
                name: this.formData.name,
                url: this.formData.url,
                start_date: this.formData.dateStart,
                end_date: this.formData.dateEnd,
                description: this.formData.description,
                work_experience_id: this.formData.experienceId ? this.formData.experienceId : null
            }).then(() =>{
                for (const key in this.formData) {
                    if (this.formData.hasOwnProperty(key)) {
                        this.formData[key] = '';
                    }
                }
                this.$emit('success');
                this.loading = false;
                this.closeModal();
                this.notifyDialog('success', 'Successfully saved!');
            });
        }
    },
    components: {
        ModalDialog,
        FlatPickr,
        SaveButton
    },
    mixins: [
        ModalDialogMixin,
        DateMixin,
        DatePickerMixin,
        StringHelperMixin,
        AlertMixin
    ]
}
</script>


