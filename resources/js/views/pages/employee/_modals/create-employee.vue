<template>
    <modal-dialog v-show="openModal" :options="option" :title="'Add New Employee'" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!valid">Create Employee</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('first_name')}">
                                <label>First Name<span class="error">*</span></label>
                                <input type="text" v-validate="{ required: true, regex: /^[\xF1 \xD1 A-Za-z0-9-,.'&quot; ]*$/ }" ref="firstName" name="first_name" class="form-control" v-model="employeeData.firstName" />
                                <span v-show="errors.has('first_name')" class="help-block form-error">{{ errors.first('first_name') }}</span>
                            </div>
                        </div>
                         <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('middle_name')}">
                                <label>Middle Name</label>
                                <input type="text" name="middle_name" class="form-control" v-model="employeeData.middleName" />
                            </div>
                        </div>
                        <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('last_name')}">
                                <label>Last Name<span class="error">*</span></label>
                                <input type="text" v-validate="{ required: true, regex: /^[\xF1 \xD1 A-Za-z0-9-,.'&quot; ]*$/ }" name="last_name" class="form-control" v-model="employeeData.lastName" />
                                <span v-show="errors.has('last_name')" class="help-block form-error">{{ errors.first('last_name') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" :class="{'has-error': errors.has('employee_no')}">
                                <label>Employee No<span class="error">*</span></label>
                                <div class="input-group">
                                    <input type="text" v-validate="'required|employee_no|max:7'" name="employee_no" ref="employeeNo" id="employee_no" maxlength="7" v-mask="'FS-####'" class="form-control" v-model="employeeData.employeeId" :disabled="!manualInput" autofocus/>
                                    <span v-show="!manualInput" class="input-group-input">
                                        <button type="button" class="btn btn-primary employee-no-button" title="Enter Employee # Manually" @click="_manualInput" :disabled="loading">
                                            <i class="la la-hand-pointer-o"></i>
                                        </button>
                                    </span>
                                    <span v-show="manualInput" class="input-group-input">
                                        <generate-button :loading="loading" :options="button" @action="_generateEmployeeNo">
                                            <i class="la la-gear"></i>
                                        </generate-button>
                                    </span>
                                </div>
                                <span v-show="errors.has('employee_no')" class="help-block form-error">{{ errors.first('employee_no') }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" :class="{'has-error': errors.has('dateHired')}">
                                <label>Date Hired:<span class="error">*</span></label>
                                <flat-pickr
                                        v-model="employeeData.dateHired"
                                        :config="getConfig(true, false, {allowInput: true, onClose: function(selectedDates, dateStr, instance){ manageDateEntered(instance); }})"
                                        placeholder="Select a date"
                                        name="date_start"
                                />
                                <span v-show="errors.has('dateHired')" class="help-block form-error">{{ errors.first('dateHired') }}</span>
                            </div>
                        </div>
                        <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group" :class="{'has-error': errors.has('contact_no')}">
                                        <label>Contact No</label>
                                        <input type="text" @keypress="checkContactNumber" :placeholder="'(..) ....-...-...'" v-mask="'## ####-###-###'" name="contact_no" class="form-control" v-model="contactData.home_no" />
                                        <span v-show="errors.has('contact_no')" class="help-block form-error">{{ errors.first('contact_no') }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" :class="{'has-error': errors.has('mobile_no')}">
                                        <label>Mobile No</label>
                                        <input type="text" @keypress="checkContactNumber" :placeholder="'(..) ....-...-...'" v-mask="'## ####-###-###'" name="mobile_no" class="form-control" v-model="contactData.mobile_no" />
                                        <span v-show="errors.has('mobile_no')" class="help-block form-error">{{ errors.first('mobile_no') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('email')}">
                                <label>Email<span class="error">*</span></label>
                                <input type="text" name="email" v-validate="'required|email'" class="form-control" v-model="employeeData.email" @keyup="checkEmailIfAvailable" />
                                <span v-show="errors.has('email')" class="help-block form-error">{{ errors.first('email') }}</span>
                                <span v-show="emailError"><div class="emailEx">{{ emailError }}</div></span>
                                <span v-show="isEmailTaken" class="help-block form-error emailEx">{{ emailTakenErrMsg }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style type="text/css">
.v-dialogs{
    position: relative;
    z-index: 9999;
}
</style>
<style scoped>

.emailEx {
    padding-top:4px;
    color:#ef5350;
}

</style>

<script type="text/javascript">
import { Validator } from 'vee-validate';
import _ from 'lodash';

//Components
import GenerateButton from '@components/form/button.vue';
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';

//Mixins
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DatePickerMixin from '@common/mixin/DatePicker';
import AlertMixin from '@common/mixin/AlertMixin';

//Modal
import { Employee } from '@common/model/Employee';
import { User } from '@common/model/User';
import { mask } from 'vue-the-mask';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

import { mapActions, mapGetters } from 'vuex';

// custom validator rule
Validator.extend('employee_no', {
    getMessage: field => `Invalid ${field} format, must be FS-####`,
    validate: function(value) {
        let regx = /^FS-0*([1-9][0-9]*)$/i;
        return regx.test(value);
    }
});
export default {
    directives: {
        mask
    },
    data() {
        return {
            option: {
                width: '800px'
            },
            employeeData: {
                employeeId: '',
                firstName: '',
                lastName: '',
                middleName: '',
                email: '',
                dateHired: ''
            },
            employeeStatusData: {
                employee_id: '',
                status_id: '',
                user_id: ''
            },
            contactData: {
                employee_id: '',
                home_no: '',
                mobile_no: ''
            },
            emailError: '',
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            loading: false,
            manualInput : false,
            validation: [
                {path: 'employeeId', name: 'employee_no', rule: 'required', msg: {required: 'Employee No is required'}},
                {path: 'firstName', name: 'first_name', rule: 'required', msg: {required: 'First Name is required'}},
                {path: 'lastName', name: 'last_name', rule: 'required', msg: {required: 'Last Name is required'}},
                {path: 'email', name: 'email', rule: 'required', msg: {required: 'Email is required'}},
                {path: 'dateHired', name: 'dateHired', rule: 'required', msg: {required: 'Date Hired field is required'}}
            ],
            emailExist: false,
            isEmailTaken:false,
            emailTakenErrMsg:'',
            alphaNum_specialChar: /^[\xF1 \xD1 A-Za-z0-9-,.'" ]*$/,
            date_regex: /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/
        }
    },
    created () {
        this._generateEmployeeNo();
        this.getStatusId('Hired');

        /** Prepare status id of Hired - and user id of the person logged in - Required in employee-statuses table **/
        User.me(true).then((res) => {
            if(this.statusId){
                this.employeeStatusData.user_id = res.data.id;
                this.employeeStatusData.status_id = this.statusId[0].id;
            }
        });
    },
    computed: {
        ...mapGetters({
            user: 'users/user',
            statusId: 'statuses/status'
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

                        if (this.isEmpty(_.get(this.employeeData, form.path))) {
                            valid = false;
                            return;
                        }
                    }
                });
                // checks if email already exists
                if (this.isEmailTaken) {
                    valid = false;
                    return;
                }
                // checks if email contains spaces
                if (this.employeeData.email.match(/\s/)) {
                    valid = false;
                    return;
                }
                // checks if email follows the format
                if (this.employeeData.email.match(/\S+@\S+\.\S+/) == null) {
                    valid = false;
                    return;
                }

                if (!valid) return;
            });
            // name format validation (accepts alphanumeric characters and special characters: '.,"- )
            if(
                this.employeeData.firstName.match(this.alphaNum_specialChar) == null 
                || this.employeeData.lastName.match(this.alphaNum_specialChar) == null 
                || this.employeeData.middleName.match(this.alphaNum_specialChar) == null
            ) {
                valid = false;
            }

            return valid;
        }
    },
    methods : {
        manageDateEntered(instance){
            let temp = $(instance._input).val();
            let input = $(instance.input).val();
            if(temp !== input){
                if(temp === ''){
                    this.employeeData.dateHired = '';
                } else {
                    if(!this.date_regex.test(temp)){
                        $(instance._input).val(this.employeeData.dateHired);
                    } else {
                        this.employeeData.dateHired = temp;
                    }
                }
            }
        },
        ...mapActions({
                checkEmployeeNo : 'employees/checkEmployeeNoIfExists',
                checkEmail : 'users/checkEmail',
                saveContact: 'contact/saveContact',
                getStatusId: 'statuses/searchStatusByName',
                saveEmpStatus: 'empStatuses/saveEmployeeStatus'
            }),
        _manualInput() {
            this.manualInput = true;
        },
        _generateEmployeeNo() {
            this.loading = true;
            this.manualInput = false;
            this.employeeData.employeeId = '';
            this.generateEmployeeNo().then((newEmpNo) => {
                this.employeeData.employeeId = newEmpNo;
                this.loading = false;
            });
        },
        async save() {
            let con = true;
            await this.checkEmployeeNo({'employeeNo': this.employeeData.employeeId}).then((res) => {
                if (res.data.length) {
                    let title = 'You cannot use this Employee No., please generate another one.';
                    let msg = this.employeeData.employeeId;
                    this.confirmDialog(title, msg, 'Close', '', 'sm');
                    con = false;
                }
            });
            if(!con) return;

            this.loading = true;
            const employee = new Employee();
            let user = new User();
            let unique_str = this.employeeData.employeeId.replace('-','').toLowerCase() + Math.random().toString(36).substring(2, 9)
            const data = {
                employee_no: this.employeeData.employeeId,
                first_name: this.employeeData.firstName,
                last_name: this.employeeData.lastName,
                middle_name: this.employeeData.middleName,
                contact_no: this.employeeData.contactNo,
                date_hired: this.employeeData.dateHired,
                unique_str:unique_str
            }


            await user.save({email: this.employeeData.email, password:'fullscale'}).then((res) => {
                    data.user_id = res.data.id;
                    employee.save(data).then((res) => {
                    const id = res.data.id;
                    this.$set(this.contactData,'employee_id',id);

                    /** Prepare records for employee status, default is 'Hired', check created() for preparation **/
                    this.employeeStatusData.employee_id = id;
                    this.saveEmpStatus(this.employeeStatusData);

                    this.saveContact(this.contactData).then((res) => {
                        this.loading = false;
                        this.closeModal();
                        //redirect to employee detail
                        this.notifyDialog('success', 'Successfully saved!');
                        this.$router.push('/employee/'+id+'/profile');
                    });
                })
            }).catch((error) => {
                this.employeeNoError = error.response.data.message.employee_no ? error.response.data.message.employee_no[0] : '';
                this.emailError = error.response.data.message.email ? error.response.data.message.email[0] : '';
                this.loading = false;
            });

        },
        async checkEmailIfAvailable() {
            this.isEmailTaken = false;
            this.emailTakenErrMsg = '';
            let email = this.employeeData.email.trim();
            if (email != '') {
                await this.checkEmail({applicant: 'any', email: email});
                if(this.user.length){
                    this.isEmailTaken = true;
                    this.emailTakenErrMsg = 'Email is already taken.';
                }
            }
        }
    },
    components: {
        GenerateButton,
        SaveButton,
        ModalDialog,
        FlatPickr
    },
    mixins: [
        EmployeeMixin,
        StringHelperMixin,
        ModalDialogMixin,
        DatePickerMixin,
        AlertMixin
    ]
}
</script>
