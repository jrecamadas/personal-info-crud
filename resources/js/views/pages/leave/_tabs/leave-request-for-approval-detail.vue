<template>
    <div class="fs-accordion card panel" :class="accordionClasses">
        <div class="card-header" @click.stop="toggleAccordion">
            <div class="row container-fluid" :class="statusCheck(leaveStatus)">
                <div
                    class="col"
                    v-for="(column, index) in columns"
                    :key="index"
                    :class="column.klass">
                    <div>
                        {{ callDataColumn(column.content) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-block fs-accordion-content">
            <div class="row justify-content-end fs-header-content mb-2">
                <div class="col-sm-6 col-md-8 col-lg-10">
                    <h3>{{ employeeName }}</h3>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-2">
                    <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <div
                        class="btn-group-vertical btn-group-sm fs-actions"
                        role="group"
                        v-if="!loading && showActions">
                        <a
                            v-if="showApproveAll"
                            href="javascript:;"
                            class="btn btn-success btn-sm"
                            title="Approve All"
                            @click.stop="approveRequests()">
                            Approve All
                        </a>
                        <a
                            v-if="showDisapproveAll"
                            title="Disapprove All"
                            href="javascript:;"
                            class="btn btn-danger btn-sm"
                            @click.stop="disapproveRequests()">
                            Disapprove All
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <label>Project: </label>
                            <span>{{ projectDisplay }}</span>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label>Department: </label>
                            <span>{{ departmentDisplay }}</span>
                        </div>
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
                <div class="col-sm-6 col-md-6">
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
                                    <template v-if="!loading && request.status !== 'Cancelled' && showActions">
                                        <div class="btn btn-group-vertical btn-group-sm" role="group">
                                            <a
                                                v-if="request.status !== 'Approved'"
                                                href="javascript:;"
                                                class="btn btn-success btn-sm"
                                                @click.stop="approveRequest(request)">
                                                Approve
                                            </a>
                                            <a
                                                v-if="request.status !== 'Disapproved'"
                                                href="javascript:;"
                                                class="btn btn-danger btn-sm"
                                                @click.stop="disapproveRequest(request)">
                                                Disapprove
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
        <disapprove-leave-modal
            v-if="open && form.key === 'disapprove-leave'"
            :openModal="open"
            :info="selectedRequests"
            @close="open = false"
            @success="saveDisapproval">
        </disapprove-leave-modal>
        <approver-comment-modal
            v-if="open && form.key === 'approver-comment'"
            :openModal="open"
            :request="selectedRequestForComment"
            @close="open = false">
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
        cursor: pointer;
        .card-header {
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
                    a {
                        width: 100%;
                        margin: 3px 0;
                    }
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
                dbError: '',
                form: {
                    key: '',
                    name: '',
                },
                selectedRequests: null,
                selectedRequestForComment: null,
                alert: {
                    title: '',
                    message: ''
                },
                originalStatuses: [],
                statuses: {
                    approved: 0,
                    cancelled: 0,
                    disapproved: 0,
                    pending: 0,
                },
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
            employeeName() {
                return this.baseInfo.employee.data.name;
            },
            leaveCredit() {
                let leaveCreditTypeId = this.baseInfo.leaveType.data.leave_credit_type_id;
                let leaveCredit = _.find(this.employee.leaveCredits.data, (leaveCredit) => {
                    return leaveCredit.leave_credit_type_id === leaveCreditTypeId;
                });

                return leaveCredit || {};
            },
            creditBalance() {
                return this.round(this.leaveCredit.balance) || 0;
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
                    `${startDate.format('MMM D, YYYY')} - ${endDate.format('MMM D, YYYY')}` : startDate.format(
                        'MMM D, YYYY');
            },
            projectDisplay() {
                let projectNames = [];

                _.each(this.employee.projects, (project) => {
                    _.each(project, (employeeProject) => {
                        projectNames.push(employeeProject.clientProject.data.project_name);
                    });
                });
                return projectNames.length ? projectNames.join(', ') : 'Unassigned';
            },
            departmentDisplay() {
                return this.employee.department && this.employee.department.data
                    ? this.employee.department.data.name
                    : 'Unassigned';
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
            showApproveAll() {
                return this.statusDisapproved || this.statusPending;
            },
            showDisapproveAll() {
                return this.statusApproved || this.statusPending;
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
            statusApproved() {
                let count = 0;
                if (this.info.length > 0) {
                    _.each(this.info, (request) => {
                        if (request.status == 'Approved') {
                            count++;
                        }
                    });
                    return count;
                }

            },
            statusPending() {
                let count = 0;
                if (this.info.length > 0) {
                    _.each(this.info, (request) => {
                        if (request.status == 'Pending') {
                            count++;
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
                            count++;
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
                            count++;
                        }
                    });
                    return count;
                }
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
                saveEmployeeLeaveCredit: 'employeeLeaveCredits/saveEmployeeLeaveCredit'
            }),
            round(number) {
                return Math.round(number * 100) / 100;
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
                                (oldItem.status === 'Approved' && newItem.status === 'Disapproved')
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
                    duration: request.duration,
                    is_paid: request.is_paid,
                    approver_id: request.approver_id,
                    approver_comment: request.approver_comment,
                    status: request.status,
                };
            },
            approveRequest(request) {
                this.alert.title = 'Approve Request';
                this.alert.message = 'Are you sure you want to approve the request?';
                this.confirmDialog(this.alert.title, this.alert.message, 'Yes', 'No', 'sm').then(({ok}) => {
                        if (ok) {
                            let data = this.setRequestData(request);
                            data.prev_status = request.status
                            data.status = 'Approved';
                            data.approver_id = this.loggedInEmployee.id;
                            data.prev_approver_id = request.approver_id;
                            this.saveApproval([data]);
                        }
                    },
                );
            },
            approveRequests() {
                this.alert.title = 'Approve Request';
                this.alert.message = 'Are you sure you want to approve the request(s)?';
                this.confirmDialog(this.alert.title, this.alert.message, 'Yes', 'No', 'sm').then(({ok}) => {
                        if (ok) {
                            let requests = [];

                            _.each(this.info, (request) => {
                                if (request.status !== 'Cancelled') {
                                    let data = this.setRequestData(request);
                                    data.prev_status = request.status;
                                    data.status = 'Approved';
                                    data.approver_id = this.loggedInEmployee.id;
                                    requests.push(data);
                                }
                            });

                            this.saveApproval(requests);
                        }
                    },
                );
            },
            openInvalidApprovalDialog() {
                this.alert.title = 'Action Invalid';
                this.alert.message = 'Cannot approve this request because leave balance for the credit type is lacking.';
                this.alertDialog(this.alert.title, this.alert.message, 'Cancel', 'sm');
            },
            openModals(form) {
                this.form = form;
                this.open = true;
            },
            disapproveRequest(request) {
                this.openModals({key: 'disapprove-leave', name: 'Disapprove Leave'});
                this.selectedRequests = [request];
            },
            disapproveRequests() {
                this.openModals({key: 'disapprove-leave', name: 'Disapprove Leave'});
                this.selectedRequests = this.info;
            },
            async saveApproval(requests) {
                let creditCount = this.calculateCreditCount(requests);
                if (this.creditBalance >= creditCount) {
                    let promises = [];
                    let num_days = 0;

                    this.loading = true;

                    await _.each(requests, (request) => {
                        if (request.prev_status != "Approved") {
                            num_days += (request.duration === 'Whole Day') ?  1 : 0.5;
                        }

                        promises.push(this.saveLeaveRequest(request));
                    });

                    if (this.baseInfo.is_paid && creditCount > 0) {
                        let employeeLeaveCredit = {
                            id: this.leaveCredit.id,
                            employee_id: this.leaveCredit.employee_id,
                            leave_credit_type_id: this.leaveCredit.leave_credit_type_id,
                            balance: this.round(this.leaveCredit.balance) - creditCount,
                            days: num_days,
                            action: 'approve'
                        };

                        promises.push(this.saveEmployeeLeaveCredit(employeeLeaveCredit));
                    }

                    Promise.all(promises).then((res) => {
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
                            // approver_id to its previous approver
                            if(request.prev_status == "Pending"){
                                request.approver_id = null;
                            }
                            request.status = request.prev_status;
                            this.saveLeaveRequest(request);
                        });
                        this.alertDialog('Action Invalid', catchError, 'Okay', 'sm');

                        this.loading = false;
                    });
                } else {
                    this.openInvalidApprovalDialog();
                }
            },
            async saveDisapproval(obj) {
                this.dbError = '';
                let requests = [];
                let num_days = 0;

                await _.each(obj.selectedRequests, (request) => {
                    if (request.status !== 'Cancelled') {
                        let data = this.setRequestData(request);

                        if (request.status != "Disapproved") {
                            num_days += (request.duration === 'Whole Day') ?  1 : 0.5;
                        }

                        data.prev_status = request.status;
                        data.status = 'Disapproved';
                        data.approver_id = this.loggedInEmployee.id;
                        data.prev_approver_id = request.approver_id;
                        data.approver_comment = obj.comment;
                        requests.push(data);
                    }
                });

                let promises = [];
                _.each(requests, (request) => {
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
                        action: 'disapprove'
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
                        // approver_id to its previous approver
                        request.approver_id = request.prev_approver_id;
                        request.status = request.prev_status;
                        this.saveLeaveRequest(request);
                    });
                    this.alertDialog('Action Invalid', catchError, 'Okay', 'sm p-ontop');

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
