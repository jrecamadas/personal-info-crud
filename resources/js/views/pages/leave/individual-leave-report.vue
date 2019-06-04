<template>
    <div>
        <page-header v-bind:title="title">
            <div class="dataTable_buttons align-middle button-wrapper" style="padding:0">
                <a v-if="employee" class="btn-sm btn-success align-middle" :href="reportUrl" target="_blank">
                    <span class="la la-file-pdf-o ks-icon"></span>
                    <span class="ks-text">Download PDF</span>
                </a>
            </div>
        </page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="container-fluid">
                <div class="row" v-if="employee">
                    <div class="col-sm-12 col-md-5">
                        <div class="fs-profile px-0">
                            <div class="fs-user p-2">
                                <div class="fs-user-photo align-self-center" :style="'background-image: url(\'' + photo(employee) + '\')'" >
                                    <a>Profile Photo</a>
                                </div>
                                <div class="fs-user-detail">
                                    <p class="user-name">{{ employee.name }}</p>
                                    <p class="user-position">{{ positionTextDisplay(employee.positions) }}</p>
                                    <p class="user-details">{{ departmentTextDisplay(employee.department) }}</p>
                                    <p class="user-details">{{ projectsTextDisplay(employee.projects) }}</p>
                                </div>
                                <div class="fs-employee-no">{{ employee.employee_no }}</div>
                            </div>
                            <div class="fs-employee-detail">
                                <div class="fs-detail-header">
                                    <h5>Yearly PTO Usage Summary</h5>
                                </div>
                                <div class="fs-credit-detail">
                                    <div class="fs-pto-icons">
                                        <div class="card ks-widget-payment-simple-amount-item ks-green">
                                            <div class="payment-simple-amount-item-icon-block">
                                                <span class="fa-3x fa fa-calendar-plus-o"></span>
                                            </div>
                                            <div class="payment-simple-amount-item-body">
                                                <div class="payment-simple-amount-item-amount">
                                                    <h3>{{ employeeAvailablePTOCreditDisplay(employee.leaveCredits, leaveCreditTypes) }}</h3>
                                                </div>
                                                <div class="payment-simple-amount-item-description">
                                                    Available
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fs-pto-icons">
                                        <div class="card ks-widget-payment-simple-amount-item ks-orange">
                                            <div class="payment-simple-amount-item-icon-block">
                                                <span class="fa-3x fa fa-calendar-minus-o"></span>
                                            </div>

                                            <div class="payment-simple-amount-item-body">
                                                <div class="payment-simple-amount-item-amount">
                                                    <h3>{{ employeeTotalUsedPTOCreditsDisplay(employee.leaveRequests, leaveTypes, leaveCreditTypes) }}</h3>
                                                </div>
                                                <div class="payment-simple-amount-item-description">
                                                   Total Used
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 fs-type-used">
                        <h5>Total Leave Types Used</h5>
                        <div class="fs-leaves-used-container">
                            <data-table-no-search
                                v-if="leaveTypesUsedArray.length"
                                :columns="leaveTypesColumns"
                                :id="`ks-datatable-scroll-y`">
                                <template>
                                    <tr
                                        v-for="(leaveTypesUsed, index) in leaveTypesUsedArray"
                                        :key="leaveTypesUsed.leaveTypeID"
                                        :class="index % 2 == 0 ? 'even' : 'odd'">
                                        <td>{{ leaveTypesUsed.leaveTypeName }}</td>
                                        <td>{{ leaveTypesUsed.leaveDaysUsed }}</td>
                                        <td>{{ leaveTypesUsed.leaveDaysPaid }}</td>
                                    </tr>
                                </template>
                            </data-table-no-search>
                            <div v-else>
                                <p>No Results</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fs-leave-history" v-if="employee">
                    <div class="col-sm-12 col-md-12 header">
                        <h5>Leave Application History</h5>
                    </div>
                    <div
                        class="col-sm-12 col-md-12 content"
                        v-if="leaveRequestsArray.length">
                        <div class="fs-history-table-container">
                            <data-table-no-search
                                :columns="leaveApplicationHistoryColumns">
                                <template v-for="(leaveRequest, index) in leaveRequestsArray">
                                    <tr data-index="0" :key="index+'header'">
                                        <td> {{ leaveRequest.leaveTypeName }} </td>
                                        <td> {{ leaveRequest.leaveDateRange }} </td>
                                        <td> {{ leaveRequest.dateFiled }} </td>
                                        <td> {{ leaveRequest.reason }} </td>
                                    </tr>
                                    <tr class="detail-view" :key="index+'content'">
                                        <td colspan="4">
                                            <div class="row">
                                                <div class="col col-sm-12 col-md-2">
                                                    <p><span class="text-bold">Leave Time: </span> {{ leaveRequest.leaveTime }} </p>
                                                    <p><span class="text-bold">Duration: </span> {{ leaveRequest.numberOfDays }} </p>
                                                    <p><span class="text-bold">Whole Day/Half Day: </span> {{ leaveRequest.duration }} </p>
                                                    <p><span class="text-bold">Paid/Unpaid: </span> {{ leaveRequest.isPaid ? "Paid" : "Unpaid" }} </p>
                                                </div>
                                                <div class="col col-sm-12 col-md-10 fs-request-detail" v-if="leaveRequest.days">
                                                    <div class="row">
                                                        <div class="col col-sm-1">
                                                            <span class="text-bold">Date(s):</span>
                                                        </div>
                                                        <div class="col col-sm-2">
                                                            <span class="text-bold">Status:</span>
                                                        </div>
                                                        <div class="col col-sm-3">
                                                            <span class="text-bold">Approver:</span>
                                                        </div>
                                                        <div class="col col-sm-6">
                                                            <span class="text-bold">Remarks:</span>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="row"
                                                        v-for="(days, index) in leaveRequest.days"
                                                        :key="index"
                                                        :class="index % 2 == 0 ? 'even' : 'odd'">
                                                        <div class="col col-sm-1">
                                                            <span>{{ days.start_date }}</span>
                                                        </div>
                                                        <div class="col col-sm-2">
                                                            <span>{{ days.status }}</span>
                                                        </div>
                                                        <div class="col col-sm-3">
                                                            <span>
                                                                {{ (days.status == "Pending" || days.status == "Cancelled") ?
                                                                'No Approver' :
                                                                getApproverNameFromEmployeeID(days.approver_id, employeeList) }}
                                                            </span>
                                                        </div>
                                                        <div class="col col-sm-6">
                                                            <span>{{ (days.status == "Disapproved") ? days.approver_comment : '' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </data-table-no-search>
                        </div>
                    </div>
                    <div class="col-sm-12" v-else>
                        <p>No Results</p>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
    </div>
</template>

<style lang="scss" scoped>
    .fs-user {
        background: #007840;
        box-shadow: 0 0 15px 5px #c1c1c1;
        color: #fff;
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        padding: 5px 8px 5px 8px;
        position: relative;
        -webkit-box-shadow: 0 0 15px 5px #c1c1c1;
        .fs-user-photo {
            width: 140px;
            box-sizing: border-box;
            background-color: #c1c1c1;
            height: 100%;
            background-size: cover;
            background-position: center;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border: 2px solid #fff;
            margin: 0 auto;
            a {
                display: block;
                width: 100%;
                height: 140px;
                text-indent: -999999px;
            }
        }
        .fs-user-detail {
            height: 100%;
            width: calc(50% + 70px);
            box-sizing: border-box;
            background: #007840;
            padding-top: 20px;
        }
        .fs-employee-no {
            writing-mode: vertical-rl;
            text-orientation: sideways;
            transform: rotate(180deg);
            font-size: 28px;
            font-weight: bold;
            position: relative;
            text-align: center;
            letter-spacing: 3px;
        }
        p {
            margin: 0;
            padding: 0;
            line-height: 24px;
            word-break: break-all;
            &.user-profile-url,
            .user-email {
                align-items: center;
                line-height: 1.2;
                text-align: webkit-center;
                margin-bottom: 5px;
                .la {
                    font-size: 22px;
                    font-weight: 500;
                }
            }
            &.user-email {
                align-items: center;
                text-align: webkit-center;
                .la {
                    margin-right: 3px;
                    font-size: 22px;
                    font-weight: 500;
                }
            }
            &.user-position {
                margin-bottom: 10px;
                font-weight: bold;
            }
        }
        .user-name {
            font-weight: bold;
            font-size: 21px;
        }
    }
    .fs-block-flex-row {
        padding-top: 10px;
        padding-right: 3px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .fs-employee-detail {
        background: #ece6e7;
        margin-bottom: 1rem;
        position: relative;
        padding: 2rem 1rem!important;
        .fs-detail-left {
            label {
                width: 100px;
                font-weight: 500;
                margin-right: 10px;
            }
            strong {
                float: right;
                font-weight: 700;
            }
        }
        .fs-detail-header {
            h5 {
                text-transform: uppercase;
                color: #007840;
            }
        }
        .fs-credit-detail {
            text-align: center;
            .fs-pto-icons {
                margin: 1rem 0;
                display: inline-block;
                &:not(:first-child) {
                    margin-left: 2rem;
                }
                .payment-simple-amount-item-body {
                    text-align: left;
                }
            }
        }
    }
    .empProfileSpan {
        font-weight: bold;
    }
    .break-word {
        word-wrap: break-word;
    }
    .fs-profile {
        padding: 15px 0;
    }
    @media (max-width: 1611px) {
        .fs-credit-detail {
            .fs-pto-icons {
                margin-left: 0!important;
            }
        }
    }
    @media (max-width: 1440px) {
        .fs-employee-detail {
            text-align: center;
        }
        .ks-widget-payment-simple-amount-item {
            margin: 0 1.5rem;
            display: block!important;
            position: relative;
            .payment-simple-amount-item-icon-block {
                margin: 0!important;
            }
            .payment-simple-amount-item-body {
                margin-top: 1rem;
                text-align: center!important;
            }
        }
    }
    @media (max-width: 1250px) {
        .fs-user {
            display: block;
            height: auto;
            .fs-user-photo {
                margin: 0 auto;
            }
            .fs-employee-no {
                -webkit-writing-mode: horizontal-tb;
                -ms-writing-mode: inherit;
                writing-mode: horizontal-tb;
                text-orientation: inherit;
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
                font-size: 28px;
                font-weight: bold;
                position: relative;
                top: 0;
                letter-spacing: 3px;
            }
            .fs-user-detail {
                width: 100%;
                text-align: center;
            }
        }
        .fs-employee-detail {
            display: block
        }
        .detail-view {
            td {
                padding: 0.5rem;
            }
        }
        .fs-pto-icons {
            margin: 1rem 0!important;
        }
    }
    @media (max-width: 767px) {
        .fs-user {
            display: flex;
            .fs-user-photo {
                margin: 0 auto;
            }
            .fs-user-detail {
                width: calc(50% + 70px);
                text-align: left;
                margin-left: 10px;
            }
            .fs-employee-no {
                writing-mode: vertical-rl;
                text-orientation: sideways;
                transform: rotate(180deg);
                font-size: 28px;
                font-weight: bold;
                position: relative;
                letter-spacing: 3px;
            }
            .fs-user-detail p .la {
                margin-right: 15px;
            }
        }
        .detail-view {
            .fs-request-detail {
                margin-top: 1rem;
            }
        }
        .fs-type-used {
            padding: 0 15px!important;
        }
        .fs-leave-history {
            .header {
                margin-bottom: 0px!important;
            }
        }
    }
    @media (max-width: 600px) {
        .fs-user {
            display: block;
            height: auto;
            .fs-user-photo {
                margin: 0 auto;
            }
            .fs-employee-no {
                -webkit-writing-mode: horizontal-tb;
                -ms-writing-mode: inherit;
                writing-mode: horizontal-tb;
                text-orientation: inherit;
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
                font-size: 28px;
                font-weight: bold;
                position: relative;
                top: 0;
                letter-spacing: 3px;
            }
            .fs-user-detail {
                width: 100%;
                text-align: center;
                margin-left: 0px;
            }
        }
    }
    @media (max-width: 530px) {
        .button-wrapper {
            margin-top: 2px;
            margin-bottom: 2px;
            .btn {
            margin: 2px 0;
            float: right;
            }
            .custom-size {
            padding: 10px 19px;
            }
        }
    }
    .ks-widget-payment-simple-amount-item.ks-green .payment-simple-amount-item-icon-block {
        background-color: #81C159;
    }
    .ks-widget-payment-simple-amount-item.ks-orange .payment-simple-amount-item-icon-block {
        background-color: #F88528;
    }
    .ks-widget-payment-simple-amount-item .payment-simple-amount-item-icon-block {
        width: 64px;
        height: 64px;
        -webkit-border-radius: 32px;
        border-radius: 32px;
        display: -webkit-inline-box;
        display: -webkit-inline-flex;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        margin-right: 20px;
        .fa-3x {
            color: #fff;
            margin-top: -2px!important;
            margin-right: -2px!important;
        }
    }
    [class^="ks-icon-"], [class*=" ks-icon-"] {
        font-family: 'kosmo' !important;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .ks-widget-payment-simple-amount-item .payment-simple-amount-item-icon-block>[class*=ks-icon-] {
        font-size: 24px;
    }
    .ks-widget-payment-simple-amount-item .payment-simple-amount-item-icon-block>.ks-icon {
        position: relative;
        left: 1px;
        color: #fff;
        font-size: 32px;
    }
    .ks-widget-payment-simple-amount-item {
        background: transparent!important;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        -js-display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        border-color: #e5e5e5;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }
    .fs-type-used {
        padding: 0.25rem 2rem 0 0.5rem;
    }
    .fs-leave-history {
        margin-top: 1rem;
        .header {
            margin-bottom: 1rem;
        }
        .fs-history-table-container {
            table {
                tr.detail-view {
                    td {
                        padding: 1rem;
                        .row {
                            margin: 0;
                            .col {
                                padding: 0;
                            }
                        }
                    }
                    p {
                        margin: 0;
                    }
                }
            }
        }
        .text-bold {
            font-weight: 600;
        }
    }
</style>

<script>
    //Components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import DataTableNoSearch from '@components/datatable-no-search.vue'

    //Mixins
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import EmployeeMixin from '@common/mixin/EmployeeMixin';
    import LeavesMixin from '@common/mixin/LeavesMixin';
    import DataTableMixin from '@common/mixin/DataTableMixin'

    //Libraries
    import { mapActions, mapGetters } from 'vuex';
    import _ from 'lodash';

    export default {
        data() {
            return {
                title: 'Employee Leave Report',
                open: false,
                modal: {
                    width: '800px',
                    height: '400px'
                },
                form: {
                    key: '',
                    name: ''
                },
                reportUrl: '',
                pageClass: 'ks-profile',
                include: [
                    'department',
                    'employeeStatuses',
                    'leaveCredits',
                    'leaveCreditHistories',
                    'leaveRequests',
                    'photo',
                    'positions',
                    'projects.clientProject',
                    'user',
                ],
                leaveTypesSortKey: 'leaveType',
                leaveTypesColumns: [
                    {
                        label: 'Leave Type',
                        sortKey: 'leaveType',
                        width: '40%',
                        sortable: false
                    },
                    {
                        label: 'Number of Days Used',
                        sortKey: 'leaveDaysUsed',
                        width: '30%',
                        sortable: false
                    },
                    {
                        label: 'Number of Paid Leaves',
                        sortKey: 'leaveDaysPaid',
                        width: '30%',
                        sortable: false
                    },
                ],
                leaveRequestDaysSortOrder: {},
                leaveRequestDaysSortKey: 'startDate',
                leaveRequestDaysColumns: [
                    {
                        label: 'Date(s)',
                        key: 'startDate',
                        sortKey: 'startDate',
                        width: '15%',
                        sortable: false
                    },
                    {
                        label: 'Status',
                        key: 'status',
                        sortKey: 'status',
                        width: '15%',
                        sortable: false
                    },
                    {
                        label: 'Approver',
                        key: 'approver',
                        sortKey: 'approver',
                        width: '30%',
                        sortable: false
                    },
                    {
                        label: 'Comment',
                        key: 'approverComment',
                        sortKey: 'approverComment',
                        width: '40%',
                        sortable: false
                    },
                ],
                leaveApplicationHistoryColumns: [
                    {
                        label: 'Leave Types',
                        width: '17.3%'
                    },
                    {
                        label: 'Date(s)',
                        width: '20%'
                    },
                    {
                        label: 'Date Filed',
                        width: '20%'
                    },
                    {
                        label: 'Reason',
                        width: '45%'
                    }
                ]
            };
        },
        computed: {
            ...mapGetters({
                employee: 'employees/single',
                employeeList: 'employees/formatted',
                employeeLeaveRequests: 'leaveRequests/single',
                leaveCreditTypes: 'leaveCreditTypes/formatted',
                leaveTypes: 'leaveTypes/data',
            }),
            // Create Array for Leave Types Used Table
            leaveTypesUsedArray : function () {
                let leaveTypesUsedArray = [],
                    leaveRequestArrayOriginal = [];
                //Fetch original list of Employee's Leave Requests
                if (this.employee) {
                    if (this.employee.leaveRequests && _.has(this.employee.leaveRequests, 'data')) {
                        leaveRequestArrayOriginal = _.filter(this.employee.leaveRequests.data, ['status', 'Approved']);
                        //Iterate for each Leave Types there is
                        _.forEach(this.leaveTypes, function(leaveType) {
                            let leaveRequestArray = leaveRequestArrayOriginal,
                                leaveDaysUsed = 0,
                                leaveDaysPaid = 0;
                            leaveRequestArray = _.filter(leaveRequestArray, ['leave_type_id', leaveType.id]);
                            //Get total Leave Days Used and Leave Days Paid with Whole Day/Half Day in mind
                            _.forEach(leaveRequestArray, function(leaveRequest) {
                                let toAdd = (leaveRequest.duration === 'Half Day')? 0.5 : 1;

                                leaveDaysUsed += toAdd;
                                leaveDaysPaid += parseInt(leaveRequest.is_paid) * toAdd;

                            });
                            leaveTypesUsedArray.push(
                                {
                                    leaveTypeID: leaveType.id,
                                    leaveTypeName: leaveType.name,
                                    leaveDaysUsed: leaveDaysUsed.toLocaleString(undefined,
                                        {minimumFractionDigits: 2, maximumFractionDigits: 2}),
                                    leaveDaysPaid: leaveDaysPaid.toLocaleString(undefined,
                                        {minimumFractionDigits: 2, maximumFractionDigits: 2}),
                                }
                            );
                        });
                    }
                }
                return leaveTypesUsedArray;
            },
            leaveRequestsArray : function () {
                let leaveRequestsArray = [];
                if (this.employee.leaveRequests) {
                    if (_.has(this.employee.leaveRequests, 'data'))   {

                        let leaveRequestsStore = _.groupBy(this.employee.leaveRequests.data, (leaveRequest) =>  {
                            return `${leaveRequest.batch}`;
                        });

                        _.forOwn(leaveRequestsStore, (leaveRequest, batch) => {
                            leaveRequestsArray.push(
                                {
                                    batch: parseInt(batch),
                                    leaveTypeName: (_.find(this.leaveTypes, ['id', leaveRequest[0].leave_type_id])).name,
                                    leaveDateRange:
                                        `${(_.minBy(leaveRequest, 'start_date')).start_date} to
                                        ${(_.maxBy(leaveRequest, 'end_date')).end_date}`,
                                    dateFiled: moment(leaveRequest[0].created_at.date).format('YYYY-MM-DD, hh:mm:ss A'),
                                    reason: leaveRequest[0].reason,
                                    leaveTime:
                                        `${moment(leaveRequest[0].start_time, 'HH:mm:ss').format('hh:mm A')} -
                                        ${moment(leaveRequest[0].end_time, 'HH:mm:ss').format('hh:mm A')}`,
                                    numberOfDays: `${leaveRequest.length}${(leaveRequest.length > 1) ? ' days' : ' day'}`,
                                    duration: leaveRequest[0].duration,
                                    isPaid: leaveRequest[0].is_paid,
                                    days: _.orderBy(leaveRequest, ['start_date'], ['asc'])
                                }
                            );
                        });
                        leaveRequestsArray = _.orderBy(leaveRequestsArray, ['leaveDateRange'], ['desc']);
                    }
                }
                return leaveRequestsArray;
            },
        },
        created () {
            this.getData(this.$route.params.id);
        },
        methods: {
            ...mapActions({
                getEmployee: 'employees/getEmployee',
                getEmployeeNames: 'employees/getEmployeeNames',
                getLeaveCreditTypes: "leaveCreditTypes/getLeaveCreditTypes",
                getLeaveTypes: "leaveTypes/getLeaveTypes"
            }),
            async getData(employeeID) {
                await this.getEmployeeNames({ query: { take: 99999 }});
                await this.getLeaveCreditTypes({ query: { take: 99999 }});
                await this.getLeaveTypes({ query: { take: 99999 }});
                // Get Employee Data
                try {
                    await this.getEmployee({
                        id: employeeID,
                        include: this.include.join(',')
                    });
                } catch (e) {
                    console.log("getData() Error Message: ", e);
                    // User cannot be found
                    // Redirect back to employees list
                    this.$router.push('/leave-reports');
                }
                this.getDownloadLink();
            },
            getDownloadLink() {
                let uname = this.employee.unique_str || this.employee.user.data.user_name;
                this.reportUrl = '/leaves/' + uname + '/report';
            },
        },
        components: {
            PageHeader,
            PageContent,
            DataTableNoSearch,
            ModalDialog
        },
        mixins: [
            EmployeeMixin,
            LeavesMixin,
            DataTableMixin,
        ]
    };
</script>
