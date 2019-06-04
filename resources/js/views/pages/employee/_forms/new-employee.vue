<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title"></page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="ks-form-steps-progress">
                <div class="ks-form-steps-progress-header">
                    <h3>Add New Employee</h3>
                    <div class="ks-decription">
                        Field marked with <span class="error">*</span> is required.
                    </div>
                </div>
                <div class="ks-form-steps-progress-body">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" :style="'width:' + progress + '%'" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="ks-step-items">
                        <a href="#" class="ks-step-item" :class="{'ks-completed': step == 2}">General Information</a>
                        <a href="#" class="ks-step-item" :class="{'ks-completed': step == 3}">Skills & Proficiencies</a>
                        <a href="#" class="ks-step-item" :class="{'ks-completed': step == 4}">Work Experience</a>
                        <a href="#" class="ks-step-item" :class="{'ks-completed': step == 5}">Education</a>
                    </div>
                </div>
            </div>
            <div class="ks-form-steps-progress-wrapper">
                <div class="ks-form-steps-progress-content">
                    <div class="ks-form-steps-progress-content-wrapper ks-scrollable">
                        <div class="ks-scroll-wrapper">
                            <form class="ks-step">
                                <!-- BEGIN STEP 1: GENERAL INFORMATION -->
                               <general-information v-show="step == 1" :data="employeeData"></general-information>
                                <!-- END STEP 1: GENERAL INFORMATION -->
                                <!-- BEGIN STEP 2: SKILLS AND PROFICIENCIES -->
                                <skills-and-proficiencies v-show="step == 2" :data="employeeData"></skills-and-proficiencies>
                                <!-- END STEP 2: SKILLS AND PROFICIENCIES -->
                                <!-- BEGIN STEP 4: EDUCATION -->
                                <education-attainment v-show="step == 4" :data="employeeData"></education-attainment>
                                <!-- END STEP 4: EDUCATION -->
                            </form>
                        </div>
                    </div>
                    <div class="ks-controls ks-flex-end">
                        <button class="btn btn-outline-primary ks-light ks-previous" @click="prevStep" :disabled="step == 1 || loading">Back</button>
                        <button class="btn btn-primary ks-next" v-show="step < 4" @click="nextStep" :disabled="!valid">Next Step</button>
                        <save-button v-show="step == 4" :loading="loading" :options="button" @action="save">Save & Done</save-button>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
    </div>
</template>

<style lang="scss"scoped>
.ks-form-steps-progress-page
.ks-form-steps-progress-content
.ks-form-steps-progress-content-wrapper {
    height: auto !important;
}
.custom-control-label:after {
    left: -22px !important;
}
</style>

<script>
import PageHeader from '@components/page-header.vue';
import PageContent from '@components/page-content.vue';
import GeneralInformation from '@views/pages/employee/_forms/_steps/general-information.vue';
import SkillsAndProficiencies from '@views/pages/employee/_forms/_steps/skills-and-proficiencies.vue';
import EducationAttainment from '@views/pages/employee/_forms/_steps/education.vue';
import SaveButton from '@components/form/button.vue';
import { Skill } from '@common/model/Skill';
import { EducationalAttainment } from '@common/model/EducationalAttainment';
import { Language } from '@common/model/Language';
import { JobPosition } from '@common/model/JobPosition';
import { Employee } from '@common/model/Employee';
import { EmployeeJobPosition } from '@common/model/EmployeeJobPosition';
import { EmployeeWorkShift } from '@common/model/EmployeeWorkShift';
import { EmployeeSkill } from '@common/model/EmployeeSkill';
import { WorkShift } from '@common/model/WorkShift';
import { EmployeeLanguage } from '@common/model/EmployeeLanguage';
import { EmployeeEducation } from '@common/model/EmployeeEducation';
import { Address } from '@common/model/Address';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import _ from 'lodash';
import { mapActions } from 'vuex';

