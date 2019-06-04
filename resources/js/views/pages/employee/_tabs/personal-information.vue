<template>
    <div class="fs-accordion" :class="accordionClasses">
        <div class="fs-field">
            <div class="card panel panel-default ks-information ks-light">
                <div class="card-header" @click.stop="toggleAccordion">
                    <h4 class="ks-text">
                        Basic Information
                    </h4>
                    <Can I="update" a="employee_profile">
                        <a href="#personal-information" class="btn ks-light ks-no-text" @click.stop="open = true">
                            <span class="la la-edit ks-icon"></span>
                        </a>
                    </Can>
                </div>
                <div class="card-block fs-accordion-content">
                    <div class="fs-info-wrapper">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-6">
                                <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">First Name</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? employee.first_name : '' }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Middle Name</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                    <strong>{{ (employee) ? employee.middle_name || '-' : ''  }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                    <label class="basicInfoLabel">Last Name</label>:
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? employee.last_name : '' }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div v-if="employee && employee.ext" class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Suffix</label>
                                    </div>
                                    <div v-if="employee && employee.ext" class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? employee.ext || '-' : '' }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div v-if="employee && employee.nick_name" class="ol-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Nickname</label>
                                    </div>
                                    <div v-if="employee && employee.nick_name" class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? employee.nick_name || '-' : '' }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Date of Birth</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? dateOfBirth(employee.date_of_birth) || '-' : '' }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Age</label>:
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? getAge(employee.date_of_birth) || '-' : '' }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Civil Status</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? employee.civil_status || '-' : '' }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                   <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Contact No</label>
                                   </div>
                                   <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (this.employee.contacts && this.employee.contacts.data.length && this.employee.contacts.data[0].home_no != null) ? this.employee.contacts.data[0].home_no : '-' }}</strong>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Mobile No</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (this.employee.contacts && this.employee.contacts.data.length && this.employee.contacts.data[0].mobile_no != null) ? this.employee.contacts.data[0].mobile_no : '-' }}
                                        </strong>
                                    </div>
                                </div>
                               <div class="row top-buffer">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <label class="basicInfoLabel">Alternate Email</label>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                        <strong>{{ (employee) ? employee.email || '-' : '' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <h5>Address</h5>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Present Address</label>
                                    <span class="ks-text">{{ (employee.address && employee.address.data) ? presentAddress(employee.address.data) || '-' : '-' }}</span>
                                </div>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Permanent Address</label>
                                    <span class="ks-text">{{ (employee.address && employee.address.data) ? permanentAddress(employee.address.data) || '-' : '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="employee && employee.contactPerson" class="row mb-3">
                            <div class="col-lg-12">
                                <h5>Contact Person in case of emergency</h5>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Name</label>
                                    <span class="ks-text">{{ employee.contactPerson ? employee.contactPerson.data.name : '-' }}</span>
                                </div>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Contact No</label>
                                    <span class="ks-text">{{ employee.contactPerson ? employee.contactPerson.data.contact_no : '-' }}</span>
                                </div>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Address</label>
                                    <span class="ks-text">{{ employee.contactPerson ? employee.contactPerson.data.address : '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="employee && employee.spouse" class="row mb-3">
                            <div class="col-lg-12">
                                <h5>Spouse</h5>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Name</label>
                                    <span class="ks-text">{{ employee.spouse ? employee.spouse.data.name : '-' }}</span>
                                </div>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Contact No</label>
                                    <span class="ks-text">{{ employee.spouse ? employee.spouse.data.contact_no : '-' }}</span>
                                </div>
                                <div class="fs-info-flex flex-row">
                                    <label class="basicInfoLabel">Address</label>
                                    <span class="ks-text">{{ employee.spouse? employee.spouse.data.address : '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3" v-if="employee && employee.dependents && employee.dependents.data && employee.dependents.data.length">
                             <div class="col-lg-12">
                                <h5>Dependents</h5>
                                <div class="fs-info-flex flex-row">
                                    <table class="depTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Date of Birth</th>
                                            <th>Relationship</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(dep, i) in employee.dependents.data" v-bind:key="dep.id" >
                                            <td class="basicInfoLabel">{{i+1}}.</td>
                                            <td>{{dep.name}}</td>
                                            <td>{{dateOfBirth(dep.birthdate)}}</td>
                                            <td>{{dep.relationship}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN MODAL -->
        <personal-information-modal v-if="open" :openModal="open" @success="updateData" @close="open = false"></personal-information-modal>
        <!-- END MODAL -->
    </div>
</template>
<style>
.depTable th, td {
    padding: 10px;
    text-align: left;
}
.top-buffer { margin-bottom:10px; }
</style>

<script>
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import AccordionMixin from '@common/mixin/AccordionMixin';
import PersonalInformationModal from '@views/pages/employee/_modals/personal-information.vue';
import { mapGetters, mapActions } from 'vuex';

export default {
    data() {
        return {
            open: false,
            isOpen: true
        }
    },
    mixins: [
        EmployeeMixin,
        AccordionMixin
    ],
    components: {
        PersonalInformationModal
    },
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        })
    },
    methods: {
        async updateData() {
            this.$emit('success');
            this.open = false;
        },
        getAge(birthday) {
            let birthdate = Date.parse(birthday);
            let age = ~~((Date.now() - birthdate) / (31557600000));
            return age;
        }
    }
}
</script>
