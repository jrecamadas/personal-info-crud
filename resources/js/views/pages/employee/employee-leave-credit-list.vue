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
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="dataTable_buttons">
                                     <!--buttons-->
                                </div>
                            </div>
                        </div>
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            :searchPlaceholder="searchPlaceholder"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <!-- BEGIN EMPLOYEES DATA -->
                            <tbody>
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(employee, index) in employees"
                                    :key="employee.id">
                                    <td>
                                        <router-link
                                            :to="{name: 'employee', params: {id: employee.id}}"
                                            class="user-profile">
                                            {{ employee.employee_no }}
                                        </router-link>
                                    </td>
                                    <td>
                                        <a href="javascript:;" @click="openSetLeaveCreditModal(employee)">
                                            {{ employee.name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ positionTextDisplay(employee.positions) }}
                                    </td>
                                    <td>
                                        {{ projectsTextDisplay(employee.projects) }}
                                    </td>
                                    <td>
                                        {{ employeeStatusDisplay(employee.employeeStatuses, employee.id) }}
                                    </td>
                                    <td
                                        v-for="(leaveCreditType) in leaveCreditTypesData"
                                        :key="leaveCreditType.id">
                                        {{ employeeLeaveCreditDisplay(employee.leaveCredits, leaveCreditType.id) }}
                                    </td>
                                    <td class="text-center">
                                        <a
                                            title="View Reset History"
                                            href="javascript:void(0);"
                                            class="action-button"
                                            @click.stop="showResetHistory(employee)">
                                            <span class="la la-history"></span>
                                        </a>
                                        <Can I="update" a="employee_leave_credits">
                                            <a
                                                title="Reset Leave Credits"
                                                href="javascript:void(0);"
                                                class="action-button"
                                                @click.stop="resetConfirmation(employee)">
                                                <span class="la la-refresh"></span>
                                            </a>
                                        </Can>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END EMPLOYEES DATA -->
                            <!-- BEGIN SET LEAVE CREDIT MODAL -->
                            <set-leave-credit-modal
                                v-if="open && form.key === 'set-leave-credit'"
                                :openModal="open"
                                @close="open = false"
                                :info="currentEmployee"
                                :creditTypes="leaveCreditTypesData"
                                @success="updateData">
                            </set-leave-credit-modal>
                            <!-- END SET LEAVE CREDIT MODAL -->
                        </data-table>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
    </div>
</template>

<style lang="scss" scoped>
    .action-button {
        span {
            font-weight: bold;
            font-size: 19px;
        }
    }
    div.dataTables_wrapper table.dataTable.table-bordered td,
    div.dataTables_wrapper table.dataTable.table-bordered th {
        vertical-align: middle;
    }
</style>

