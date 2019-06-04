<template>
    <modal-dialog v-show="openModal" :title="'Work Detail'" @close="closeModal" :options="option">
        <template slot="button">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <footer class="dialog-footer"> -->
                        <save-button :loading="loading" :options="button" :disabled="!valid || errors.count() > 0" @action="save">Save</save-button>
                    <!-- </footer>
                </div>
            </div> -->
        </template>
        <template slot="body">
            <div class="row form-group">
                <div class="col-lg-4">
                    <label>Employee ID</label>
                    <input type="text" name="employee_id" class="form-control" v-mask="'FS-####'" v-model="formData.employeeId" @keyup="isEmployeeNoAvailable" :disabled="!$can('update', 'employee_profile')"/>
                    <span v-show="errors.has('employee_id')" class="employeeIdEx" >{{ errors.first('employee_id') }}</span>
                    <span v-show="hasEmployeeIdErr" class="help-block form-error employeeIdEx" >{{ employeeIdErrMsg }}</span>
                </div>
                <div class="col-lg-8">
                    <label>Current Position</label>
                    <div class="current-position">
                        <div class="position-level">
                            <div class="position-el">
                                <select2
                                    :value="formData.level"
                                    :options="positionLevels"
                                    :style="'width: 110px'"
                                    @select="formData.level = $event"
                                    :disabled="!$can('update', 'employee_job_position')">
                                    <option value="0">&nbsp;&nbsp;---------</option>
                                </select2>
                            </div>
                        </div>
                        <div class="position">
                            <vue-tags-input
                                placeholder="Select Position"
                                v-if="positions.length"
                                v-model="formData.position"
                                :tags="formData.positions"
                                :add-only-from-autocomplete="true"
                                :autocomplete-items="filteredPositions"
                                :max-tags="1"
                                :disabled="!$can('update', 'employee_job_position')"
                                @tags-changed="newPosition => formData.positions = newPosition"
                                @before-adding-tag="addPosition"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-4">
                    <label>Date Hired</label>
                    <Can I="update" a="employee_profile">
                        <flat-pickr
                            name="date_hired"
                            placeholder="Select a date"
                            v-model="formData.dateHired"
                            :config="getConfig(true, false, { allowInput:true })"/>
                    </Can>
                    <Can not I="update" a="employee_profile">
                        <input type="text" name="date_hired" class="form-control" v-model="formData.dateHired" :disabled="true"/>
                    </Can>
                </div>
                <div class="col-lg-4">
                    <label>Employment Status</label>
                    <select2
                        v-if="employment_status.options.length"
                        :options="employment_status.options"
                        :value="employment_status.value"
                        :disabled="!$can('update', 'employee_status')"
                        @select="setRegularizationDate">
                    </select2>
                </div>
                <div class="col-lg-4">
                    <label>Regularization Date</label>
                    <Can I="update" a="employee_profile">
                        <flat-pickr
                            name="date_regularized"
                            placeholder="Select a date"
                            v-model="formData.regularizationDate"
                            :config="getConfig(true, false, { minDate:formData.dateHired, allowInput:true })"/>
                    </Can>
                    <Can not I="update" a="employee_profile">
                        <input type="text" name="reg_date" class="form-control" v-model="formData.regularizationDate" :disabled="true" />
                    </Can>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12 col-lg-12">
                    <label for="work_location">Work Location</label>
                    <select2
                        :options="workLocation"
                        :value="formData.workLocation"
                        @select="formData.workLocation = $event"></select2>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-3">
                    <label>Current Department</label>
                    <select2
                        v-if="departments.options.length"
                        :options="departments.options"
                        :value="departments.value"
                        :disabled="!$can('update', 'employee_profile')"
                        @select="selectDepartment($event)">
                        <option value="0">Select Department</option>
                    </select2>
                </div>
                <div class="col-lg-4">
                    <label>Intellicare Acct No</label>
                    <input :placeholder="'00-00-00000-00000-00'" v-mask="'##-##-#####-#####-##'" type="text" name="int_id_no" class="form-control" v-model="formData.int_id_no" :disabled="!$can('update', 'employee_profile')" />
                </div>
                <div class="col-lg-5">
                    <label>Current Shift</label>
                    <select2
                        v-if="shifts.options.length"
                        :options="shifts.options"
                        :value="shifts.value"
                        :disabled="!$can('update', 'employee_work_shift')"
                        @select="select($event)">
                    </select2>
                    <div class="custom-shift" v-show="custom">
                        <div class="time-selection">
                            <label>Start Time</label>
                            <flat-pickr
                                name="start_time"
                                placeholder="Select a time"
                                v-model="formData.startTime"
                                :config="getConfig(false)"
                                :disabled="!$can('update', 'employee_work_shift')"/>
                        </div>
                        <div class="time-selection">
                            <label>End Time</label>
                            <flat-pickr
                                name="end_time"
                                placeholder="Select a time"
                                v-model="formData.endTime"
                                :config="getConfig(false)"
                                :disabled="!$can('update', 'employee_work_shift')"/>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang='css' scoped>
    .v-dialogs{
        position: relative;
        z-index: 9999;
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
        width: 115px;
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
    img {
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        height: 120px;
        width: 120px;
    }
    .employeeIdEx {
        padding-top: 4px;
        color: #ef5350;
    }
    .help-block.form-error {
        color: #ef5350;
    }
</style>

<script>
import DateMixin from '@common/mixin/DateMixin';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import DatePickerMixin from '@common/mixin/DatePicker';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import ModalDialog from '@components/modal-dialog.vue';
import SaveButton from '@components/form/button.vue';
import VueTagsInput from '@johmun/vue-tags-input';
import Select2 from '@components/select2.vue';
import { WorkShift } from '@common/model/WorkShift';
import { JobPosition } from '@common/model/JobPosition';
import { Department } from '@common/model/Department';
import { Employee } from '@common/model/Employee';
import { EmployeeWorkShift } from '@common/model/EmployeeWorkShift';
import { EmployeeJobPosition } from '@common/model/EmployeeJobPosition';
import { EmployeeStatus } from '@common/model/EmployeeStatus';
import _ from 'lodash';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import { mapGetters, mapActions } from 'vuex';
import { mask } from 'vue-the-mask';

export default {
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
        StringHelperMixin,
        ModalDialogMixin,
        AlertMixin
    ],
    directives: {
        mask
    },
    props: {
        info: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            loading: false,
            custom: false,
            positionMethod: 'create',
            shifts: {
                options: [],
                value: 1
            },
            departments: {
                options: [],
                value: 1
            },
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            locationData : {
                room_number: '',
                floor: '',
                building: '',
                city: '',
                country: ''
            },
            formData: {
                level: '',
                position: '',
                positions: [],
                employeeId: '',
                dateHired: '',
                regularizationDate: '',
                startTime: '',
                endTime: '',
                shifts: '',
                departments: '',
                int_id_no: '',
                workLocation: 1

            },
            positions: [],
            option: {
                width: '800px'
            },
            hasEmployeeIdErr: false,
            employeeIdErrMsg: '',
            employment_status: {
                options: [],
                value: 17,
            },
            workLocationId: 1
        }
    },
    computed: {
        ...mapGetters({
            positionLevels: 'positionLevels/formatted',
            positionLevelDefault: 'positionLevels/defaultVal',
            employeeLocation: 'empLocation/location',
            statuses: 'statuses/formatted',
            auth: 'auth/data',
            workLocation: 'workLocation/formatted'
        }),
        filteredPositions: function() {
            return this.positions.filter(s => s.text.toUpperCase().includes(this.formData.position.toUpperCase()));
        },
        valid: function() {
            let valid = true;
            if (this.hasEmployeeIdErr) {
                valid = false;
                return;
            }
            /*if(this.locationData.city == '' || this.locationData.country == ''){
                valid = false;
                return;
            }*/

            return valid;
        }
    },
    watch: {
        custom: function(val) {
            if (val && !this.info.shift) {
                this.formData.startTime = '00:00:00';
                this.formData.endTime = '08:00:00';
            }
        },
        'formData.positions': {
            handler: function(val, oldVal) {
                if(val.length) {
                    this.positionMethod = 'update';
                } else if(oldVal.length > val.length) {
                    this.positionMethod = 'delete';
                }
            },
            deep: true
        },
        'formData.shifts': function (val, oldVal){
            if(oldVal && !val) {
                if(this.formData.startTime == '' && this.formData.endTime == '') {
                    this.formData.startTime = '00:00:00';
                    this.formData.endTime = '08:00:00';
                }
            }
        }
    },
    async created() {
        //set defaults
        this.formData.employeeId = this.info.employee_no;
        this.formData.dateHired = this.info.date_hired;
        this.formData.int_id_no = this.info.intellicare_id_no;
        this.formData.regularizationDate = this.info.regularization_date;

        try {
            if (this.info.positions.data[0].level != '') {
                this.level = this.info.positions.data[0].level_id;
                this.formData.level = this.level;
            } else {
                this.formData.level = '0';
                this.level = '0';
            }

        } catch(e) {
            this.level = '0';
        }

        this.getWorkShifts().then((res) => {
            let shifts = res.data;

            _.each(shifts, (shift) => {
                this.shifts.options.push({
                    id: shift.id,
                    text: `${shift.shift} (${shift.start_time}-${shift.end_time})`
                });
            });

            // add 'CUSTOM_TIME' option to Shift dropdown at the very first index
            const customShift = { id: 'CUSTOM_TIME', text: 'Custom Time' };
            this.shifts.options.splice(0, 0, customShift);

            // set selected value
            // see if staff has shift schedule assigned
            if (this.info.shift) {
                if (this.info.shift.data.shift_id) {
                    this.shifts.value = this.info.shift.data.shift_id;
                    this.formData.shifts = this.info.shift.data.shift_id;
                } else {
                    this.shifts.value = 'CUSTOM_TIME';

                    // show timepicker
                    this.custom = true;
                    this.formData.startTime = this.timeTwentyFourFormat(this.info.shift.data.time.ph.start);
                    this.formData.endTime = this.timeTwentyFourFormat(this.info.shift.data.time.ph.end);
                }
            } else {
                this.shifts.value = 1;
                this.formData.shifts = 1;
            }
        });

        // load job positions
        this.getPositions().then((res) => {
            let positions = res.data;

            _.each(positions, (position) => {

                this.positions.push({
                    id: position.id,
                    text: position.job_title,
                })
            });
        });
        this.getDepartments().then((res) => {
            let departments = res.data;
            _.each(departments, (department) => {
                this.departments.options.push({
                    id: department.id,
                    text: department.name
                });
            });

            // set selected value
            // see if staff has shift schedule assigned
            if (this.info.department) {
                if (this.info.department.data) {
                    this.departments.value = this.info.department.data.id
                    this.formData.departments = this.info.department.data.id;
                } else {
                    this.departments.value = 0;
                }
            } else {
                this.departments.value = 0;
                this.formData.department = 0;
            }
        });
        await this.getEmployeeLocationByEmployeeID({query: {employee_id: this.info.id}});
        this.locationData = (this.employeeLocation.length) ? this.employeeLocation[0] : this.locationData;

        // init employee job position
        if (this.info.positions.data.length) {
            _.each(this.info.positions.data, (pos) => {
                let text = pos.job_title;

                // see if there's a level
                if (pos.level) {
                    text = pos.job_title;
                }

                this.formData.positions.push({
                    id: pos.id,
                    text: text,
                    value: pos.job_title,
                    level: this.getLevel(pos.level)
                });
            });
        }
        //SET SELECTED VALUE FOR EMP STATUS
        await this.getStatuses({query: {take:9999, for:'employee'}});
        this.employment_status.options = this.statuses;
        let emp_stat = (!_.isEmpty(this.info.employeeStatuses.data)) ? _.last(this.info.employeeStatuses.data).status.id : 10; //sets the default value of `New` if no value found.
        this.employment_status.value = String(emp_stat);
        //END OF SET SELECTED VALUE FOR EMP STATUS

        await this.getWorkLocation({
            query: {
                take: 5
            }
        });
        this.formData.workLocation = this.info.workLocation.id;
    },
    mounted() {
        $('.vue-tags-input').children('input').addClass('form-control');
    },
    methods: {
        ...mapActions({
            checkEmployeeNo : 'employees/checkEmployeeNoIfExists',
            saveEmployeeLocation: 'empLocation/saveEmployeeLocation',
            getEmployeeLocationByEmployeeID: 'empLocation/getEmployeeLocationByEmployeeID',
            getStatuses: 'statuses/getStatuses',
            getWorkLocation: 'workLocation/getWorkLocation'
        }),
        async save() {
            if (this.loading) {
                return;
            }

            this.loading = true;
            let con = true;
            await this.checkEmployeeNo({'employeeNo': this.formData.employeeId}).then((res) => {
                if(res.data.length && this.formData.employeeId != this.info.employee_no){
                    let title = 'You cannot use this Employee No., please input another one.';
                    let msg = this.employeeData.employeeId;
                    this.confirmDialog(title, msg, 'Close', '', 'sm');
                    con = false;
                }
            });

            if(!con) return;

            let promises = [];

            //BEGIN UPDATE EMPLOYEE
            const empId = this.info.id,
                employee = new Employee({id: empId}),
                employeeData = {
                    employee_no: this.formData.employeeId,
                    date_hired: this.formData.dateHired,
                    regularization_date: this.formData.regularizationDate,
                    department_id: this.formData.departments,
                    intellicare_id_no: this.formData.int_id_no,
                    work_location_id: this.formData.workLocation
                };

            if(this.$can('update', 'employee_profile')){
                promises.push(employee.save(employeeData));
            }
            //END UPDATE EMPLOYEE

            //BEGIN CREATE EMPLOYEE STATUS / EMPLOYMENT STATUS
            let employeeStatus = new EmployeeStatus();
            let payload = {
                'employee_id': empId,
                'status_id': this.employment_status.value,
                'user_id': this.auth.data.id
            };
            if(this.$can('update', 'employee_status')){
                promises.push(employeeStatus.save(payload));
            }
            //END OF CREATE EMPLOYEE STATUS / EMPLOYMENT STATUS

            //BEGIN SAVE, UPDATE, DELETE EMPLOYEE JOB POS
            let employeeJobPosition = new EmployeeJobPosition();
            let employeeJobPositionData = {
                employee_id: this.info.id,
                start_date: this.formData.dateHired,
                level: this.formData.level
            }

            if (this.info.positions.data.length > 0 && this.formData.positions.length > 0 && this.positionMethod == 'update') {
                const empJobPosId = this.info.positions.data[0].id;
                employeeJobPosition = new EmployeeJobPosition({id: empJobPosId});

                //if employee position id and formData.position.id not changed
                //get current position id from employee.position.job_title
                if (empJobPosId == this.formData.positions[0].id) {
                    employeeJobPositionData.position_id = this.getPositionIdByTitle(this.info.positions.data[0].job_title);
                } else {
                    employeeJobPositionData.position_id = this.formData.positions[0].id;
                }

                //update
                if(this.$can('update', 'employee_job_position')){
                    promises.push(employeeJobPosition.save(employeeJobPositionData));
                }
            } else if (this.positionMethod == 'delete') {
                const empJobPosId = this.info.positions.data[0].id;
                employeeJobPosition = new EmployeeJobPosition({id: empJobPosId});
                //delete
                if(this.$can('delete', 'employee_job_position')){
                    promises.push(employeeJobPosition.delete());
                }
            } else {
                if (this.formData.positions.length) {
                    employeeJobPositionData.position_id = this.formData.positions[0].id;

                    if(this.$can('add', 'employee_job_position') || this.$can('update', 'employee_job_position')){
                        promises.push(employeeJobPosition.save(employeeJobPositionData));
                    }
                }
            }

            //END EMPLOYEE JOB POS
            //START SHIFT SAVE OR UPDATE
            let employeeWorkShift = new EmployeeWorkShift();
            const employeeWorkShiftData = {
                employee_id: this.info.id,
                shift_id: this.formData.shifts,
                start_time: this.formData.startTime,
                end_time: this.formData.endTime,
                start_time_timestamp: '0',
                end_time_timestamp: '0'
            }

            if (!this.info.shift) {
                if(this.$can('add', 'employee_work_shift')){
                    promises.push(employeeWorkShift.save(employeeWorkShiftData));
                }
            } else {
                employeeWorkShift = new EmployeeWorkShift({id: this.info.shift.data.id});
                if(this.$can('update', 'employee_work_shift')){
                    promises.push(employeeWorkShift.save(employeeWorkShiftData));
                }
            }
            //END SHIFT

            //START LOCATION SAVE OR UPDATE
            this.locationData.employee_id = this.info.id;
            delete this.locationData['address'];

            if(this.$can('update', 'employee_location')){
                promises.push(this.saveEmployeeLocation(this.locationData));
            }

            //END LOCATION

            Promise.all(promises).then((res) => {
                this.$emit('success');
                this.closeModal();
                this.loading = false;
                this.notifyDialog('success', 'Successfully saved!');
            });
        },
        getWorkShifts() {
            return WorkShift.get();
        },
        select(shift) {
            if (shift == 'CUSTOM_TIME') {
                this.custom = true;
            } else {
                this.custom = false;
            }

            this.formData.shifts = shift == 'CUSTOM_TIME' ? null : shift;
        },
        getPositions() {
            return JobPosition.get({
                take: 9999
            });
        },
        addPosition(obj) {
            obj.addTag();
        },
        updateLevel(level) {
            this.formData.level = level;
        },
        getDepartments() {
            return Department.get();
        },
        selectDepartment(department) {
            this.formData.departments = department == '' ? null : department;
        },
        isEmployeeNoAvailable() {
            this.hasEmployeeIdErr = false;
            this.employeeIdMsg = '';
            this.checkEmployeeNo({'employeeNo': this.formData.employeeId}).then((res) => {
                if (res.data.length && this.formData.employeeId != this.info.employee_no) {
                    this.hasEmployeeIdErr = true;
                    this.employeeIdErrMsg = 'Employee ID is not available';
                }
            });
        },
        setRegularizationDate(regularizationValue) {
            let Regular = '19';
            this.formData.regularizationDate = this.info.regularization_date;
            if (!this.info.regularization_date){
                this.formData.regularizationDate = (regularizationValue === Regular) ? moment().format('YYYY-MM-DD') : '';
            }
            
            this.employment_status.value = regularizationValue;
        }
    }
}
</script>
