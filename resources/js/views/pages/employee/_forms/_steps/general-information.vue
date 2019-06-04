<template>
    <div id="general-information">
        <div class="row">
            <div class="col-lg-12">
                <h4>General Information</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-2">
                <div class="form-group" :class="{'has-error': errors.has('employee_no')}">
                    <label>Employee No<span class="error">*</span></label>
                    <div class="input-group">
                        <input type="text" v-validate="'required|employee_no|max:7'" name="employee_no" ref="employeeNo" id="employee_no" maxlength="7" class="form-control" v-model="data.info.employeeNo" :disabled="!manualInput" autofocus/>
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
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <label>Date Hired</label>
                    <flat-pickr
                        v-model="data.info.dateHired"
                        :config="getConfig(true, false, {allowInput:true})"
                        placeholder="Select a date"
                        name="date_hired"
                    />
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <label>Position</label>
                    <vue-tags-input
                        v-model="pos"
                        v-if="positions.length"
                        :tags="data.positions"
                        :autocomplete-items="filteredPositions"
                        :add-only-from-autocomplete="true"
                        :max-tags="5"
                        @tags-changed="newPosition => data.positions = newPosition"
                        placeholder="Enter Position"
                    />
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <label>Shift</label>
                    <select2 v-if="shifts && shifts.length" :options="shifts" :value="shiftDefault" @select="setWorkShift($event)">
                        <option value="UNASSIGNED">Unassigned</option>
                        <template slot="bot">
                            <option value="CUSTOM">Custom</option>
                        </template>
                    </select2>
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <label>From</label>
                    <flat-pickr
                     v-model="data.shift.startTime"
                     :config="getConfig(false)"
                     placeholder="Select a time"
                     name="start_time"
                     />
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <label>To</label>
                    <flat-pickr
                     v-model="data.shift.endTime"
                     :config="getConfig(false)"
                     placeholder="Select a time"
                     name="end_time"
                     />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="form-group" :class="{'has-error': errors.has('first_name')}">
                    <label>First Name<span class="error">*</span></label>
                    <input type="text" v-validate="'required'" ref="firstName" name="first_name" class="form-control" v-model="data.info.name.first" />
                    <span v-show="errors.has('first_name')" class="help-block form-error">{{ errors.first('first_name') }}</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group" :class="{'has-error': errors.has('middle_name')}">
                    <label>Middle Name</label>
                    <input type="text" v-validate="'required'" name="middle_name" class="form-control" v-model="data.info.name.middle" />
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group" :class="{'has-error': errors.has('last_name')}">
                    <label>Last Name<span class="error">*</span></label>
                    <input type="text" v-validate="'required'" name="last_name" class="form-control" v-model="data.info.name.last" />
                    <span v-show="errors.has('last_name')" class="help-block form-error">{{ errors.first('last_name') }}</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-1">
                <div class="form-group">
                    <label>Suffix</label>
                    <input type="text" name="ext" class="form-control" v-model="data.info.name.ext" />
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <div class="form-group">
                    <label>Nickname</label>
                    <input type="text" name="nick_name" class="form-control" v-model="data.info.name.nick" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group" :class="{'has-error': errors.has('present_address')}">
                    <label>Present Address</label>
                    <div class="input-group">
                        <input type="text" name="present_address" class="form-control" :value="address('present')" :disabled="true" />
                        <span class="input-group-input">
                            <button class="btn btn-primary employee-no-button" type="button" @click="open('present')">
                                <i class="la la-ellipsis-h"></i>
                            </button>
                        </span>
                    </div>
                    <span v-show="errors.has('present_address')" class="help-block form-error">{{ errors.first('present_address') }}</span>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Date of Birth</label>
                    <flat-pickr
                     v-model="data.info.dateOfBirth"
                     :config="getConfig(true, false, {allowInput:true})"
                     placeholder="Select a date"
                     name="date_of_birth"
                     />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group" :class="{'has-error': errors.has('contact_no')}">
                    <label>Contact No<span class="error">*</span></label>
                    <input type="text" v-validate="'required'" name="contact_no" class="form-control" v-model="data.info.contactNo" />
                    <span v-show="errors.has('contact_no')" class="help-block form-error">{{ errors.first('contact_no') }}</span>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Civil Status</label>
                    <select2
                     :options="civilStatus.options"
                     :value="civilStatus.value"
                     @select="setCivilStatus($event)"
                     />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Permanent Address</label>
                    <div class="input-group">
                        <input type="text" name="permanent_address" class="form-control" :value="address('permanent')" :disabled="true" />
                        <span class="input-group-input">
                            <button class="btn btn-primary employee-no-button" type="button" :disabled="data.info.address.sameAsPresent" @click="open('permanent')">
                                <i class="la la-ellipsis-h"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2" style="display: flex; align-items: center">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="is_present" name="is_present" class="custom-control-input" @change="toggleIsPresentAddress" v-model="data.info.address.sameAsPresent" />
                    <label class="custom-control-label" for="is_present">Same as the Present Address</label>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Gender</label>
                    <select2
                        :value="genderDefault"
                        :options="gender"
                        @select="data.info.gender = $event"
                     >
                        <option value="">Select Gender</option>
                     </select2>
                </div>
            </div>
        </div>
        <!-- BEGIN MODAL -->
        <modal-dialog v-show="isModalVisible" :title="'Add Address'" :options="modal" @close="closeModal">
            <address-form :data="addressRef" @success="addAddress($event)" @close="closeModal"></address-form>
        </modal-dialog>
        <!-- END MODAL -->
    </div>
