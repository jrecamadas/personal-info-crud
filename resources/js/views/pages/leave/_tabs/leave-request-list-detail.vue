<template>
    <div class="card panel fs-accordion" :class="accordionClasses">
        <div class="card-header" @click.stop="toggleAccordion">
            <div class="row container-fluid">
                <div
                    class="col"
                    v-for="(column, index) in columns"
                    :key="index"
                    :class="column.klass">
                    <div :class="statusCheck(leaveStatus)">
                        {{ callDataColumn(column.content) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-block fs-accordion-content">
            <div class="row justify-content-start fs-header-content">
                <div class="col-sm-6 col-md-7 col-lg-10">
                    <h4>Leave Information</h4>
                </div>
                <div class="col-sm-6 col-md-5 col-lg-2" v-if="showHideCancelAll">
                    <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <div
                        class="btn-group-vertical btn-group-sm fs-actions"
                        role="group"
                        v-if="!loading && showActions">
                        <a
                            title="Cancel All"
                            href="javascript:;"
                            class="btn btn-danger btn-sm"
                            @click.stop="cancelRequests()"
                            style="width: 100%">
                            Cancel All
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <label>Leave Date(s): </label>
                            <span>{{ dateDisplay }}</span>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label>Leave Type: </label>
                            <span>{{ leaveTypeName }}</span>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label>Leave Time: </label>
                            <span>{{ timeDisplay }}</span>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label>Length: </label>
                            <span>{{ this.baseInfo.duration }}</span>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label>Paid/Unpaid: </label>
                            <span>{{ isPaidDisplay }}</span>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label>Date Filed: </label>
                            <span>{{ filedDate }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Reason:</label>
                            <div>
                                <div v-html="baseInfo.reason"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-12">
                    <data-table-no-search
                        :columns="listHeaders"
                        :tableClass="`text-center`">
                        <template v-for="(request, index) in info">
                            <tr
                                data-index="0"
                                :key="index"
                                :class="{ even: index % 2 === 0, odd: index % 2 !== 0 }">
                                <td class="text-center">
                                    {{ [request.start_date, "YYYY-MM-DD"] | moment("MMM D, YYYY") }}
                                </td>
                                <td class="text-center"
                                    :class="statusCheck(request.status)">
                                    {{ request.status }}
                                    <a
                                        v-if="request.status === 'Disapproved'"
                                        title="See Comment"
                                        href="javascript:;"
                                        class="action-button text-info"
                                        @click.stop="showComment(request)">
                                        <span class="la la-comment-o"></span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ requestApproverDisplay(request) }}
                                </td>
                                <td class="text-center">
                                    <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                    <template v-if="showCancel(request, loading, todayDate)">
                                        <div class="btn btn-group-vertical btn-group-sm" role="group">
                                            <a
                                                v-if="request.status !== 'Disapproved'"
                                                title="Cancel"
                                                href="javascript:;"
                                                class="btn btn-danger btn-sm"
                                                @click.stop="cancelRequest(request)">
                                                Cancel
                                            </a>
                                        </div>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </data-table-no-search>
                </div>
            </div>
        </div>
        <approver-comment-modal
            v-if="open && form.key === 'approver-comment'"
            :openModal="open"
            @close="open = false"
            :request="selectedRequestForComment">
        </approver-comment-modal>
    </div>
</template>

<style lang="scss" scoped>
    @mixin evenColor {
        background: #f5f6fa!important;
    }
    @mixin oddColor {
        background: #fdfdfe!important;
    }
    .card {
        border: none;
        padding: 0;
        .card-header {
            cursor: pointer;
            border: none;
            padding: 1rem 0;
            .row {
                margin: auto;
                align-items: center;
                font-size: 13px;
                font-weight: normal;
                .col div {
                    white-space: nowrap;
                    width: auto;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
                .col:not(:last-child) div{
                    color: #000!important;
                }
            }
        }
        .card-block.fs-accordion-content {
            background-color: #fafafa;
            border: 1px solid #f6f6f6;
            color: #000;
            padding: 20px;
            position: relative;
            label {
                font-weight: bold;
            }
            .fs-header-content {
                .fs-actions {
                    width: 100%;
                    text-align: right;
                    a { width: 100%; }
                }
            }
        }
        &.even {
            .card-header {
                @include evenColor;
            }
            &.is-primary {
                .card-header {
                    @include evenColor;
                    filter: brightness(95%);
                }
            }
            &.is-closed {
                .card-header {
                    &:hover {
                        @include evenColor;
                        filter: brightness(95%);
                    }
                }
            }
        }
        &.odd {
            .card-header {
                @include oddColor;
            }
            &.is-primary {
                .card-header {
                    @include oddColor;
                    filter: brightness(95%);
                }
            }
            &.is-closed {
                .card-header {
                    &:hover {
                        @include oddColor;
                        filter: brightness(95%);
                    }
                }
            }
        }
        &.is-closed::before {
            font-family: "LineAwesome";
            margin: 0.8rem 0 0 0.8rem;
            font-weight: 100;
            content: "\f2c2";
            color: #c1c1c1;
            font-size: 13px;
            z-index: 1;
            position: absolute;
        }
        &.is-primary::before {
            font-family: "LineAwesome";
            margin: 0.8rem 0 0 0.8rem;
            font-weight: 100;
            content: "\f28e";
            color: #c1c1c1;
            font-size: 13px;
            z-index: 1;
            position: absolute;
        }
    }
    .action-button {
        font-size: 20px;

        span {
            font-weight: bold;
        }
    }
    table {
        background: #fff;
        tr {
            &.even {
                background-color: #d8d8d8;
            }
            td {
                padding: 5px;
                vertical-align: middle;
                div.btn {
                    width: 100%!important;
                    height: 100%;
                    padding: 0;
                    position: relative;
                    a.btn {
                        width: 100%!important;
                        margin: 2px 0;
                    }
                }
            }
        }
    }
    .is-pending {
        color: #edb100!important;
    }
    .is-approved {
        color: #28a745!important;
    }
    .is-cancelled {
        color: #6c757d!important;
    }
    .is-disapproved {
        color: #dc3545!important;
    }
</style>

<script>
    // components
    import ModalDialog from '@components/modal-dialog.vue';
    import DisapproveLeaveModal from '@views/pages/leave/_modals/disapprove-leave.vue';
    import ApproverCommentModal from '@views/pages/leave/_modals/approver-comment.vue';
    import DataTableNoSearch from '@components/datatable-no-search.vue';

    // mixins
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import AccordionMixin from '@common/mixin/AccordionMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import DataTableMixin from '@common/mixin/DataTableMixin';

    import {mapActions, mapGetters} from 'vuex';
    import _ from 'lodash';

    export default {
        components: {
            ModalDialog,
            DisapproveLeaveModal,
            ApproverCommentModal,
            DataTableNoSearch
        },
        mixins: [
            AccordionMixin,
            ModalDialogMixin,
            AlertMixin,
            DataTableMixin
        ],
        props: {
            info: {
                type: Array,
                required: true,
            },
            columns: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                open: false,
                loading: false,
                form: {
                    key: '',
                    name: '',
                },
                selectedRequests: null,
                selectedRequestForComment: null,
                originalStatuses: [],
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
                listHeaders: [
                    {
                        label: 'Date',
                        sortKey: 'date',
                        width: '20%',
                        sortable: false
                    },
                    {
                        label: 'Status',
                        sortKey: 'status',
                        width: '30%',
                        sortable: false
                    },
                    {
                        label: 'Approver',
                        sortKey: 'approver',
                        width: '35%',
                        sortable: false
                    },
                    {
                        label: 'Action',
                        sortKey: 'action',
                        width: '15%',
                        sortable: false
                    },
                ]
            };
        },
        computed: {
            ...mapGetters({
                loggedInEmployee: 'employees/logged_in_employee',
            }),
            baseInfo() {
                return this.info[0];
            },
            employee() {
                return this.baseInfo.employee.data;
            },
            leaveCredits() {
                return this.employee.leaveCredits.data;
            },
            leaveCredit() {
                let leaveCreditTypeId = this.baseInfo.leaveType.data.leave_credit_type_id;
                let leaveCredit = _.find(this.employee.leaveCredits.data, (leaveCredit) => {
                    return leaveCredit.leave_credit_type_id === leaveCreditTypeId;
                });

                return leaveCredit || {};
            },
            creditBalance() {
                let leaveCreditTypeId = this.baseInfo.leaveType.data.leave_credit_type_id;
                let leaveCredit = _.find(this.leaveCredits, (leaveCredit) => {
                return leaveCredit.id === leaveCreditTypeId;
                });
                return leaveCredit ? this.round(leaveCredit.balance) : 0;
            },
            leaveTypeName() {
                return this.baseInfo.leaveType.data.name;
            },
            dateDisplay() {
                let startDate = '',
                    endDate = '';

                _.each(this.info, (leaveRequest) => {
                    let leaveRequestStartDate = this.$moment(leaveRequest.start_date, 'YYYY-MM-DD');
                    let leaveRequestEndDate = this.$moment(leaveRequest.end_date, 'YYYY-MM-DD');

                    if (startDate === '' || leaveRequestStartDate.diff(startDate, 'days') < 0) {
                        startDate = leaveRequestStartDate;
                    }
                    if (endDate === '' || leaveRequestEndDate.diff(endDate, 'days') > 0) {
                        endDate = leaveRequestEndDate;
                    }
                });

                return startDate.diff(endDate, 'days') !== 0 ?
                    `${startDate.format('MMM D, YYYY')} - ${endDate.format('MMM D, YYYY')}` : startDate.format('MMM D, YYYY');
            },
            dateDisplayStartdate() {
                let startDate = '',
                    endDate = '';

                _.each(this.info, (leaveRequest) => {
                    let leaveRequestStartDate = this.$moment(leaveRequest.start_date, 'YYYY-MM-DD');
                    let leaveRequestEndDate = this.$moment(leaveRequest.end_date, 'YYYY-MM-DD');

                    if (startDate === '' || leaveRequestStartDate.diff(startDate, 'days') < 0) {
                        startDate = leaveRequestStartDate;
                    }
                    if (endDate === '' || leaveRequestEndDate.diff(endDate, 'days') > 0) {
                        endDate = leaveRequestEndDate;
                    }
                });

                return startDate.diff(endDate, 'days') !== 0 ? `${startDate.format('MMM D, YYYY')}` : startDate.format('MMM D, YYYY');
                },
            dateDisplayEnddate() {
                let startDate = '',
                    endDate = '';

                _.each(this.info, (leaveRequest) => {
                    let leaveRequestStartDate = this.$moment(leaveRequest.start_date, 'YYYY-MM-DD');
                    let leaveRequestEndDate = this.$moment(leaveRequest.end_date, 'YYYY-MM-DD');

                    if (startDate === '' || leaveRequestStartDate.diff(startDate, 'days') < 0) {
                        startDate = leaveRequestStartDate;
                    }
                    if (endDate === '' || leaveRequestEndDate.diff(endDate, 'days') > 0) {
                        endDate = leaveRequestEndDate;
                    }
                });

                return startDate.diff(endDate, 'days') !== 0 ? `${endDate.format('MMM D, YYYY')}` : startDate.format('MMM D, YYYY');
            },
            isSickApprove() {
                let isSL = _.toLower(this.leaveTypeName).search('sick') > -1,
                    isBoolean = true,
                    isApproved = _.toLower(this.leaveStatus).search('approve') > -1;

                    return (isSL && !isApproved);
            },
            canCancel() {
                let start = this.$moment(this.dateDisplayStartdate, 'MMM D, YYYY'),
                    today = this.$moment.now(),
                    isdateOlderThanToday = start.diff(today,'days') >= 0;

                return  isdateOlderThanToday ? true : this.isSickApprove;
            },
            starttimenow() {
                let startTime = this.$moment(this.baseInfo.start_time, 'hh:mm:ss');

                return startTime;
            },
            timeDisplay() {
                let startTime = this.$moment(this.baseInfo.start_time, 'hh:mm:ss').format('hh:mm A'),
                    endTime = this.$moment(this.baseInfo.end_time, 'hh:mm:ss').format('hh:mm A');

                return `${startTime} - ${endTime}`;
            },
            filedDate() {
                return this.$moment(this.baseInfo.created_at.date).format('MMM D, YYYY');
            },
            isPaidDisplay() {
                return this.baseInfo.is_paid ? 'Paid' : 'Unpaid';
            },
            showActions() {
                return !_.isEmpty(this.loggedInEmployee);
            },
            statusPending() {
                let count = 0;
                if (this.info.length > 0) {
                    _.each(this.info, (request) => {
                            if (request.status == 'Pending') {
                            count++
                            }
                    });
                    return count;
                }

            },
            statusApproved() {
                let count = 0;
                if (this.info.length > 0) {
                    _.each(this.info, (request) => {
                        if (request.status == 'Approved') {
                            count++
                        }
                    });
                    return count;
                }

            },
            statusCancelled() {
                let count = 0;
                if (this.info.length > 0) {
                    _.each(this.info, (request) => {
                        if (request.status == 'Cancelled') {
                            count++
                        }
                    });
                    return count;
                }

            },
            statusDisapproved() {
                let count = 0;
                if (this.info.length > 0) {
                    _.each(this.info, (request) => {
                        if (request.status == 'Disapproved') {
                            count++
                        }
                    });
                    return count;
                }

            },
            showHideCancelAll() {
                let pending = this.statusPending,
                    approved = this.statusApproved,
                    cancelled = this.statusCancelled,
                    disapproved = this.statusDisapproved,
                    show = false;

                if (!this.canCancel) {
                    show = false
                }
                else if (this.canCancel && (pending > 0 || approved > 0)) {
                    show = true;
                }
                else if (this.canCancel && (pending == 0 && approved == 0)) {
                    show = false;
                }
                return show;
            },
            totalAllStatus() {
                return this.statusPending + this.statusApproved + this.statusCancelled + this.statusDisapproved;
            },
            leaveStatus() {
                let status = ""
                if ((this.statusDisapproved > 0) && (this.statusPending == 0 && this.statusApproved == 0 && this.statusCancelled >= 0)) {
                    status = "Disapproved";
                } else if ((this.statusApproved > 0) && (this.statusPending == 0 && this.statusCancelled >= 0 && this.statusDisapproved >= 0 )) {
                    status = "Approved ("+this.statusApproved+"/"+this.totalAllStatus+")";
                } else if (this.statusCancelled > 0 && (this.statusDisapproved == 0 && this.statusPending == 0 && this.statusApproved == 0)) {
                    status = "Cancelled";
                } else {
                    status = "Pending";
                }
                return status
            },
            todayDate() {
                let startTime = this.$moment(new Date(), 'YYYY-MM-DD').format('YYYY-MM-DD');

                return `${startTime}`;

            },
        },
        async created() {
            _.each(this.info, (object) => {
                this.originalStatuses.push({id: object.id, status: object.status});

            });
        },
        methods: {
            ...mapActions({
                saveLeaveRequest: 'leaveRequests/saveLeaveRequest',
                getEmployee: 'employees/getEmployee',
                saveEmployeeLeaveCredit: 'employeeLeaveCredits/saveEmployeeLeaveCredit'
            }),
            round(number) {
                return Math.round(number * 100) / 100;
            },
            showCancel(request, loading, today) {
                return !loading &&
                    request.status !== 'Cancelled' &&
                    (request.start_date >= today || (request.leaveType.data.name == 'Sick Leave' && request.status == 'Pending'));// need to refactor
            },
            calculateCreditCount(leaveRequests) {
                let count = 0;
                let validItems = 0;

                if (this.baseInfo.is_paid) {
                    count = this.baseInfo.duration === 'Whole Day' ?  1 : 0.5;

                    _.each(leaveRequests, (newItem) => {
                        let oldItem = _.find(this.originalStatuses, (item) => {
                            return item.id === newItem.id;
                        });

                        if (oldItem) {
                            if (oldItem && (
                                (oldItem.status === 'Pending' && newItem.status === 'Approved') ||
                                (oldItem.status === 'Disapproved' && newItem.status === 'Approved') ||
                                (oldItem.status === 'Approved' && newItem.status === 'Disapproved') ||
                                (oldItem.status === 'Approved' && newItem.status === 'Cancelled')
                            )) {
                                validItems += 1;
                            }
                        }
                    })
                }
                return count * validItems;
            },
            requestApproverDisplay(request) {
                return request.approver ? request.approver.data.name : '';
            },
            setRequestData(request) {
                return {
                    id: request.id,
                    leave_type_id: request.leave_type_id,
                    employee_id: request.employee_id,
                    batch: request.batch,
                    duration: request.duration,
                    is_paid: request.is_paid,
                    start_date: request.start_date,
                    end_date: request.end_date,
                    start_time: request.start_time,
                    end_time: request.end_time,
                    reason: request.reason,
                    approver_id: request.approver_id,
                    approver_comment: request.approver_comment,
                    status: request.status,
                };
            },
            cancelRequest(request) {
                const title = 'Cancel Request';
                const message = 'Are you sure you want to cancel your leave request?';
                    this.confirmDialog(title, message, 'Yes', 'No', 'sm').then(({ok}) => {
                        if (ok) {
                            let data = [];
                            data.id = request.id,
                            data.duration = request.duration;
                            data.is_paid = request.is_paid;
                            data.prev_status = request.status;
                            data.status = 'Cancelled';
                            this.saveCancel([data]);
                        }
                    },
                );
            },
            cancelRequests() {
                const title = 'Cancel Request(s)';
                const message = 'Are you sure you want to cancel your request(s)?';
                this.confirmDialog(title, message, 'Yes', 'No', 'sm').then(({ok}) => {
                        if (ok) {
                            let requests = [];

                            _.each(this.info, (request) => {
                                if(request.status !== 'Disapproved'){
                                    let data = [];
                                    data.id = request.id,
                                    data.duration = request.duration;
                                    data.is_paid = request.is_paid;
                                    data.prev_status = request.status;
                                    data.status = 'Cancelled';
                                    requests.push(data);
                                }
                            });

                            this.saveCancel(requests);
                        }
                    },
                );
            },
            openModals(form) {
                this.form = form;
                this.open = true;
            },
            async saveCancel(obj) {
                let requests = obj;
                let promises = [];
                let num_days = 0;

                await _.each(requests, (request) => {
                    if (request.prev_status != "Cancelled") {
                        num_days += (request.duration === 'Whole Day') ?  1 : 0.5;
                    }
                    promises.push(this.saveLeaveRequest(request));
                });

                let creditCount = this.calculateCreditCount(requests);

                if (this.baseInfo.is_paid && creditCount > 0) {
                    let employeeLeaveCredit = {
                        id: this.leaveCredit.id,
                        employee_id: this.leaveCredit.employee_id,
                        leave_credit_type_id: this.leaveCredit.leave_credit_type_id,
                        balance: this.round(this.leaveCredit.balance) + creditCount,
                        days: num_days,
                        action: 'cancel'
                    };

                    promises.push(this.saveEmployeeLeaveCredit(employeeLeaveCredit));
                }

                Promise.all(promises).then((res) => {
                    this.open = false;
                    this.form = {key: '', name: ''};
                    this.selectedRequests = [];
                    this.loading = false;
                    this.$emit('success');
                }).catch((e) => {
                    this.loading = true;

                    let catchError = '';
                    _.each(e.response.data.message, (errMsg) => {
                        catchError = errMsg[0];
                    });

                    _.each(requests, (request) => {
                        // here we reset the leave request(s)
                        // status back to its previous status
                        request.status = request.prev_status;
                        this.saveLeaveRequest(request);
                    });
                    this.alertDialog('Action Invalid', catchError, 'Okay', 'sm');

                    this.loading = false;
                });
            },
            showComment(request) {
                this.selectedRequestForComment = request;
                this.openModals({key: 'approver-comment', name: 'Approver Comment'});
            },
            callDataColumn(column) {
                return this[''+column+''];
            },
            statusCheck(status) {
                return "is-"+_.toLower(status)
            }
        }
    };
</script>
