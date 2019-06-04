<template>
    <modal-dialog v-show="openModal" :options="option" :title="'File a Leave Request'" @close="closeModal" oncontextmenu="return false;">
        <template slot="button">
            <save-button :loading="loading" @action="save" :disabled="!valid">File Leave</save-button>
        </template>
        <template slot="body">
            <div class="tab-pane active" id="basic" role="tabpanel" aria-expanded="false">
                <div class="row content-row d-flex align-items-center">
                    <div class="col col-sm-12 text-center">
                        <div class="alert alert-danger ks-solid-light ks-active-border" role="alert" v-if="showHideError || isConflictDate">
                            <div v-if="showHideError">
                                <p>Your credits are insufficient please log a separate request for unpaid leave.</p>
                            </div>
                            <div v-if="isConflictDate">
                                <h4>You have already requested a leave for the following dates:</h4>
                                <p><span class="error" v-html="splitDate"></span></p>
                            </div>            
                        </div>
                    </div>
                    <div class="col col-sm-12 mt-2 mb-2">
                        <h5>Available {{ leaveTypeDisplay }} Credits: <span style="font-weight:600;">{{ imaginaryCreditBalance }}</span></h5>
                    </div>
                    <div class="col col-sm-6">
                        <label>Leave Type<span class="error">*</span></label>
                        <select2
                            :options="leaveTypeOptions"
                            :value="leaveData.leave_type_id"
                            :hideSearchBox="false"
                            @select="leaveData.leave_type_id = $event"></select2>
                        <span v-show="hasDBError" class="error help-block form-error">{{ getDBError('leave_type_id') }}</span>
                    </div>
                    <div class="col col-sm-6">
                        <label>Paid / Unpaid<span class="error">*</span></label>
                        <div>
                            <toggle-checkbox
                                :status=leaveIspaid
                                :byDefault=leaveIspaidDefault
                                @change="leaveData.is_paid = $event"></toggle-checkbox>
                        </div>
                    </div>
                    <div class="col col-sm-6 mt-3">
                        <label>Leave Start Date<span class="error">*</span></label>
                        <flat-pickr
                            name="start_date"
                            placeholder="Start Date"
                            v-model="leaveData.start_date"
                            :config="getConfig(true, false, { maxDate:this.maxDates,minDate: this.minDatesForLeaveStartDate, disable: this.disableDates })"
                            v-validate="'required'" />
                        <span v-show="hasDBError" class="error help-block form-error">{{ getDBError('start_date') }}</span>
                        <span class="error" v-if="!validDays">Select a valid date</span>
                    </div>
                    <div class="col col-sm-6 mt-3">
                        <label>Wholeday / Halfday</label><span class="error">*</span>
                        <div>
                            <toggle-checkbox
                                :status=leaveDuration
                                :byDefault=setDefaultDuration
                                :isDisabled=validationWholeHalf
                                @change="leaveData.duration = $event"></toggle-checkbox>
                        </div>
                    </div>
                    <div class="col col-sm-6 mt-3">
                        <label>Leave End Date<span class="error">*</span></label>
                        <flat-pickr
                            name="end_date"
                            placeholder="End Date"
                            v-model="leaveData.end_date"
                            :config="getConfig(true, false, { maxDate:this.maxDates,minDate: this.minDatesForLeaveEndDate,  disable: this.disableDates })"
                            v-validate="'required'"/>
                        <span v-show="hasDBError" class="error help-block form-error">{{ getDBError('end_date') }}</span>
                        <span class="error" v-if = "!validDays">Select a valid date</span>
                    </div>
                    <div class="col col-sm-6 mt-4">
                        <label for="durationi">Leave Duration:</label>
                        <input class="form-control" type="text" :value="requestDays" readonly disabled>
                    </div>
                    <div class="col col-sm-12 mt-3">
                        <label>Reason</label><span class="error">*</span>
                        <textarea class="form-control" v-model="leaveData.reason" name="reason" rows="5" column="5" placeholder="Type here.." style="resize: none;"></textarea>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script type="text/javascript">
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
    //Libraries
    import ToggleCheckbox from '@components/toggle-checkbox.vue';
    import Select2 from '@components/select2.vue';
    import DateMixin from "@common/mixin/DateMixin";
    import VueTagsInput from "@johmun/vue-tags-input";
    import OAuth from '@common/oauth/OAuth';
    import { mapActions, mapGetters } from 'vuex';
    import { Validator } from 'vee-validate';
    import _ from 'lodash';
    
    export default {
        components: {
            GenerateButton,
            SaveButton,
            ModalDialog,
            FlatPickr,
            Select2,
            ToggleCheckbox
        },
        mixins: [
            EmployeeMixin,
            StringHelperMixin,
            ModalDialogMixin,
            DatePickerMixin,
            AlertMixin
        ],
        props: {
            info: {
                type: Array,
                required: true,
            },
            pto: {
                type: Number,
                required: true,
            }
        },
        directives: {
            mask
        },
        data() {
            return {
                moment:moment,
                option: {
                    height: 'auto',
                    width: '600px',
                    bottom: 'auto'
                },
                statuses: {
                   approved: 0,
                   cancelled: 0,
                   disapproved: 0,
                   pending: 0,
                },
                include: [
                   'employee',
                   'approver',
                   'leaveType',
                   'employee.projects',
                   'employee.department',
                   'employee.projects.clientProject',
                   'employee.leaveCredits',
                ],
                leaveTypesCredits: {
                    pto: 0,
                    paternity: 0,
                    maternity: 0,
                },
                leaveData: {
                    start_date: '',
                    end_date: '',
                    start_time: '12:00',
                    end_time: '12:00',
                    status: '',
                    reason: '',
                    duration: '',
                    leave_type_id: '',
                    employee_id: '',
                    is_paid: '',
                    batch: ''
                },
                listedDates: [],
                loading: false,
                manualInput : false,
                isConflictDate: false,
                pendingStat: 0,
                approvedStat: 0,
                cancelledStat: 0,
                disapprovedStat: 0,
                hasDBError: false,
                dbError: []
           }
        },
        watch: {
            'leaveData.is_paid': function() {
                this.resetDbError();
            },
            'leaveData.leave_type_id': function() {
                this.resetDbError();
            },
            'leaveData.start_date': function() {
                this.resetDbError();
            },
            'leaveData.end_date': function() {
                this.resetDbError();
            },
            'leaveData.duration': function() {
                this.resetDbError();
            }
        },
        computed: {
            ...mapGetters({
                loggedInUser: 'auth/data', //get logged in user data
                employee: 'employees/single',
                leaveDuration: 'leaveDuration/formatted',
                leaveDurationDefault: 'leaveDuration/defaultVal',
                leaveIspaid: 'leaveIspaid/formatted',
                leaveIspaidDefault: 'leaveIspaid/defaultVal',
                leaveTypes: 'leaveTypes/data',
                leaveRequests: 'leaveRequests/list',
            }),
            updatedEmployeeData() {
                return (typeof this.baseInfo==="undefined") ? this.employee[0] : this.baseInfo.employee.data;
            },
            leaveTypeOptions() {
                let leaveTypes = [];
                _.each(this.leaveTypes, (leaveType) => {
                    if (leaveType.is_enabled) {
                        leaveTypes.push({
                            id: leaveType.id,
                            text: leaveType.name
                        });
                    }
                });
                return leaveTypes;
            },
            validationWholeHalf() {
                const startdate = moment(this.leaveData.start_date);
                const enddate = moment(this.leaveData.end_date);
                const truedate = enddate.diff(startdate,'days')+1;
                const finaldate = parseInt(truedate);
                const setValidation = _.find(this.leaveDuration, function(status) { return status.value === "Whole Day" });
                let condition = false;
                
                if (finaldate > 1) {
                    this.leaveData.duration = setValidation.value
                    condition = true;
                }
                return condition;
            },
            leaveTypeDisplay() {
                let leave = [];
                let leaveFinalDisplay = '';
                _.each(this.leaveTypes, (res) => {
                    leave[res.id] = res;
                });
                if (leave && leave[this.leaveData.leave_type_id] && leave[this.leaveData.leave_type_id].leave_credit_type) {
                    leaveFinalDisplay = leave[this.leaveData.leave_type_id].leave_credit_type.name;
                }
                return leaveFinalDisplay;
            },
            /***********************To do next in phase 2 make it dynamic not reference in ID************************/
            maxDates(){
                let getYear = new Date().getFullYear();
                let maxDate = getYear + '-12-31';
                if (this.leaveData.leave_type_id == 2) {
                    maxDate = 'today';
                }
                return maxDate;
            },
            minDatesForLeaveStartDate (){
                let minDate = 'today';
                let getYear = new Date().getFullYear();
                if (this.leaveData.leave_type_id == 2 || this.leaveData.leave_type_id == 3) {
                    minDate = getYear + '-01-01';
                }
                return minDate;
            },
            minDatesForLeaveEndDate() {
                let minDate = 'today';
                if (this.leaveData.start_date) {
                    minDate = this.leaveData.start_date;
                }
                return minDate;
            },
            /********************************************************************************************************/
            splitDate() {
                let dates = this.listedDates.toString().split(',');
                let vm = this;
                let dateFinal = [];
                dates.forEach(function(i) {
                    dateFinal.push(vm.$moment(i).format('MMM DD, YYYY'));
                });
                return dateFinal.join('<br>');
            },
            disableDates() {
                let disabledDates = [];
                _.each(this.leaveRequests, (res) => {
                    if (res.status !== "Cancelled"){
                        disabledDates.push(res.start_date);
                    }
                });
                return disabledDates;
            },
            leaveCreditBalance() {
                let leaveCreditBalance = 0;
                if (this.leaveData.leave_type_id == '') {//for catching the error no value
                    leaveCreditBalance =  0;
                } else  {
                   /*in leaveTypes on vue it returns all leaves with their corresponding leave credit and other datas like
                    leave_type_id which we can compare to when selecting in dropdown once selected it returns only the match*/
                    let leaveTypeResult = this.leaveTypes.filter(result => result.id == this.leaveData.leave_type_id);
                    /*we already get the specific credits on a specific leave for a specific employee then we will return only below*/
                    let leaveCreditObject = this.updatedEmployeeData.leaveCredits.data.filter(result => result.leave_credit_type_id == leaveTypeResult[0].leave_credit_type_id);
                    /*Error Handler if some leaves are not set for this specific employee*/
                    if(leaveCreditObject.length == 0) {
                        leaveCreditBalance = 0;
                    } else {
                       /* above we already get the specific credits on a specific leave for a specific employee then we will return only below
                         the balance we included [0] since we return a array inside the object so to access it we include it.*/
                        leaveCreditBalance = leaveCreditObject[0].balance;
                    }
                }
                return leaveCreditBalance;
            },
            countPending() {
                if (this.updatedEmployeeData.data && this.updatedEmployeeData.data.length > 0) {
                    _.each(this.updatedEmployeeData.data, (request) => {
                        let leaveNum = [1 ,2 ,3];
                        if ((_.indexOf(leaveNum,request.leave_type_id) >= 0) && request.is_paid == 1) {
                            switch (request.status) {
                                case 'Pending':
                                    this.statuses.pending += request.duration == 'Half Day' ? 0.5 : 1;
                                    break;
                            }
                        }
                    });
                    return this.statuses.pending;
                }
            },
            validDays () {
                let valid = true;
                if (this.leaveData.end_date != '' && this. leaveData.start_date != '' && this.numberOfDays == 0) {
                    valid = false
                }
                
                return valid;
            },
            onlyPTO() {
                let pending = 0;
                let leaveNum = [1 ,2 ,3];
                let hasLeaveTypeID = leaveNum.includes(parseInt(this.leaveData.leave_type_id));
                // this will fix in the coming release patch
                // if (hasLeaveTypeID) {
                //     pending = this.countPending;
                // } else {
                //     pending = 0;
                // }
                return hasLeaveTypeID ? this.pto : 0;
            },
            numberOfDays() {
                let days = 0, rangeOfDates = this.getRangeDates();
                let diffdates = moment(this.leaveData.end_date).diff(moment(this.leaveData.start_date),'days');
                if (diffdates >= 1) {
                    _.each(rangeOfDates, (date)=> {
                        let d = this.$moment(date).isoWeekday();
                        /*saturday = 6 and sunday = 7*/
                        if (d !== 6 && d !== 7 ) {
                            days++;
                        }
                    });
                } else if (diffdates === 0) {
                    days = 1;
                }
                return days;
            },
            imaginaryCreditBalance() { // current credit balance - PTO this only works if its PTO other leaves this will behave normally
                // comment for now and will fix in the coming releases
                // let balance = 0;
                // if (this.countPending === undefined) {
                //     balance = this.leaveCreditBalance;
                // } else {
                //     balance = this.leaveCreditBalance - this.onlyPTO;
                // }
                // return balance;
                return this.onlyPTO != 0 ? this.onlyPTO : this.leaveCreditBalance;
            },
            finalCountDays() {
                let duration = 0;
                let durationData = this.leaveData.duration;
                let startDateData = this.leaveData.start_date;
                let endDateData = this.leaveData.end_date;
                const durationWhole = "Whole Day", durationHalf = "Half Day";
                if (durationData == durationWhole && (startDateData != '' && endDateData != '')) {
                    duration = this.numberOfDays;
                } else if (durationData == durationHalf && (startDateData != '' && endDateData != '')) {
                    duration = this.numberOfDays / 2;
                } else if (startDateData == '' || endDateData == '') {
                    duration = 0;
                } else {
                    duration = this.numberOfDays;
                }
                return duration;
            },
            requestDays () {
                let days = this.finalCountDays;
                let selected = days > 1 ? days + " Days" : days + " Day";
                return days < 0.5 ? days : selected;
            },
            valid: function() {
                let valid = true;
                // check validation form validation set rule
                _.each(this.validation, (form) => {
                    // break validation rule
                    let rules = form.rule.split('|');
                    // validate accordingly
                    _.each(rules, (rule) => {
                        if (rule == 'required') {
                            if (this.isEmpty(_.get(this.leaveData, form.path))) {
                                valid = false;
                                return;
                            }
                        }
                    });
                    if (!valid) return;
                });
                if (this.leaveData.start_date == '') { valid = false; }
                if (this.leaveData.end_date == '') { valid = false; }
                if (this.leaveData.leave_type_id == '') { valid = false; }
                if (this.leaveData.duration == '') { valid = false; }
                if (this.leaveData.reason == '') { valid = false; }
                if (this.leaveCreditBalance == 0 && this.leaveData.is_paid == 2) { valid = false; }
                if (this.leaveData.end_date != '' && this. leaveData.start_date != '' && this.numberOfDays == 0) {valid = false;}
                if (this.finalCountDays > this.imaginaryCreditBalance && this.leaveData.is_paid == 2) {valid = false;}
                return valid;
            },
            baseInfo() {
                return this.info[0];
            },
            showHideConflictValidation() {
                let isPaid = false;
                if (this.leaveData.is_paid == '') {
                   isPaid = true;
                }
                return isPaid;
            },
            showHideError() {
                let balance = false;
                if (this.leaveCreditBalance == 0 && this.leaveData.is_paid == 1 && this.leaveData.leave_type_id != '') {
                    balance = true;
                } else if (this.finalCountDays > this.imaginaryCreditBalance && this.leaveData.is_paid == 1 && this.leaveData.leave_type_id != '') {
                    balance = true;
                }
                return balance;
            },
            setDefaultDuration() {
                const change = this.leaveData.duration;
                const status = _.find(this.leaveDuration, function(stats) { return stats.value === change });
                return status ? status : this.leaveDurationDefault
            }
        },
        methods: {
            ...mapActions({
                saveLeaveRequest: 'leaveRequests/saveLeaveRequest',
                getEmployee: 'employees/getEmployee',
            }),
            getRangeDates() {
                let dateArray = [];
                let currentDate = moment(this.leaveData.start_date);
                let stopDate = moment(this.leaveData.end_date);
                let diffofdates = moment(this.leaveData.end_date).diff(moment(this.leaveData.start_date),'days');
                for (let i = 0; i <= diffofdates; i++) {
                    if (i < 1) {
                        currentDate = moment(currentDate);
                    } else {
                        currentDate = moment(currentDate).add(1, 'days');
                    }
                    dateArray.push(currentDate.format('YYYY-MM-DD'))
                }
                return dateArray;
            },
            doFilterLeaveType(leaveType) {
                this.filterValue.leaveType = leaveType;
            },
            checkDates(startDate) {
                let flag = false;
                _.each(this.leaveRequests, (res) => {
                    if (res.start_date === startDate) {
                        if (res.status !== "Cancelled") {
                            flag = true;
                            this.listedDates.push(startDate);
                        }
                    }
                });
                return flag;
            },
            generateRandomString(length) {
                let chararcters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
                let randomString = '';
                for (let i=0; i < length; i++) {
                    let randomNumber = Math.floor(Math.random() * chararcters.length);
                    randomString += chararcters.substring(randomNumber,randomNumber+1);
                }
                return randomString;
            },
            save() {
                this.leaveData.employee_id = this.employee[0].id;
                this.leaveData.batch = `${this.leaveData.employee_id}-${this.$moment.now()}-${this.generateRandomString(5)}`;
                this.listedDates = [];
                let rangeOfDates = this.getRangeDates();
                let flag = false;
                let isConflict = false;
                /* Allow save only 1 selected date with automatic save  or multiple*/
                let diffdates = moment(this.leaveData.end_date).diff(moment(this.leaveData.start_date),'days');
                // Check these date(s) if there are conflicts
                _.each(rangeOfDates, (date) => {
                    let d = this.$moment(date).isoWeekday();
                    /*saturday = 6 and sunday = 7*/
                    if (d !== 6 && d !== 7 ) {
                        isConflict = this.checkDates(date);
                        if (isConflict) {
                            flag = true;
                        }
                    }
                });
                
                // If no conflict, then save to database all the dates
                if (flag == false) {
                    if (diffdates !== 0) {
                        _.each(rangeOfDates, (date)=> {
                            let d = this.$moment(date).isoWeekday();
                            /*saturday = 6 and sunday = 7*/
                            if (d !== 6 && d !== 7 ) {
                                this.saveDb(date);
                            }
                        });
                    } else {
                        _.each(rangeOfDates, (date)=> {
                            this.saveDb(date);
                        });
                    }
                } else {
                    this.isConflictDate = true;
                }
            },
            saveDb(date) {
                this.hasSSerror = false;
                this.hasDBError = false;
                this.dbError = [];
                this.ssError = '';
                this.loading = true;
                this.errors.clear();
                this.leaveData.start_date = date;
                this.leaveData.end_date = date;
                this.leaveData.status = 'Pending';
                this.saveLeaveRequest(this.leaveData).then(() => {
                    this.$emit('success');
                    this.closeModal();
                    setTimeout(() => {
                        this.leaveData = {};
                    }, 150);
                })
                .catch((e) => {
                    this.loading = false;
                    this.hasDBError = true;
                    let counter = 0;
                    _.each(e.response.data.message, (errMsg) => {
                        this.dbError[Object.keys(e.response.data.message)[counter]] = errMsg[0];
                        counter++;
                    });
                });
            },
            getDBError(key) {
                if(Object.keys(this.dbError).length){
                    return (this.dbError.hasOwnProperty(key)) ? this.dbError[key] : '';
                }
                
                return;
            },
            resetDBErrorOnElements (event) {
                if(event.target.value.trim() != '') {
                    this.resetDbError();
                }
            },
            resetDbError(){
                this.hasDBError = false;
                this.dbError = [];
            },
            _manualInput() {
                this.manualInput = true;
            },
            async created() {
                this.loggedInUser;
                await this.getLeavetypes({});
            }
        }
    }
</script>