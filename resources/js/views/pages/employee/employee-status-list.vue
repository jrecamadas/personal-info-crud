<template>
   <div>
      <page-header :title="title"></page-header>
      <page-content :pageClass="pageClass">
         <div class="ks-nav-body">
            <div class="ks-nav-body-wrapper">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-sm-12 col-md-7">
                         <Can I="add" a="employee_status">
                            <div class="dataTable_buttons">
                                <button type="button" @click="openStatusModal({key: 'create-employee-status', name: 'Add Status', data: {id:0, name: '', description: ''}})" tag="button" class="btn btn-primary">Add Employee Status</button>
                            </div>
                         </Can>
                     </div>
                  </div>
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
                  <!-- BEGIN STATUS DATA -->
                  <tbody v-if="status.length">
                     <tr
                        :class="index % 2 == 0 ? 'even' : 'odd'"
                        style="cursor: pointer"
                        v-for="(status, index) in statuses"
                        :key="status.id">
                        <td>{{ status.name }}</td>
                        <td>{{ status.description }}</td>
                        <td align="center">
                            <Can I="update" a="employee_status">
                                <a href="javascript:;" class="action-button" title="Edit Employee Status" @click="showEditDialogoue({key: 'create-employee-status', name:'Update Status', data: status})">
                                    <i class="la la-pencil"></i>
                                </a>
                            </Can>
                            <Can I="delete" a="employee_status">
                                <a href="javascript:;" class="action-button" title="Delete Employee Status" @click="showDeleteConfirmation(status.id, status.name)">
                                    <i class="la la-trash"></i>
                                </a>
                            </Can>
                        </td>
                     </tr>
                  </tbody>
                  <!-- END STATUS DATA -->
                  </data-table>
               </div>
            </div>
         </div>
         <!-- BEGIN MODAL DIALOG -->
         <create-employee-status-modal
            v-if="open && form.key == 'create-employee-status'"
            :openModal="open"
            @close="open = false"
            @success="reload()"
            :info="currentItem"
            :form="form"
            ></create-employee-status-modal>
         <!-- END MODAL DIALOG -->
      </page-content>
   </div>
</template>
<style scope>
    .action-button {
        font-size: 20px;
    }
</style>