<script>
    // components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import SetLeaveCreditModal from '@views/pages/leave/_modals/set-leave-credit.vue';

    // mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import LeavesMixin from '@common/mixin/LeavesMixin';

    import {mapGetters, mapActions} from 'vuex';
    import _ from 'lodash';

    export default {
        components: {
            PageHeader,
            PageContent,
            DataTable,
            ModalDialog,
            SetLeaveCreditModal,
        },
        mixins: [
            DataTableMixin,
            ModalDialogMixin,
            AlertMixin,
            LeavesMixin
        ],
        data() {
            let columns = [
                {
                    label: 'ID',
                    key: 'employee_no',
                    sortKey: 'employee_no',
                    sortable: true,
                },
                {
                    label: 'Name',
                    key: 'name',
                    sortKey: 'last_name',
                    sortable: true,
                },
                {
                    label: 'Position',
                    key: 'position',
                    sortKey: 'job_positions.job_title',
                    width: '20%',
                    sortable: true,
                },
                {
                    label: 'Project',
                    key: 'projects.project_name',
                    sortKey: 'projects.name',
                    sortable: false,
                },
                {
                    label: 'Employment Status',
                    key: 'statuses.name',
                    sortKey: 'statuses.name',
                    sortable: true,
                },
            ];
            let sortOrder = {};

            columns.forEach(col => {
                sortOrder[col.sortKey] = 'desc';
            });

            return {
                title: 'Set Leave Credits',
                pageClass: 'ks-content-nav',
                sortKey: 'employee_no',
                sortOrder: sortOrder,
                searchSpecific: 'name',
                searchByOptions: [
                    {id: 'name', text: 'Name'},
                    {id: 'empID', text: 'Employee ID'},
                ],
                searchPlaceholder: 'Search',
                limit: 50,
                open: false,
                term: '',
                data: {
                    columns: columns,
                    rows: [],
                },
                form: {
                    key: '',
                    name: '',
                },
                modal: {
                    width: '800px',
                    height: '400px',
                },
                currentEmployee: {},
                include: [
                    'leaveCredits',
                    'employeeStatuses',
                    'positions',
                    'projects.clientProject',
                    'leaveCreditHistories',
                ],
            };
        },
        async created() {
            // init
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPaginationLimit(this.limit);

            await this.getLeaveCreditTypes({query: {take: 9999}});
            this.updateColumnList();

            this.setSearchBy(this.searchSpecific);
            this.getData();
        },
        computed: {
            ...mapGetters({
                meta: 'employees/meta',
                employees: 'employees/data',
                leaveCreditTypesData: 'leaveCreditTypes/data',
            })
        },
        methods: {
            ...mapActions({
                getEmployees: 'employees/getEmployees',
                getLeaveCreditTypes: 'leaveCreditTypes/getLeaveCreditTypes',
                saveEmployeeLeaveCredit: 'employeeLeaveCredits/saveEmployeeLeaveCredit',
                saveEmployeeLeaveCreditHistory: 'employeeLeaveCreditHistories/saveEmployeeLeaveCreditHistory',
            }),
            updateData() {
                this.getData();
                this.open = false;
                this.form = {key: '', name: ''};
            },
            async getData() {
                await this.getEmployees({
                    query: _.merge(this.getParams(), {include: this.include.join(',')}),
                });

                // set pagination
                this.setPagination(this.meta.pagination);
            },
            updateColumnList() {
                _.each(this.leaveCreditTypesData, (leaveCreditType) => {
                    this.data.columns.push({
                        label: leaveCreditType.name,
                        key: leaveCreditType.id,
                        sortable: false,
                    });
                });

                this.data.columns.push({
                    label: 'Action',
                    key: 'action',
                    sortable: false,
                });
            },
            setPagination(data) {
                this.config.pagination.lastPage = data.last_page;
                this.config.pagination.currentPage = data.current_page;
                this.config.pagination.total = data.total;
                this.config.pagination.perPage = data.per_page;       //perPage is the same as limit
                this.config.pagination.nextPageUrl = data.links.next;
                this.config.pagination.prevPageUrl = data.links.previous;
                this.config.pagination.from = this.paginationFrom;
                this.config.pagination.to = this.paginationTo;
                this.config.pagination.pages = this.paginationPages;

                this.query.pagination.currentPage = this.config.pagination.currentPage;
            },
            paginate(page) {
                this.gotoPage(page);
                this.getData();
            },
            updateList(limit) {
                this.setPaginationLimit(limit);
                this.getData();
            },
            employeeLeaveCreditDisplay(leaveCredits, leaveCreditTypeId) {
                let balance = '';
                if (_.has(leaveCredits,'data')) {
                    _.each(leaveCredits.data, (leaveCredit) => {
                        if (leaveCredit.leave_credit_type_id === leaveCreditTypeId) {
                            balance = leaveCredit.balance;
                        }
                    });
                }

                return balance.length ? balance : '0.00';
            },
            sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';

                this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                this.getData();
            },
            search(term) {
                this.term = term;
                this.gotoPage();
                if (this.timeOut != null) {
                    this.isTyping = false;
                    clearTimeout(this.timeOut);
                    this.timeOut = null;
                }
                if (!this.isTyping) {
                    this.timeOut = setTimeout(this.doSearch, 300);
                }
            },
            doSearch() {
                this.setSearch(this.term);
                this.setSearchBy(this.searchSpecific);
                this.getData();
            },
            openModals(form) {
                this.form = form;
                this.open = true;
            },
            openSetLeaveCreditModal(employee) {
                this.currentEmployee = employee;
                this.openModals({key: 'set-leave-credit', name: 'Set Leave Credit'});
            },
            resetConfirmation(employee) {
                const title = 'Reset Leave Credits';
                const msg = `Are you sure you want to reset leave credits for ${employee.name}?`;
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                .then(({ok}) => {
                    if(ok) {
                        this.resetLeaveCredits(employee);
                    }
                });
            },
            async resetLeaveCredits(employee) {
                let promises = [];
                let employeeLeaveCreditObject = {};

                // Update Balance
                await _.each(this.leaveCreditTypesData, (leaveCreditType) => {
                    employeeLeaveCreditObject = _.find(
                        employee.leaveCredits.data,
                        [
                            'leave_credit_type_id',
                            leaveCreditType.id
                        ]);
                    employeeLeaveCreditObject = (employeeLeaveCreditObject) ?
                        {
                            'id': employeeLeaveCreditObject.id,
                            'employee_id': employeeLeaveCreditObject.employee_id,
                            'leave_credit_type_id': employeeLeaveCreditObject.leave_credit_type_id,
                            'balance': employeeLeaveCreditObject.balance,
                        } :
                        {
                            'id': '',
                            'employee_id': employee.id,
                            'leave_credit_type_id': leaveCreditType.id,
                            'balance': '0.00',
                        };
                    // Save current Employee Leave Credit record to history.
                    promises.push(this.saveEmployeeLeaveCreditHistory({
                        id: '',
                        employee_id: employeeLeaveCreditObject.employee_id,
                        leave_credit_type_id: employeeLeaveCreditObject.leave_credit_type_id,
                        balance: employeeLeaveCreditObject.balance
                    }));
                    // Replenish Leave Credits
                    promises.push(this.saveEmployeeLeaveCredit({
                        id: employeeLeaveCreditObject.id,
                        employee_id: employeeLeaveCreditObject.employee_id,
                        leave_credit_type_id: employeeLeaveCreditObject.leave_credit_type_id,
                        balance: leaveCreditType.limit,
                    }));
                });

                Promise.all(promises).then((res) => {
                    this.updateData();
                });
            },
            showResetHistory(employee) {
                const title = 'Leave Credit Reset History';
                const msg = (employee.leaveCreditHistories.data && employee.leaveCreditHistories.data.length) ?
                    `Last Reset for ${employee.name} was ${_.last(employee.leaveCreditHistories.data).reset_date}` :
                    `No Leave Credits Reset for ${employee.name} yet`;
                this.alertDialog(title, msg, 'Ok', 'sm')
            },

        }
    }
</script>
