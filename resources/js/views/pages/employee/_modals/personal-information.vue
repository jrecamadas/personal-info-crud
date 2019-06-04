<template>
    <modal-dialog v-show="openModal" :title="'Personal Information'" :options="option" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :disabled="errors.count() > 0" @action="save">Save</save-button>
        </template>
        <template slot="body">
            <div class="s-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                <ul class="nav ks-nav-tabs">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" data-toggle="tab" data-target="#general" aria-expanded="true">
                            General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="tab" data-target="#address" aria-expanded="false">
                            Address
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="tab" data-target="#emergency" aria-expanded="false">
                            In Case of Emergency
                        </a>
                    </li>
                    <li class="nav-item" v-if="formData.info.civil_status == 'Married'">
                        <a href="#" class="nav-link" data-toggle="tab" data-target="#spouse" aria-expanded="false">
                            Spouse
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="tab" data-target="#dependents" aria-expanded="false">
                            Dependents
                        </a>
                    </li>
                </ul>
                <!-- BEGIN TAB CONTENT -->
                <div class="tab-content">
                    <!-- BEGIN GENERAL -->
                    <div class="tab-pane active" id="general" role="tabpanel" aria-expanded="false">
                        <div class="row padding-row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group" :class="{'has-error': errors.has('first_name')}">
                                    <label>First Name<span class="error">*</span></label>
                                    <input v-model="formData.info.first_name" v-validate="'required'" name="first_name" type="text" class="form-control" autofocus />
                                    <span v-show="errors.has('first_name')" class="help-block form-error">{{ errors.first('first_name') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group" :class="{'has-error': errors.has('middle_name')}">
                                    <label>Middle Name</label>
                                    <input v-model="formData.info.middle_name" name="middle_name" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group" :class="{'has-error': errors.has('last_name')}">
                                    <label>Last Name<span class="error">*</span></label>
                                    <input v-model="formData.info.last_name" v-validate="'required'" name="last_name" type="text" class="form-control" />
                                    <span v-show="errors.has('last_name')" class="help-block form-error">{{ errors.first('last_name') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group" :class="{'has-error': errors.has('suffix')}">
                                    <label>Suffix</label>
                                    <input v-model="formData.info.ext" name="suffix" v-validate="'alpha_num'" type="text" class="form-control" />
                                    <span v-show="errors.has('suffix')" class="help-block form-error">{{ errors.first('suffix') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Nickname</label>
                                    <input v-model="formData.info.nick_name" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': errors.has('date_of_birth')}">
                                            <label>Date of Birth</label>
                                            <flat-pickr
                                                v-model="formData.info.date_of_birth"
                                                placeholder="Select a date"
                                                :config="getConfig(true, false, {maxDate: 'today', allowInput:true})"
                                                name="date_of_birth"
                                                @on-change="listenToOnChangeEventDateOfBirth"
                                                v-validate="'lessthan'"
                                            />
                                            <span v-show="errors.has('date_of_birth')" class="help-block form-error">Date of Birth is not valid. Age is less than 18</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label>Age</label>
                                                <input :value="formData.age"  type="text" name="age" id="age" class="form-control" readonly />
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alternate Contact No</label>
                                                <input @keypress="checkContactNumber" :placeholder="'(..) ....-...-...'" v-mask="'## ####-###-###'"  v-model="formData.contact.home_no" type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mobile No</label>
                                                <input @keypress="checkContactNumber" :placeholder="'(..) ....-...-...'" v-mask="'## ####-###-###'"  v-model="formData.contact.mobile_no" type="text" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                 <div class="form-group" :class="{'is-invalid': errors.has('email')}">
                                    <label>Alternate Email</label>
                                    <input v-model="formData.info.email" v-validate="'email'" name="email" type="email" class="form-control" />
                                    <span v-show="errors.has('email')" class="help-block form-error" style="color:#ef5350;">{{ errors.first('email') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Civil Status</label>
                                    <select2
                                        :options="civilStatus"
                                        :value="civilStatusDefault"
                                        @select="formData.info.civil_status = $event"
                                    />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select2
                                                    :options="gender"
                                                    :value="genderDefault"
                                                    @select="formData.info.gender = $event"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END GENERAL -->
                    <!-- BEGIN ADDRESS -->
                    <div class="tab-pane" id="address" role="tabpanel" aria-expanded="false">
                        <div class="row padding-row-address">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a class="address-wrapper flex link" @click="toggleAddress">
                                        <label>Present Address</label>
                                        <i v-if="activeAddress == 'present'" class="la la-caret-up"></i>
                                        <i v-else class="la la-caret-down"></i>
                                    </a>
                                    <div v-show="activeAddress == 'present'">
                                        <div class="address-wrapper">
                                            <input v-model="formData.address.present.line_1" type="text" name="line_1" placeholder="Address Line 1" class="form-control" />
                                        </div>
                                        <div class="address-wrapper">
                                            <input v-model="formData.address.present.line_2" type="text" name="line_2" placeholder="Address Line 2" class="form-control" />
                                        </div>
                                        <div class="address-wrapper flex">
                                            <input v-model="formData.address.present.city" type="text" name="city" placeholder="City" class="form-control" />
                                            <input v-model="formData.address.present.state_province" type="text" name="state_province" placeholder="State / Province" class="form-control" />
                                        </div>
                                        <div class="address-wrapper flex">
                                            <input v-model="formData.address.present.postal_zip_code" type="text" name="zip_code" placeholder="Postal / Zip Code" class="form-control" />
                                            <select2
                                                v-if="countriesReady"
                                                :options="countries"
                                                :value="formData.address.present.country_id"
                                                @select="formData.address.present.country_id = $event"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a class="address-wrapper flex link" @click="toggleAddress">
                                        <label>Permanent Address</label>
                                        <i v-if="activeAddress == 'permanent'" class="la la-caret-up"></i>
                                        <i v-else class="la la-caret-down"></i>
                                    </a>
                                    <div v-show="activeAddress == 'permanent'">
                                        <div class="custom-control custom-checkbox">
                                            <input v-model="sameAsPresent" type="checkbox" id="is_present" name="is_present" class="custom-control-input" />
                                            <label class="custom-control-label" for="is_present">Same as the Present Address</label>
                                        </div>
                                        <fieldset :disabled="sameAsPresent">
                                            <div class="address-wrapper">
                                                <input v-model="formData.address.permanent.line_1" type="text" name="line_1" placeholder="Address Line 1" class="form-control" />
                                            </div>
                                            <div class="address-wrapper">
                                                <input v-model="formData.address.permanent.line_2" type="text" name="line_2" placeholder="Address Line 2" class="form-control" />
                                            </div>
                                            <div class="address-wrapper flex">
                                                <input v-model="formData.address.permanent.city" type="text" name="city" placeholder="City" class="form-control" />
                                                <input v-model="formData.address.permanent.state_province" type="text" name="state_province" placeholder="State / Province" class="form-control" />
                                            </div>
                                            <div class="address-wrapper flex">
                                                <input v-model="formData.address.permanent.postal_zip_code" type="text" name="zip_code" placeholder="Postal / Zip Code" class="form-control" />
                                                <select2
                                                    v-if="countriesReady"
                                                    :options="countries"
                                                    :value="formData.address.permanent.country_id"
                                                    :disabled="sameAsPresent"
                                                    @select="formData.address.permanent.country_id = $event"
                                                />
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END ADDRESS -->
                    <!-- BEGIN IN CASE OF EMERGENCY -->
                    <!-- END IN CASE OF EMERGENCY -->
                    <div class="tab-pane" id="emergency" role="tabpanel" aria-expanded="false">
                        <div class="row padding-row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="formData.emergency.name" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Contact No</label>
                                    <input v-model="formData.emergency.contact_no" :placeholder="'(..) ....-...-...'" v-mask="'## ####-###-###'"  type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input v-model="formData.emergency.address" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN SPOUSE -->
                    <div class="tab-pane" v-if="formData.info.civil_status == 'Married'" id="spouse" role="tabpanel" aria-expanded="false">
                        <div class="row padding-row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Spouse Name</label>
                                    <input v-model="formData.spouse.name" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Spouse Contact No</label>
                                    <input v-model="formData.spouse.contact_no" :placeholder="'(..) ....-...-...'" v-mask="'## ####-###-###'" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Spouse Address</label>
                                    <input v-model="formData.spouse.address" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END SPOUSE -->
                    <!-- BEGIN DEPENDENTS -->
                    <div class="tab-pane" id="dependents" role="tabpanel" aria-expanded="false">
                        <div class="row padding-row">
                            <div class="col-lg-12 ">
                                 <button class="btn btn-success" @click="addNewDependentForm">Add Dependent</button>
                                <div class="form-group scroll">
                                        <div class="card mt-2" v-for="(dep, i) in formData.dependent">
                                            <div class="card-body">
                                                <span class="float-right" style="cursor:pointer" @click="deleteDependent(i, dep.id )">X</span>
                                                <h5 class="card-title mb-0">Dependent {{ i + 1 }}</h5>

                                            </div>
                                            <div class="dependents-form">
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-4">
                                                        <div class="form-group" >
                                                            <input v-model="dep.name" type="text" class="form-control" placeholder="Name"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                            <flat-pickr
                                                            v-model="dep.birthdate"
                                                            :config="getConfig(true, false, {maxDate: 'today', allowInput: true})"
                                                            placeholder="Date of Birth"
                                                            name="dateofbirth"
                                                            class="form-control"
                                                           />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4">
                                                            <input v-model="dep.relationship" type="text" class="form-control" placeholder="Relationship"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- END DEPENDENTS -->
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
    .ks-tabs-container.ks-full {
        .ks-nav-tabs {
            padding-left: 0;
        }
    }
    .row {
        margin-top: 0;
    }
    .address-wrapper {
        margin: 5px 0;
        &.flex {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            input:first-child {
                margin-right: 5px;
            }
            &.link {
                cursor: pointer;
            }
        }
    }
    .custom-control {
        &.custom-checkbox {
            margin-bottom: 15px;
        }
        .custom-control-label::after {
            left: -22px !important;
        }
    }
    // .dependents-form{
    //     width: 50%;
    // }
    .scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .nav-link.active {
        border-bottom: 3px solid #42a5f5;
    }
    .scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }


</style>
<style>
.v-dialog.active, .v-dialog:target {
    z-index: 10000 !important;
}
.padding-row{
    padding-top: 15px;
}
.padding-row-address{
    padding-top: 10px;
}
</style>

<script>
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import DatePickerMixin from '@common/mixin/DatePicker';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ObjectHelperMixin from '@common/mixin/ObjectHelperMixin';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import Select2 from '@components/select2.vue';
import { mapGetters, mapActions } from 'vuex';
import { Validator } from 'vee-validate';
import { Address } from '@common/model/Address';
import _ from 'lodash';
import { mask } from 'vue-the-mask';

//create my own rules for date of birth if the age is less than 18
const isLessThan = (value) => {
        let birthdate = Date.parse(value);
        let ages = ~~((Date.now() - birthdate) / (31557600000));
        let r = (18 <= ages) ? true : false;
        return r;
};
Validator.extend('lessthan', isLessThan, {});
//end rules

export default {
    directives: {
        mask
    },
    data() {
        return {
            loading: false,
            activeAddress: 'present',
            sameAsPresent: false,
            formData: {
                info: {
                    first_name: '',
                    last_name: '',
                    middle_name: '',
                    ext: '',
                    nick_name: '',
                    date_of_birth: '',
                    civil_status: '',
                    email: '',
                    gender: ''
                },
                contact: {
                    id: null,
                    home_no: '',
                    mobile_no: ''
                },
                address: {
                    present: {id: null, line_1: '', line_2: '', city: '', state_province: '', postal_zip_code: '', country_id: '', is_present: 0, is_permanent: 0},
                    permanent: {id: null, line_1: '', line_2: '', city: '', state_province: '', postal_zip_code: '', country_id: '', is_present: 0, is_permanent: 0},
                    temp: {id: null, line_1: '', line_2: '', city: '', state_province: '', postal_zip_code: '', country_id: '', is_present: 0, is_permanent: 0}
                },
                emergency: {
                    id: null,
                    name: '',
                    contact_no: '',
                    address: ''
                },
                spouse: {
                    id: null,
                    name: '',
                    contact_no: '',
                    address: ''
                },
                age:'',
                dependent: [
                    {
                    id: null,
                    name: '',
                    birthdate: '',
                    relationship: ''
                    }
                ]
            },
            option: {
                width: '800px'
            }
        }
    },
    watch: {
        sameAsPresent: function(value) {
            if (value) {
                this.formData.address.temp = this.formData.address.permanent;
                this.formData.address.permanent = this.formData.address.present;
            } else {
                this.formData.address.permanent = this.formData.address.temp;
            }
        }
    },
    async created() {
        this.getCountries({query: {take: 9999, orderBy: 'name|asc'}});
        await this.initFormData();
    },
    destroyed() {
        this.resetCountries();
        this.clearData();
    },
    components: {
        SaveButton,
        ModalDialog,
        FlatPickr,
        Select2
    },
    mixins: [
        EmployeeMixin,
        ModalDialogMixin,
        StringHelperMixin,
        DatePickerMixin,
        ObjectHelperMixin,
        AlertMixin
    ],
    computed: {
        ...mapGetters({
            employee: 'employees/single',
            civilStatus: 'civilStatus/formatted',
            civilStatusDefault: 'civilStatus/defaultVal',
            countries: 'countries/formatted',
            countryDefault: 'countries/defaultVal',
            countriesReady: 'countries/ready',
            gender: 'gender/formatted',
            genderDefault: 'gender/defaultVal'
        }),
        hasAddress: function() {
            return (address) => {
                let has = false;
                let keys = ['line_1', 'line_2', 'city', 'state_province', 'postal_zip_code'];
                _.each(keys, (key) => {
                    if (!this.isEmpty(this.formData.address[address][key])) {
                        has = true;
                        return;
                    }
                })
                return has;
            }
        },
        hasContact: function() {
            let has = false;
            _.forOwn(this.formData.contact, (value, key) => {
                if (key != 'id' && !this.isEmpty(this.formData.contact[key])) {
                    has = true;
                    return;
                }
            });

            return has;
        },
        hasContactPerson: function() {
            let has = false;
            _.forOwn(this.formData.emergency, (value, key) => {
                if (key != 'id' && !this.isEmpty(this.formData.emergency[key])) {
                    has = true;
                    return;
                }
            });

            return has;
        },
        hasSpouse: function() {
            let has = false;
            _.forOwn(this.formData.spouse, (value, key) => {
                if (key != 'id' && !this.isEmpty(this.formData.spouse[key])) {
                    has = true;
                    return;
                }
            });

            return has;
        },
        hasDependents: function() {
            let has = false;
            _.forOwn(this.formData.dependent, (value, key) => {
                _.forOwn(value, (_value, _key) => {
                    if(_key && _value !='')
                    {
                        has = true;
                    }
                });
            });

            return has;
        },
        valid: function() {
            return !this.isEmpty(this.formData.info.first_name) && !this.isEmpty(this.formData.info.last_name);
        }
    },
    methods: {
        ...mapActions({
            getCountries: 'countries/getCountries',
            resetCountries: 'countries/resetCountries',
            setCivilStatusDefault: 'civilStatus/setDefaultVal',
            setGenderDefault: 'gender/setDefaultVal',
            saveEmployeeSpouse: 'empSpouse/saveEmployeeSpouse',
            saveContactPerson: 'contactPerson/saveContactPerson',
            saveEmployeeDependent: 'empDependent/saveEmployeeDependent',
            deleteEmployeeDependent: 'empDependent/deleteEmployeeDependent',
            saveAddress: 'empaddress/saveAddress',
            saveContact: 'contact/saveContact'
        }),
        initFormData() {
            this.formData.info = this.setValueFrom(this.formData.info, this.employee);
            this.formData.age = this.getAge(this.formData.info.date_of_birth);
            this.formData.info.gender = this.formData.info.gender || 'Male';
            this.formData.address.present.country_id = this.employee.address.data.filter(a => a.is_present == 1).length ? this.employee.address.data.filter(a => a.is_present == 1)[0].country.data.id : this.countryDefault[0];
            this.formData.address.permanent.country_id = this.employee.address.data.filter(a => a.is_permanent == 1).length ? this.employee.address.data.filter(a => a.is_permanent == 1)[0].country.data.id : this.countryDefault[0];
            this.setCivilStatusDefault(this.formData.info.civil_status);
            this.setGenderDefault(this.formData.info.gender);

            if(this.employee.contacts) {
                this.formData.contact = this.setValueFrom(this.formData.contact, this.employee.contacts.data[0]);
            }

            if (this.employee.address) {
                const _present = this.getAddress('present');
                const _permanent = this.getAddress('permanent');

                if (_present) this.formData.address.present = this.setValueFrom(this.formData.address.present, _present);
                if (_permanent) this.formData.address.permanent = this.setValueFrom(this.formData.address.permanent, _permanent);

                this.sameAsPresent = this.formData.address.present.is_permanent == 1;
            }

            if (this.employee.contactPerson) {
                this.formData.emergency = this.setValueFrom(this.formData.emergency, this.employee.contactPerson.data);
            }
            if (this.employee.spouse) {
                this.formData.spouse = this.setValueFrom(this.formData.spouse, this.employee.spouse.data);
            }

            if (this.employee.dependents.data.length) {
                this.formData.dependent = _.orderBy(this.employee.dependents.data,'order','asc');;
                // console.log(this.formData.dependent);
            }  else {
                this.addNewDependentForm();
            }
        },
        save() {
            this.loading = true;

            this.employee.save(this.formData.info).then(({data}) => {
                let promises = [];

                promises.push(
                    this.saveContact({
                        id: this.formData.contact.id,
                        employee_id: this.employee.id,
                        home_no: this.formData.contact.home_no,
                        mobile_no: this.formData.contact.mobile_no
                    })
                );

                if (this.hasContactPerson) {
                    promises.push(
                        this.saveContactPerson({
                            id: this.formData.emergency.id,
                            employee_id: this.employee.id,
                            name: this.formData.emergency.name,
                            address: this.formData.emergency.address,
                            contact_no: this.formData.emergency.contact_no
                        })
                    );
                }

                if (this.hasSpouse) {
                    promises.push(
                        this.saveEmployeeSpouse({
                            id: this.formData.spouse.id,
                            employee_id: this.employee.id,
                            name: this.formData.spouse.name,
                            address: this.formData.spouse.address,
                            contact_no: this.formData.spouse.contact_no
                        })
                    );
                }

                if (this.hasDependents) {
                        let id = null;
                        let name = '';
                        let dob = '';
                        let rel = '';
                     _.forOwn(this.formData.dependent, (value, key) => {
                         _.forOwn(value, (_value, _key) => {
                                id = value['id'];
                                name = value['name'];
                                dob = value['birthdate'];
                                rel = value['relationship'];
                            });

                            if(name) {
                                promises.push(
                                    this.saveEmployeeDependent({
                                        id: id,
                                        employee_id: this.employee.id,
                                        name: name,
                                        date_of_birth: dob,
                                        relationship: rel,
                                        order: key
                                    })
                                );
                            }
                        });
                }

                if (this.hasAddress('present')) {

                    promises.push(
                        this.saveAddress({
                            id: this.formData.address.present.id,
                            employee_id: this.employee.id,
                            country_id: this.formData.address.present.country_id,
                            line_1: this.formData.address.present.line_1,
                            line_2: this.formData.address.present.line_2,
                            city: this.formData.address.present.city,
                            state_province: this.formData.address.present.state_province,
                            postal_zip_code: this.formData.address.present.postal_zip_code,
                            is_present: 1,
                            is_permanent: this.sameAsPresent ? 1 : 0
                        })
                    );
                }

                if (this.hasAddress('permanent')) {
                    if (!this.sameAsPresent) {

                        promises.push(
                            this.saveAddress({
                                id: this.formData.address.permanent.id,
                                employee_id: this.employee.id,
                                country_id: this.formData.address.permanent.country_id,
                                line_1: this.formData.address.permanent.line_1,
                                line_2: this.formData.address.permanent.line_2,
                                city: this.formData.address.permanent.city,
                                state_province: this.formData.address.permanent.state_province,
                                postal_zip_code: this.formData.address.permanent.postal_zip_code,
                                is_permanent: 1
                            })
                    );
                    } else {
                        if (this.formData.address.temp.id && this.formData.address.temp.id != this.formData.address.present.id) {
                            // delete previous data saved as permanent address
                            let address = this.formData.address.permanent.id = new Address({id: this.formData.address.temp.id});

                            promises.push(address.delete());
                        }
                    }
                }

                Promise.all(promises).then(() => {
                    this.loading = false;
                    this.$emit('success');
                    this.notifyDialog('success', 'Successfully saved!');
                });
            });
        },
        toggleAddress() {
            this.activeAddress = this.activeAddress == 'present' ? 'permanent' : 'present';
        },
        getAddress(address) {
            const _address = this.employee.address.data.filter(a => a[`is_${address}`] == 1);
            return _address.length ? _address[0] : null;
        },
        clearData() {
            // address
            _.forOwn(this.formData.address, (value, key) => {
                _.forOwn(value, (_value, _key) => {
                    if (_key == 'id') this.formData.address[key][_key] = null;
                    else if (_key == 'is_present' || _key == 'is_permanent') this.formData.address[key][_key] = 0;
                    else if (_key == 'country_id') this.formData.address[key][_key] = this.countryDefault[0];
                    else this.formData.address[key][_key] = '';
                });
            });

            // contact person
            _.forOwn(this.formData.emergency, (value, key) => {
                if (key == 'id') this.formData.emergency[key] = null;
                else this.formData.emergency[key] = '';
            });

            //info
            for (const prop in this.formData.info) {
                if (this.formData.info.hasOwnProperty(prop)) {
                    this.formData.info[prop] = '';
                }
            }
        },
        addNewDependentForm()
        {
            this.formData.dependent.push({
                id: null,
                name: '',
                birthdate: '',
                relationship: '',
            })
        },
        getAge(birthday)
        {
            let birthdate = Date.parse(birthday);
            let age = ~~((Date.now() - birthdate) / (31557600000));
            this.formData.age = age;
            return age;
        },
        deleteDependent(i,id){
            this.confirmDialog("Removing Dependent...", "Are you sure you want to delete?", "Yes", "Cancel", "sm").then((res)=>{
                if(res.ok){
                    if(id)
                    {
                        this.deleteEmployeeDependent(id).then((res) => {
                            this.formData.dependent.splice(i,1);
                        });
                    }
                    else{
                        this.formData.dependent.splice(i,1);
                    }
                }
            });
        },
        listenToOnChangeEventDateOfBirth(selectedDates, dateStr, instance) {
            this.getAge(dateStr);
      },
    }
}
</script>
