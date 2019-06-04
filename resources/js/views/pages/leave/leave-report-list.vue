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
                                        <router-link
                                            :to="{name: 'individual-leave-report', params: {id: employee.id}}"
                                            class="user-profile">
                                            {{ employee.name }}
                                        </router-link>
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
                                    <td>
                                        {{ employeeAvailablePTOCreditDisplay(employee.leaveCredits, leaveCreditTypes) }}
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END EMPLOYEES DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
    </div>
</template>

<style lang="scss" scoped>

</style>

<script>
    // Components
    import PageHeader from "@components/page-header.vue";
    import PageContent from "@components/page-content.vue";
    import DataTable from "@components/datatable.vue";

    // Mixins
    import DataTableMixin from "@common/mixin/DataTableMixin";
    import LeavesMixin from "@common/mixin/LeavesMixin";

    // Libraries
    import { mapGetters, mapActions } from "vuex";
    import _ from "lodash";

    export default {
        data() {
            let columns = [
                {
                    label: 'ID',
                    key: 'employee_no',
                    sortKey: 'employee_no',
                    sortable: true
                },
                {
                    label: 'Name',
                    key: 'name',
                    sortKey: 'last_name',
                    sortable: true
                },
                {
                    label: 'Positions',
                    key: 'positions',
                    sortKey: 'job_positions.job_title',
                    sortable: true
                },
                { //Query returned per Employee is an Array. Cannot be sorted.
                    label: 'Project',
                    key: 'projects.clientProjects.project_name',
                    sortKey: 'projects.clientProjects.project_name',
                    sortable: false
                },
                {
                    label: 'Employee Status',
                    key: 'statuses.name',
                    sortKey: 'statuses.name',
                    sortable: true
                },
                { //Query returned per Employee is an Array. Cannot be sorted.
                    label: 'Available PTO Credits',
                    key: 'leaveCredits.balance',
                    sortKey: 'leaveCredits.balance',
                    sortable: false
                }
            ];
            let sortOrder = {};

            columns.forEach(col => {
                sortOrder[col.sortKey] = 'desc';
            });

            return {
                title: 'Leave Reports',
                pageClass: 'ks-content-nav',
                sortKey: 'employee_no',
                sortOrder: sortOrder,
                searchSpecific: 'name',
                searchByOptions: [
                    { id: 'name', text: 'Name'},
                    { id: 'empID', text: 'Employee ID'}
                ],
                searchPlaceholder: 'Search',
                limit: 50,
                open: false,
                term: '',
                data: {
                    columns: columns,
                    rows: []
                },
                form: {
                    key: '',
                    name: ''
                },
                currentEmployee: {},
                include: [
                    'leaveCredits',
                    'employeeStatuses',
                    'department',
                    'projects.clientProject',
                    'positions'
                ],
            }
        },
        async created() {

            // Set Pagination
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPaginationLimit(this.limit);
            this.setSearchBy(this.searchSpecific);

            // Init
            this.getEmployeeData();

            // Get Leave Credit Types
            await this.getLeaveCreditTypes({ query: { take: 9999 }});
        },
        computed: {
            ...mapGetters({
                meta: 'employees/meta',
                employees: 'employees/data',
                leaveCreditTypes: 'leaveCreditTypes/formatted',
            }),
        },
        methods: {
            ...mapActions({
                getEmployees: 'employees/getEmployees',
                getLeaveCreditTypes: 'leaveCreditTypes/getLeaveCreditTypes',
            }),
            updateData() {
                this.getEmployeeData();
                this.open = false;
                this.form = {key: '', name: ''};
            },
            async getEmployeeData() {
                // Get Employees
                await this.getEmployees({
                    query: _.merge(this.getParams(), { include: this.include.join(',') })
                });
                // Set Pagination
                this.setPagination(this.meta.pagination);
            },
            setPagination(data) {
                this.config.pagination.lastPage = data.last_page;
                this.config.pagination.currentPage = data.current_page;
                this.config.pagination.total = data.total;
                this.config.pagination.perPage = data.per_page;       //perPage is the same as limit
                this.config.pagination.nextPageUrl = data.links.next;
                this.config.pagination.prevPageUrl = data.links.previous;
                this.config.pagination.from = this.paginationFrom;
                this.config.pagination.to =this.paginationTo;
                this.config.pagination.pages = this.paginationPages;

                this.query.pagination.currentPage = this.config.pagination.currentPage;
            },
            paginate(page) {
                this.gotoPage(page);
                this.getEmployeeData();
            },
            updateList(limit) {
                this.setPaginationLimit(limit);
                this.getEmployeeData();
            },
            sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';

                this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                this.getEmployeeData();
            },
            search(term) {
                this.term = term;
                this.gotoPage();
                if (this.timeOut != null) {
                    this.isTyping = false;
                    clearTimeout(this.timeOut);
                    this.timeOut = null;
                }
                if (!this.isTyping) this.timeOut = setTimeout(this.doSearch, 300);
            },
            async doSearch() {
                this.setSearch(this.term);
                this.setSearchBy(this.searchSpecific);
                await this.getEmployeeData();
            },
        },
        components: {
            PageHeader,
            PageContent,
            DataTable,
        },
        mixins: [
            DataTableMixin,
            LeavesMixin,
        ],
    }
</script>
