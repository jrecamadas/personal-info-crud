<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title"></page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="fs-filter-list">
                             <div class="row justify-content-start align-items-end">
                                <div class="col-sm-12 col-md-3 col-lg-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <select2
                                                :options="filterByOptions"
                                                :value="filterByValue"
                                                :hideSearchBox="false"
                                                :placeholder="`Filter By`"
                                                class="form-control"
                                                @select="doFilterByChange($event)">
                                            </select2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="row">
                                        <div class="col-sm-12" v-if="filterByValue === 'name'">
                                            <input type="text"
                                                v-model="filterValue.name"
                                                class="form-control pull-right"
                                                :placeholder="searchPlaceholder">
                                        </div>
                                        <div class="col-sm-12" v-if="filterByValue === 'leaveType'">
                                            <select2
                                                :options="leaveTypeOptions"
                                                :value="filterValue.leaveType"
                                                :hideSearchBox="false"
                                                class="form-control"
                                                @select="doFilterLeaveType($event)">
                                            </select2>
                                        </div>
                                        <div class="col-sm-12" v-if="filterByValue === 'date'">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <flat-pickr
                                                        v-model="filterValue.date.start"
                                                        :config="getConfig(true, false)"
                                                        placeholder="Date From"
                                                        name="start_date"
                                                        class="form-control"/>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <flat-pickr
                                                        v-model="filterValue.date.end"
                                                        :config="getConfig(true, false, {minDate: filterValue.date.start })"
                                                        placeholder="Date To"
                                                        name="end_date"
                                                        class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" v-if="filterByValue === 'status'">
                                            <select2
                                                :options="leaveRequestStatuses"
                                                :value="filterValue.status"
                                                :hideSearchBox="false"
                                                class="form-control"
                                                @select="doFilterStatus($event)">
                                            </select2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-request-table-container">
                            <leave-request-table
                                :columns="tableColumns"
                                :requests="leaveRequestData"
                                @success="reset"
                                :fsReset="reset"
                                :leaveTypes="leaveTypes"
                                :tableDynamics="setTableDynamics">
                            </leave-request-table>
                        </div>
                        <div class="mt-4 mb-4">
                            <infinite-loading
                                :identifier="infiniteId"
                                @infinite="infiniteHandler">
                                <div slot="spinner">
                                    <div class="loader"></div>
                                </div>
                                <div slot="no-more"></div>
                                <div slot="no-results">No results</div>
                            </infinite-loading>
                        </div>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
    </div>
</template>

<style lang="scss" scoped>
    .fs-filter-list {
        margin-bottom: 0.5rem;
    }
</style>