<script>
    //Components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import Select2 from '@components/select2.vue';
    import ShowStatusList from '@views/pages/applicants/_modals/show-status-list.vue';

    //Models
    import { Employee } from '@common/model/Employee';

    //Modals
    import ModalDialog from '@components/modal-dialog.vue';
    import CreateEmployeeStatusModal from '@views/pages/employee/_modals/create-employee-status.vue';

    //Mixins
    import AlertMixin from '@common/mixin/AlertMixin';
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import EmployeeMixin from '@common/mixin/EmployeeMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

    import { mapGetters, mapActions } from 'vuex';

    import _ from 'lodash';

    export default {
        data() {
            let sortKey = 'employee_no';
            let columns = [
                { label: 'Name', key: 'name', sortKey: 'name', width: '45%', sortable: true },
                { label: 'Description', key: 'description', sortKey: 'description', width: '45%', sortable: false },
                { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
            ];


            let sortOrder = {
                id: 'desc'
            };

            columns.forEach((col) => {
                sortOrder[col.sortKey] = 'desc';
            });

            return {
                pageClass: 'ks-content-nav',
                title: 'Employee Status',
                sortKey: 'id',
                sortOrder: sortOrder,
                filterStatus: '0',
                isTyping: false,
                timeOut: null,
                term: '',
                limit: 50,
                open: false,
                openstat: false,
                data: {
                    columns: columns,
                    rows: []
                },
                form: {
                    key: '',
                    name: '',
                    status: {}
                },
                modal: {
                    width: '800px',
                    height: '400px'
                },
                currentItem: {},
                applicants: [],
                include: [
                    'employeeStatuses',
                ]
            }
        },
        async created() {
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPaginationLimit(this.limit);
            await this.getStatuses({query: this.getParams()});
            await this.getEmployees({query: {take: 999999, include: 'employeeStatuses', applicants: 'all'}});
            this.applicants = this.employees;
            await this.getEmployees({query: _.merge(this.getParams(), { include: this.include.join(',') })});
            this.setPagination(this.meta.pagination);
        },
        computed: {
            ...mapGetters({
                statuses: 'statuses/data',
                statusOptions: 'statuses/formatted',
                meta: 'statuses/meta',
                loggedInUser: 'users/data',
                employees: 'employees/data',
            })
        },
        methods: {
            ...mapActions({
                getStatuses: 'statuses/getStatuses',
                deleteStatus: 'statuses/deleteStatus',
                getEmployees: 'employees/getEmployees',
            }),
            openStatusModal(formOptions) {
                this.currentItem = formOptions.data;
                this.form.key = formOptions.key;
                this.form.name = formOptions.name;
                this.open = true;
            },
            async reload() {
                await this.getStatuses({query: this.getParams()});
                this.setPagination(this.meta.pagination);
                this.open = false;
            },
            showEditDialogoue(options) {
                this.openStatusModal(options);
            },
            showDeleteConfirmation(empStatusID, empStatusName) {
                let affected_employees = [],
                    affected_applicants = [];

                this.employees.filter(obj => obj.employeeStatuses.data.length > 0).forEach((res) => {
                    let count = res.employeeStatuses.data.length; //gets only the latest status of an employee

                    if(res.employeeStatuses.data[count - 1].status.id === parseInt(empStatusID)){
                        affected_employees.push(res);
                    }

                });
                this.applicants.filter(obj => obj.employeeStatuses.data.length > 0).forEach((res) => {
                    let count = res.employeeStatuses.data.length;

                    if(res.employeeStatuses.data[count - 1].status.id === parseInt(empStatusID)) {
                        affected_applicants.push(res);
                    }

                });

                if (affected_employees.length || affected_applicants.length) {
                    let flags = [];
                    if (affected_employees.length > 0) {
                        flags.push(affected_employees.length > 1 ? affected_employees.length+1 + ' employees' : 'an employee');
                    }
                    if (affected_applicants.length > 0) {
                        flags.push(affected_applicants.length > 1 ? affected_applicants.length+1 + ' applicants' : 'an applicant');
                    }
                    const title = 'The status cannot be removed while it is being associated with ' + flags.join(' and ') + '.';
                    const msg = `${empStatusID} ${empStatusName}`;
                    this.confirmDialog(title, msg, 'Close', '', 'sm');

                } else {
                    const title = 'Are you sure you want to delete this record?';
                    const msg = `${empStatusID} ${empStatusName}`;
                    this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                        .then(({ok}) => {
                            if (ok) {
                                this.deleteStatus(empStatusID).then(() => this.reload());
						        this.notifyDialog('error', 'Successfully deleted!');
                            }
                        });
                }
            },
            async paginate(page) {
                this.gotoPage(page);
                await this.getStatuses({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async updateList(limit) {
                this.setPaginationLimit(limit);
               await this.getStatuses({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },

            async search(term) {
                this.gotoPage();
                this.term = term;

                if (this.timeOut != null) {
                    this.isTyping = false;
                    clearTimeout(this.timeOut);
                    this.timeOut = null;
                }
                if (!this.isTyping) this.timeOut = setTimeout(this.doSearch, 300);
            },
            async doSearch() {
                this.setSearch(this.term);
                await this.getStatuses({query:this.getParams()});
            },

            async sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
                this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                await this.getStatuses({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            openModals() {
                this.open = true;
            },
            closeModal() {
                this.open=false;
            },
        },
        components: {
            PageHeader,
            PageContent,
            DataTable,
            ModalDialog,
            CreateEmployeeStatusModal,
            Select2,
            ShowStatusList
        },
        mixins: [
            DataTableMixin,
            EmployeeMixin,
            ModalDialogMixin,
            AlertMixin
        ]
    }
</script>
