<template>
    <div>
        <page-header :title="title"></page-header>
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTable_buttons">
                                    <Can I="add" a="leave_approvers">
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            tag="button"
                                            @click="openModals({key: 'create-update-approver', name: 'Create Approver'})">
                                            Create New Approver
                                        </button>
                                    </Can>
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
                                    style="cursor: pointer"
                                    v-for="(approver, index) in approvers"
                                    :key="approver.id">
                                    <td>
                                        {{ approver.approver.data.last_name }}, {{ approver.approver.data.first_name }}
                                    </td>
                                    <td>
                                        {{ approver.officerInCharge.data.last_name }}, {{ approver.officerInCharge.data.first_name }}
                                    </td>
                                    <td align="center">
                                        <router-link :to="{name: 'leave-approvers-individual', params: {id: approver.id}}" class="user-profile action-button" title="Add Employees" >
                                            <i class="la la-users"></i>
                                        </router-link>
                                        <Can I="add" a="leave_approvers">
                                            <a href="javascript:;" class="action-button" title="Edit Approver" @click="showEditDialogoue({key: 'create-update-approver', name: 'Update Approver', approver:approver.id, approverDetail:approver})">
                                                <i class="la la-pencil"></i>
                                            </a>
                                            <a href="javascript:;" class="action-button" title="Remove Approver" @click="showDeleteConfirmation(approver.id, approver.approver.data.last_name + ', ' + approver.approver.data.first_name)">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </Can>
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        <!-- END SKILLS DATA -->
                    </div>
                </div>
            </div>
            <!-- BEGIN WORK DETAIL DIALOG -->
            <create-approver-modal v-if="form.key == 'create-update-approver' && open" :openModal="open" @success="reload" @close="open = false" :info="form"></create-approver-modal>
            <!-- END WORK DETAIL DIALOG -->
        </page-content>
    </div>
</template>

<style lang="scss" scoped>
    .action-button {
        font-size: 20px;
    }
    table.dataTable tbody tr {
        cursor: auto!important;
        td {
            vertical-align: middle!important;
        }
    }
    .ks-nav-body {
        width: 100%!important;
    }
</style>

<script>
    // components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    
    import ModalDialog from '@components/modal-dialog.vue';
    import CreateApproverModal from '@views/pages/leave/_modals/create-approver.vue';
    // mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import { mapActions, mapGetters } from 'vuex';
    export default {
        components: {
            DataTable,
            PageHeader,
            PageContent,
            ModalDialog,
            CreateApproverModal
        },
        mixins: [
            ModalDialogMixin,
            DataTableMixin,
            AlertMixin
        ],
        data() {
            let sortOrder = {};
            let sortKey = 'approvers.last_name';
            let columns = [
                { 
                    label: 'Approver', 
                    key: 'approvers.last_name', 
                    sortKey: 'approvers.last_name', 
                    width: '43%', 
                    sortable: true 
                },
                { 
                    label: 'OIC', 
                    key: 'oic', 
                    sortKey: 'oic.last_name', 
                    width: '43%', 
                    sortable: true 
                },
                { 
                    label: 'Action', 
                    key: 'action', 
                    width: '14%', 
                    sortable: false 
                },
            ];
            columns.forEach(function(col) {
                sortOrder[col.sortKey] = 'asc'
            });
            return {
                title: 'Leave Approver Management',
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
                    approver:{}
                },
                employeeNames: {},
                include: ['approver', 'officerInCharge']
            };
        },
        async created() {
            await this.getData();
            await this.getEmployees({query: {orderBy: 'last_name|asc', take:10000}});
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPaginationLimit(this.limit);
            await this.employees.forEach((obj) => {
                this.employeeNames[obj.id] = (obj.first_name + ' ' + obj.middle_name + ' ' + obj.last_name);
            });
            this.setSearchBy(this.searchSpecific);
            this.getApproversAll({
                query: {take: 10000, include: this.include.join(',') }
            });
        },
        computed: {
            ...mapGetters({
                approvers: 'leaveApprovers/data',
                approversAll: 'leaveApprovers/approversAll',
                meta: 'leaveApprovers/meta',
                employees: 'employees/data'
            })
        },
        methods : {
            ...mapActions({
                getApprovers: 'leaveApprovers/getApprovers',
                deleteApprover: 'leaveApprovers/deleteApprover',
                getApproversAll: 'leaveApprovers/getApproversAll',
                getEmployees: 'employees/getEmployeeNames'
            }),
            showDeleteConfirmation(approverId, approverName) {
                const title = 'Are you sure you want to delete this record?';
                const msg = `${approverName}`;
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                    .then(({ok}) => {
                        if (ok) this.delete(approverId).then(() => {
                            this.reload();
                            this.notifyDialog('error', 'Successfully deleted!');
                        });
                    });
            },
            async getData() {
                await this.getApprovers({
                    query: _.merge(this.getParams(), { include: this.include.join(',') })
                });
                //set pagination
                this.setPagination(this.meta.pagination);
            },
            paginate(page) {
                this.gotoPage(page);
                this.getData();
            },
            updateList(limit) {
                this.setPaginationLimit(limit);
                this.getData();
            },
            searchBy(searchBy) {
                this.searchSpecific = searchBy;
                if (this.term !== '') {
                    $('#search-field').val('').focus();
                    this.search('');
                }
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
            openModals(formOptions) {
                this.form = formOptions;
                this.open = true;
            },
            async reload() {
                await this.getData();
                this.setPagination(this.meta.pagination);
                this.open = false;
            },
            delete(approverId) {
                return this.deleteApprover(approverId);
            },
            showEditDialogoue(options) {
                this.openModals(options);
            }
        }        
    }
</script>