<script>
    // components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import LeaveRequestForApprovalDetail from '@views/pages/leave/_tabs/leave-request-for-approval-detail.vue';
    import Select2 from '@components/select2.vue';
    import FlatPickr from 'vue-flatpickr-component';
    import InfiniteLoading from 'vue-infinite-loading';
    import LeaveRequestTable from '@views/pages/leave/_tabs/leave-request-table.vue';

    // mixins
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import DatePickerMixin from '@common/mixin/DatePicker';

    import {mapGetters, mapActions} from 'vuex';
    import _ from 'lodash';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        components: {
            PageHeader,
            PageContent,
            ModalDialog,
            LeaveRequestForApprovalDetail,
            Select2,
            FlatPickr,
            InfiniteLoading,
            LeaveRequestTable
        },
        mixins: [
            ModalDialogMixin,
            DatePickerMixin
        ],
        data() {
            return {
                title: 'Leave Request Approvals',
                pageClass: 'ks-content-nav',
                searchPlaceholder: 'Search',
                open: false,
                form: {
                    key: '',
                    name: '',
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
                defaultStatus: 'Pending',
                filterByOptions: [
                    {id: 'name', text: 'Name'},
                    {id: 'leaveType', text: 'Leave Type'},
                    {id: 'date', text: 'Date'},
                    {id: 'status', text: 'Status'},
                ],
                filterByValue: '',
                filterValue: {
                    name: '',
                    leaveType: '',
                    date: {
                        start: '',
                        end: '',
                    },
                    status: '',
                },
                page: 1,
                infiniteId: + new Date(),
                tableColumns: [
                    {
                        label: 'Name',
                        klass: 'col-sm-3 text-center',
                        content: 'employeeName'
                    },
                    {
                        label: 'Leave Date(s)',
                        klass: 'col-sm-3 text-center',
                        content: 'dateDisplay'
                    },
                    {
                        label: 'Leave Type',
                        klass: 'col-sm-3 text-center',
                        content: 'leaveTypeName'
                    },
                    {
                        label: 'Batch Status',
                        klass: 'col-sm-3 text-center',
                        content: 'leaveStatus'
                    }
                ],
                setTableDynamics: {
                    hasActions: true,
                    isApprover: true
                }
            };
        },
        watch: {
            'filterValue.name': function() {
                this.reset();
            },
            'filterValue.date.start': function() {
                this.reset();
            },
            'filterValue.date.end': function() {
                this.reset();
            },
            'filterValue.leaveType': function() {
                if (!this.filterValue.leaveType) {   //Set to default when value is NULL
                    this.filterValue.leaveType = this.leaveTypeOptions[0].id;
                }
                this.reset();
            },
            'filterValue.status': function() {
                if (!this.filterValue.status) {   //Set to default when value is NULL
                    this.filterValue.status = this.defaultStatus;
                }
                this.reset();
            }
        },
        computed: {
            ...mapGetters({
                leaveRequests: 'leaveRequests/list',
                leaveRequestStatuses: 'leaveRequestStatuses/formatted',
                leaveTypes: 'leaveTypes/data',
            }),
            leaveTypeOptions() {
                let leaveTypes = [];

                _.each(this.leaveTypes, (leaveType) => {
                    if (leaveType.is_enabled) {
                        leaveTypes.push({id: leaveType.id, text: leaveType.name});
                    }
                });

                return leaveTypes;
            },
            leaveRequestData() {
                return _.groupBy(this.leaveRequests, (leaveRequest) => {
                    return `${leaveRequest.batch}-${leaveRequest.employee_id}`;
                });
            },
        },
        async created() {
            this.clearLeaveRequestList({});
            await this.getLeaveTypes({});
        },
        methods: {
            ...mapActions({
                getLeaveRequestList: 'leaveRequests/getLeaveRequestList',
                getLeaveTypes: 'leaveTypes/getLeaveTypes',
                clearLeaveRequestList: 'leaveRequests/clearLeaveRequestList',
            }),
            getParams() {
                let params = {
                    include: this.include.join(','),
                    batch: 1,
                    page: this.page,
                };

                switch (this.filterByValue) {
                    case 'name':
                        params.searchBy = 'employee.name';
                        params.search = this.filterValue.name;
                        break;
                    case 'status':
                        params.filters = `status|${this.filterValue.status}`;
                        break;
                    case 'leaveType':
                        params.filters = `leaveTypeId|${this.filterValue.leaveType}`;
                        break;
                    case 'date':
                        params.filters = `dates|${this.filterValue.date.start}|${this.filterValue.date.end}`;
                        break;
                }

                if (this.filterByValue !== 'status') {
                    params.status = this.defaultStatus; // pending; as this is a for pending for approval page
                }

                return params;
            },
            infiniteHandler($state) {
                this.getLeaveRequestList({
                    query: _.merge(this.getParams(), {
                        orderBy: [
                            'status|asc' ,
                            'start_date|asc'
                        ],
                        take: 500
                    })
                }).then(({data}) => {
                    if (data.length) {
                        this.page += 1;
                        $state.loaded();
                    }
                    else {
                        $state.complete();
                    }
                });
            },
            reset() {
                this.page = 1;
                this.infiniteId += 1;
                this.clearLeaveRequestList({});
            },
            doFilterByChange(filterBy) {
                this.filterByValue = filterBy;

                switch (filterBy) {
                    case 'status':
                        if (this.filterValue.status.length === 0) {   //Initial value
                            this.filterValue.status = this.defaultStatus;
                        }
                        break;
                    case 'leaveType':
                        if (this.filterValue.leaveType.length === 0) {   //Initial value
                            this.filterValue.leaveType = this.leaveTypeOptions[0].id;
                        }
                        break;
                    case 'date':
                        this.filterValue.date.start = this.$moment(Date.now()).format('YYYY-MM-DD');
                        this.filterValue.date.end = this.$moment(Date.now()).add(1, 'month').format('YYYY-MM-DD');
                    case 'name':
                        this.filterValue.name = '';
                }
                this.reset();
            },
            doFilterStatus(status) {
                this.filterValue.status = status;
                this.reset();
            },
            doFilterLeaveType(leaveType) {
                this.filterValue.leaveType = leaveType;
                this.reset();
            },
        }
    };
</script>