export default {
    data() {
        return {
            pageClass: 'ks-form-steps-progress-page',
            title: 'Employee',
            step: 1,
            loading: false,
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            employeeData: {
                info: {
                    employeeNo: '',
                    dateHired: '',
                    name: {
                        first: '',
                        middle: '',
                        last: '',
                        ext: '',
                        nick: ''
                    },
                    dateOfBirth: '',
                    gender: '',
                    address: {
                        present: {
                            houseNo: '',
                            street: '',
                            barangay: '',
                            townCity: '',
                            province: '',
                            zipCode: '',
                            isPresent: false
                        },
                        permanent: {
                            hoseNo: '',
                            street: '',
                            barangay: '',
                            townCity: '',
                            province: '',
                            zipCode: '',
                            isPermanent: false
                        },
                        sameAsPresent: false
                    },
                    contactNo: '',
                    civilStatus: 'Single'
                },
                shift: {
                    shiftId: 'UNASSIGNED',
                    startTime: null,
                    endTime: null
                },
                positions: [],
                skillsAndProficiencies: {
                    skills: [],
                    languages: []
                },
                education: []
            },
            progress: 0,
            validation: [
                {path: 'employeeNo', name: 'employee_no', rule: 'required', msg: {requred: 'Employee No is required'}},
                {path: 'name.first', name: 'first_name', rule: 'required', msg: {required: 'First Name is required'}},
                {path: 'name.last', name: 'last_name', rule: 'required', msg: {required: 'Last Name is required'}},
                {path: 'contactNo', name: 'contact_no', rule: 'required', msg: {required: 'Contact No is required'}}
            ]
        }
    },
    created() {
        // load skills
        this.getSkills({query: {take: 9999}, extra: {proficiency: 5}});

        // load languages
        this.getLanguages({query: {take: 9999}, extra: {proficiency: {spoken: 5, written: 5}}});

        // load job positions
        this.getJobPositions({query: {take: 9999}, extra: {level: null}});

        // load attainments
        this.getEducationalAttainments({query: {take: 9999}});

        // load shifts
        this.getWorkShifts({query: {take: 9999}});
    },
    destroyed() {
        this.clearShifts();
    },
    components: {
        PageHeader,
        PageContent,
        GeneralInformation,
        SkillsAndProficiencies,
        EducationAttainment,
        SaveButton
    },
    computed: {
        valid: function() {
            let valid = true;

            // check validation form validation set rule
            _.each(this.validation, (form) => {
                // break validation rule
                let rules = form.rule.split('|');

                // validate accordingly
                _.each(rules, (rule) => {
                    if (rule == 'required') {
                        if (this.isEmpty(_.get(this.employeeData.info, form.path))) {
                            valid = false;
                            return;
                        }
                    }
                });

                if (!valid) return;
            });

            return valid;
        }
    },
    methods: {
        ...mapActions({
            getSkills: 'skills/getSkills',
            getLanguages: 'languages/getLanguages',
            getJobPositions: 'jobPositions/getJobPositions',
            getWorkShifts: 'workShifts/getWorkShifts',
            getEducationalAttainments: 'educationalAttainments/getEducationalAttainments',
            clearShifts: 'workShifts/clearItems'
        }),
        toggleIsPresentAddress() {
            this.isPresent = !this.isPresent;
        },
        nextStep() {
            console.log(this.employeeData, '__DATA__');
            this.progress += 25;
            this.step += 1;
        },
        prevStep() {
            this.progress -= 25;
            this.step -= 1;
        },
        save() {
            let promises = [];
            this.loading = true;

            let vm = this;

            // BEGIN SAVING
            const employee = new Employee();

            const data = {
                employee_no: this.employeeData.info.employeeNo,
                first_name: this.employeeData.info.name.first,
                last_name: this.employeeData.info.name.last,
                middle_name: this.employeeData.info.name.middle,
                nick_name: this.employeeData.info.name.nick,
                ext: this.employeeData.info.name.ext,
                date_of_birth: this.employeeData.info.dateOfBirth,
                civil_status: this.employeeData.info.civilStatus,
                gender: this.employeeData.info.gender,
                date_hired: this.employeeData.info.dateHired
            }

            employee.save(data).then((res) => {
                let employeeId = res.data.id;

                // save other related information
                // put in promises array
                // employee address
                if (vm.employeeData.info.address.permanent.isPermanent && !vm.employeeData.info.address.sameAsPresent) {
                    const data = {
                        employee_id: employeeId,
                        house_no: vm.employeeData.info.address.permanent.houseNo,
                        street: vm.employeeData.info.address.permenent.street,
                        barangay: vm.employeeData.info.address.permanent.barangay,
                        town_city: vm.employeeData.info.address.permanent.townCity,
                        province: vm.employeeData.info.address.permanent.province,
                        zip_code: vm.employeeData.info.address.permanent.zip_code,
                        is_present: 0,
                        is_permanent: 1
                    };
                    const address = new Address();
                    promises.push(address.save(data));
                } else {
                    if (vm.employeeData.info.address.present.isPresent) {
                        const data = {
                            employee_id: employeeId,
                            house_no: vm.employeeData.info.address.present.houseNo,
                            street: vm.employeeData.info.address.present.street,
                            barangay: vm.employeeData.info.address.present.barangay,
                            town_city: vm.employeeData.info.address.present.town_city,
                            province: vm.employeeData.info.address.present.province,
                            zip_code: vm.employeeData.info.address.present.zip_code,
                            is_present: 1,
                            is_permanent: this.data.info.address.sameAsPresent ? 1 : 0
                        };
                        const address = new Address();
                        promises.push(address.save(data));
                    }
                }

                // employee position
                if (vm.employeeData.positions.length) {
                    const employeeJobPosition = new EmployeeJobPosition();
                    const data = {
                        employee_id: employeeId,
                        position_id: vm.employeeData.positions[0].id
                    };
                    promises.push(employeeJobPosition.save(data));
                }

                // emplyee shift
                if (vm.employeeData.shift.shiftId != 'UNASSIGNED') {
                    let data = {
                        employee_id: employeeId
                    };

                    if (vm.employeeData.shift.shiftId == 'CUSTOM') {
                        data['start_time'] = vm.employeeData.shift.startTime;
                        data['end_time'] = vm.employeeData.shift.endTime;
                    } else {
                        data['shift_id'] = vm.employeeData.shift.shiftId;
                    }

                    const employeeWorkShift = new EmployeeWorkShift();
                    promises.push(employeeWorkShift.save(data));
                }

                // skills and proficiencies
                if (vm.employeeData.skillsAndProficiencies.languages.length) {
                    _.each(vm.employeeData.skillsAndProficiencies.languages, (l) => {
                        const data = {
                            employee_id: employeeId,
                            language_id: l.id,
                            written: l.proficiency.written,
                            spoken: l.proficiency.spoken
                        };
                        const employeeLanguage = new EmployeeLanguage();
                        promises.push(employeeLanguage.save(data));
                    });
                }

                if (vm.employeeData.skillsAndProficiencies.skills.length) {
                    _.each(vm.employeeData.skillsAndProficiencies.skills, (s) => {
                        const data = {
                            employee_id: employeeId,
                            skill_id: s.id,
                            proficiency: s.proficiency
                        };
                        const employeeSkill = new EmployeeSkill();
                        promises.push(employeeSkill.save(data));
                    });
                }

                // education
                if (vm.employeeData.education.length) {
                    _.each(vm.employeeData.education.length, (e) => {
                        const data = {
                            employee_id: employeeId,
                            educational_attainment_id: e.educationalAttainment,
                            course_degree: e.courseDegree,
                            school_university: e.schoolUniversity,
                            year_completed: e.yearCompleted
                        };
                        const employeeEducation = new EmployeeEducation();
                        promises.push(employeeEducation.save(data));
                    });
                }

                // run all promises
                Promise.all(promises).then((res) => {
                    vm.loading = false;
                    vm.$router.push({name: 'employee', params: {id: employeeId}});
                });
            });
        }
    },
    mixins: [
        StringHelperMixin
    ]
}
</script>
