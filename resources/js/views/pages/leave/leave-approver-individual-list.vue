<template>
    <div>
        <page-header :title="title"></page-header>
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid" v-if="approver.approver">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <h2>{{ approver.approver.data.name }}</h2>
                                <div class="dataTable_buttons">
                                    <button type="button" @click="openModals({key: 'add-employee', name: 'Add Employee'})" tag="button" class="btn btn-primary">Add Employee</button>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN SKILLS DATA -->
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <tbody>
                                <tr
                                    :class="alternateBgColor(index)"
                                    style="cursor:point"
                                    v-for="(employeeApprover, index) in employeeApprovers" 
                                    :key="employeeApprover.id"
                                    >
                                    <td>
                                        {{employeeApprover.employee.data.name}}
                                    </td>
                                    <td>{{ formatDepartmentToWords(employeeApprover.employee.data.department) }}</td>
                                    <td>{{ projectsTextDisplay(employeeApprover.employee.data.projects) }}</td>
                                    <td align="center">
                                        <a href="#" class="action-button" title="Delete Employee" @click="showDeleteConfirmation(employeeApprover.id, employeeApprover.employee.data.name)">
                                            <i class="la la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        <!-- END SKILLS DATA -->
                    </div>
                </div>
            </div>
            <!-- BEGIN WORK DETAIL DIALOG -->
            <add-employee-modal 
                v-if="form.key == 'add-employee' && open" 
                :openModal="open" 
                @close="open = false" 
                :info="form"
                @success="getData"
                ></add-employee-modal>
            <!-- END WORK DETAIL DIALOG -->
        </page-content>
    </div>
</template>

<style lang="scss" scoped>
    .action-button {
        font-size: 20px;
    }
</style>

<script>
    // components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    
    import ModalDialog from '@components/modal-dialog.vue';
    import AddEmployeeModal from '@views/pages/leave/_modals/add-employee.vue';

    // mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import LeavesMixin from '@common/mixin/LeavesMixin';

    import { mapActions, mapGetters } from 'vuex';

    export default {
        data() {
            let sortOrder = {};
            let sortKey = 'employees.last_name'
            let columns = [
                { 
                    label: 'Employee Name', 
                    key: 'employees.last_name', 
                    sortKey: 'employees.last_name',
                    width: '45%', 
                    sortable: true 
                },
                { 
                    label: 'Department', 
                    key: 'department.name', 
                    sortKey: 'department.name', 
                    width: '45%', 
                    sortable: true 
                },
                { 
                    label: 'Project',
                    key: 'project',
                    sortKey: 'project',
                    width: '10%',
                    sortable: false 
                },
                { 
                    label: 'Actions', 
                    key: 'action', 
                    width: '10%', 
                    sortable: false 
                },
            ];

            columns.forEach(function(col) {
                sortOrder[col.sortKey] = 'asc'
            });

            return {
                title: 'Individual Approver Page',
                pageClass: 'ks-content-nav',
                sortKey:sortKey,
                sortOrder:sortOrder,
                limit: 50,
                open: false,
                searchSpecific: 'name',
                data: {
                    columns:columns,
                    rows: []
                },
                form: {
                    key: '',
                    name: '',
                    employee:{}
                },
                projectIdToWords: {},
                project_list: [],
                departmentIdToWords: {},
                include: ['approver', 'officerInCharge']
            };
        },
        async created() {
            await this.getApprover({
                id: this.$route.params.id,
                include: this.include.join(',')
            });
            await this.getEmployees({query: {take: 10000, orderBy: 'last_name|asc', include: 'projects'}});
            await this.getDepartments({query: {take: 10000}});
            await this.getDepartmentIdToWords();
            await this.getClients({query: {take: 10000}});
            await _.each(this.clients, (client) => {
                if (client.projects) {
                    _.each(client.projects.data, (project) => {
                        if(project.project_name && this.project_list.indexOf(project.project_name) == -1) {
                            this.projectIdToWords[project.id] = project.project_name;
                            this.project_list.push(project.project_name);
                        }
                    });
                }
            });
            this.setSearchBy(this.searchSpecific);
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPaginationLimit(this.limit);
            await this.getData();
        },
        components: {
            DataTable,
            PageHeader,
            PageContent,
            ModalDialog,
            AddEmployeeModal,

        },
        computed: {
            ...mapGetters({
                employees: 'employees/data',
                approver: 'leaveApprovers/approver',
                employeeApprovers: 'employeeApprovers/data',
                departments: 'departments/formatted',
                clients: 'clients/formatted',
                meta: 'employeeApprovers/meta',
            })
        },
        methods : {
            ...mapActions({
                getApprover: 'leaveApprovers/getApprover',
                deleteEmployeeApprover: 'employeeApprovers/deleteEmployeeApprover',
                getEmployees: 'employees/getEmployees',
                getDepartments: 'departments/getDepartments',
                getClients: 'clients/getClients',
                getEmployeeApproversAll: 'employeeApprovers/getEmployeeApproversAll',
                getEmployeeApprovers: 'employeeApprovers/getEmployeeApprovers'
            }),
            openModals(formOptions) {
                this.form = formOptions;
                this.open = true;
            },
            getDepartmentIdToWords() {
                _.each(this.departments, (department) => {
                    this.departmentIdToWords[department.id] = department.text;
                });
            },
            async reload() {
                await this.getData();
                this.setPagination(this.meta.pagination);
            },
            formatDepartmentToWords(department_id) {
                return this.departmentIdToWords[department_id];
            },
            formatProjectToWords(projects) {
                let projectsStr = [];
                _.each(projects, (project) => {
                    projectsStr.push(this.projectIdToWords[project.client_project_id]);
                });
                return projectsStr.join(', ');
            },
            async getData() {
                await this.getEmployeeApprovers({
                    query: _.merge(this.getParams(), {
                        leave_approver_id: this.$route.params.id,
                        include: 'employee,employee.projects'
                    })
                });
                this.setPagination(this.meta.pagination);
                await this.getEmployeeApproversAll({
                    leave_approver_id: this.$route.params.id,
                    include: 'employee,employee.projects.clientProject',
                    take: 10000 
                });
            },
            paginate(page) {
                this.gotoPage(page);
                this.getData();
            },
            updateList(limit) {
                this.setPaginationLimit(limit);
                this.getData();
            },
            doSearch() {
                this.setSearch(this.term);
                this.setSearchBy(this.searchSpecific);
                this.getData();
            },
            async search(term) {
                this.term = term;
                this.gotoPage();
                if (this.timeOut != null) {
                    this.isTyping = false;
                    clearTimeout(this.timeOut);
                    this.timeOut = null;
                }
                if (!this.isTyping) this.timeOut = setTimeout(this.doSearch, 300);
            },
            async sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
                this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                this.getData();
            },
            showDeleteConfirmation(employee_id, employee_name) {
                const title = 'Are you sure you want to delete this record?';
                const msg = `${employee_name}`;
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                    .then(({ok}) => {
                        if (ok) this.delete(employee_id).then(() => {
                            this.reload();
                            this.notifyDialog('error', 'Successfully deleted!');
                        });
                    });
            },
            delete(employee_id) {
                return this.deleteEmployeeApprover(employee_id);
            }
        },
        mixins: [
            ModalDialogMixin,
            DataTableMixin,
            AlertMixin,
            LeavesMixin
        ]
    }
</script>