</template>

<style lang="scss" scoped>
.custom-control-label:after {
    left: -22px !important;
}

.employee-no-button {
    border-radius: 0;
    font-size: 20px;
    padding: 2px 14px;
}
</style>

<script>
import Select2 from '@components/select2.vue';
import ModalDialog from '@components/modal-dialog.vue';
import FlatPickr from 'vue-flatpickr-component';
import { Validator } from 'vee-validate';
import VueTagsInput from '@johmun/vue-tags-input';
import 'flatpickr/dist/flatpickr.css';
import DatePickerMixin from '@common/mixin/DatePicker';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import GenerateButton from '@components/form/button.vue';
import AddressForm from '@views/pages/employee/_forms/address.vue';
import { mapGetters } from 'vuex';
import _ from 'lodash';

// custom validator rule
Validator.extend('employee_no', {
    getMessage: field => `Invalid ${field} format, must be FS-####`,
    validate: function(value) {
        let regx = /^FS-0*([1-9][0-9]*)$/i;
        return regx.test(value);
    }
});

export default {
    props: {
        data: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            manualInput: false,
            isPresent: false,
            addressRef: null,
            addressRefPath: null,
            genderDefault: [''],
            gender: [
                {id: 'Male', text: 'Male'},
                {id: 'Female', text: 'Female'}
            ],
            modal: {
                width: '800px',
                height: '445px'
            },
            civilStatus: {
                options: [
                    {id: 'Single', text: 'Single'},
                    {id: 'Married', text: 'Married'},
                    {id: 'Separated', text: 'Separated'},
                    {id: 'Divorced', text: 'Divorced'},
                    {id: 'Widowed', text: 'Widowed'}
                ],
                value: ['Single']
            },
            temp: '',
            tempEmpNo: '',
            pos: '',
            loading: false,
            button: {
                class: 'btn btn-primary employee-no-button',
                type: 'button'
            },
            shiftDefault: ['UNASSIGNED']
        }
    },
    components: {
        FlatPickr,
        Select2,
        VueTagsInput,
        GenerateButton,
        ModalDialog,
        AddressForm
    },
    computed: {
        ...mapGetters({
            shifts: 'workShifts/formatted',
            positions: 'jobPositions/formatted'
        }),
        address: function() {
            return (address) => {
                const info = this.data.info.address[address];
                const _address = [
                    info.houseNo,
                    info.street,
                    info.barangay,
                    info.townCity,
                    info.province,
                    info.zipCode
                ];

                return _address.join(' ');
            }
        },
        filteredPositions: function() {
            return this.positions.filter(p => new RegExp(this.pos, 'i').test(p.text));
        }
    },
    created() {
        // get new employee no
        this._generateEmployeeNo();
        this.addressRef = this.data.info.address.present;
    },
    methods: {
        open(pathRef) {
            this.addressRef = _.cloneDeep(this.data.info.address[pathRef]);
            this.addressRefPath = pathRef;
            this.openModal();
        },
        toggleIsPresentAddress() {
            this.isPresent = !this.isPresent;

            if (this.isPresent) {
                this.temp = this.data.info.address.permanent;
                this.data.info.address.permanent = this.data.info.address.present;
            } else {
                this.data.info.address.permanent = this.temp;
            }
        },
        _manualInput() {
            this.manualInput = true;
            this.data.info.employeeNo = this.tempEmpNo;

            $(this.$refs.employeeNo).trigger('focus');
        },
        _generateEmployeeNo() {
            this.manualInput = false;
            this.loading = true;
            this.tempEmpNo = this.data.info.employeeNo;
            this.data.info.employeeNo = '';

            this.generateEmployeeNo().then((newEmpNo) => {
                this.data.info.employeeNo = newEmpNo;
                this.loading = false;
                $(this.$refs.firstName).trigger('focus');
            });
        },
        setCivilStatus(status) {
            this.data.info.civilStatus = status;
        },
        setWorkShift(_shift) {
            this.data.shift.shiftId = _shift;
        },
        addAddress(data) {
            this.data.info.address[this.addressRefPath] = data;
        }
    },
    mixins: [
        DatePickerMixin,
        EmployeeMixin,
        ModalDialogMixin
    ]
}
</script>
