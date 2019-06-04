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
                                    <Can I="add" a="leave_types">
                                        <button type="button"
                                            @click="openModalDialog({
                                                key: 'create-update-leave-type',
                                                name: 'Add New Leave Type',
                                                operation: 'Add',
                                                data: {
                                                    id: 0,
                                                    name: '',
                                                    is_enabled: 1,
                                                    leave_credit_type_id: 1
                                                },
                                            })"
                                            tag="button"
                                            class="btn btn-primary">
                                            Add New Leave Type
                                        </button>
                                    </Can>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN LEAVE CREDIT TYPES TABLE -->
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="setPaginate('prev')"
                            @next="setPaginate('next')"
                            @page="setPaginate($event)">

                            <tbody>
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(leaveType, index) in leaveTypesData"
                                    :key="leaveType.id">

                                    <td>{{ leaveType.name }}</td>
                                    <td>{{ getLeaveCreditTypeName(leaveType) }}</td>
                                     <td>{{ status[leaveType.is_enabled] }}</td>
                                    <td align="center">
                                        <Can I="update" a="leave_types">
                                            <a href="javascript:;"
                                                class="action-button"
                                                title="Update Leave Type"
                                                @click="openModalDialog({
                                                    key: 'create-update-leave-type',
                                                    name: 'Update Leave Type',
                                                    operation: 'Update',
                                                    data: {
                                                        id: leaveType.id,
                                                        name: leaveType.name,
                                                        is_enabled: leaveType.is_enabled,
                                                        leave_credit_type_id: getLeaveCreditTypeID (leaveType)
                                                    },
                                                })">
                                                <i class="la la-pencil"></i>
                                            </a>
                                        </Can>
                                        <Can I="delete" a="leave_types">
                                            <a href="javascript:;"
                                                class="action-button"
                                                title="Delete Leave Type"
                                                @click="showDeleteConfirmation(leaveType.id, leaveType.name)">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </Can>
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        <!-- END LEAVE CREDIT TYPES TABLE -->
                    </div>
                </div>
            </div>
            <!-- BEGIN ADD/UPDATE LEAVE CREDIT TYPES MODAL -->
            <create-update-leave-type-modal
                v-if="form.key == 'create-update-leave-type' && 'showModal'"
                :openModal="showModal"
                :info="form"
                @success="reloadList"
                @close="closeModalDialog"/>
            <!-- END ADD/UPDATE LEAVE CREDIT TYPES MODAL -->
        </page-content>
    </div>
</template>

<style lang="scss" scoped>
    .action-button {
        font-size: 20px;
    }
</style>

<script>

    // Components
    import PageHeader from '@components/page-header.vue'
    import PageContent from '@components/page-content.vue'
    import DataTable from '@components/datatable.vue'

    import ModalDialog from '@components/modal-dialog.vue'
    import CreateUpdateLeaveTypeModal from '@views/pages/leave/_modals/create-update-leave-type.vue'
    import Select2 from '@components/select2.vue';

    // Mixins
    import DataTableMixin from '@common/mixin/DataTableMixin'
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import AlertMixin from '@common/mixin/AlertMixin';

    // Libraries
    import { mapActions, mapGetters } from 'vuex'

    export default {
        data() {
            let sortOrder = {};
            let sortKey = 'leave_credit_type_id';
            let columns = [
                { label: 'Name', key: 'name', sortKey: 'name', width: '35%', sortable: true },
                { label: 'Leave Credit Type', key: 'leave_credit_type_id', sortKey: 'leave_credit_type_id', width: '35%', sortable: true },
                { label: 'Status', key: 'is_enabled', sortKey: 'is_enabled', width: '20%', sortable: true },
                { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
            ];

            columns.forEach(function(col) {
                sortOrder[col.sortKey] = 'asc'
            });

            return {
                title:'Leave Types',
                pageClass: 'ks-content-nav',
                sortKey:sortKey,
                sortOrder:sortOrder,
                pageLimit: 10,
                showModal: false,
                data: {
                    columns:columns,
                    rows: []
                },
                form: {
                    key: '',
                    name: '',
                    operation: '',
                    data:{}
                },
                statusInstructionText: 'Click to change status',
            }
        },
        async created() {
            //Get Leave Types and Pagination Metadata
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            await this.getLeaveTypes({query:this.getParams()});
            this.setPagination(this.meta.pagination);
            //Get Employee Leave Requests
            await this.getLeaveRequestList({});
        },
        computed: {
            ...mapGetters({
                leaveTypesData:'leaveTypes/data',
                status:'leaveTypes/status',
                meta:'leaveTypes/meta',
                leaveRequestsData:'leaveRequests/list',
            }),
        },
        methods: {
            ...mapActions({
                getLeaveTypes: 'leaveTypes/getLeaveTypes',
                saveLeaveType: 'leaveTypes/saveLeaveType',
                deleteLeaveType: 'leaveTypes/deleteLeaveType',
                getLeaveRequestList: 'leaveRequests/getLeaveRequestList',
            }),
            async setPaginate(page) {
                this.gotoPage(page);
                await this.getLeaveTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async search(term) {
                this.gotoPage();
                this.setSearch(term);
                await this.getLeaveTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
                this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                await this.getLeaveTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async updateList(pageLimit) {
                this.setPaginationLimit(pageLimit);
                await this.getLeaveTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async reloadList() {
                await this.getLeaveTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
                this.closeModalDialog();
            },
            //Check Leave Credit Type name if NULL
            getLeaveCreditTypeName (leaveType) {
                return (leaveType.leave_credit_type != null) ? leaveType.leave_credit_type.name : "----";
            },
            getLeaveCreditTypeID (leaveType) {
                return (leaveType.leave_credit_type != null) ? leaveType.leave_credit_type.id : 1;
            },
            //Toggle Status
            setStatus(updatedData, status) {
                this.saveLeaveType(updatedData).then(() => this.reloadList());
            },
            //Check if Leave Type is in Use
            checkIfInUse(leaveTypeID) {
                let isInUse = false;
                _.each(this.leaveRequestsData, (leaveRequest) => {
                    if (leaveRequest.leave_type_id === leaveTypeID)   {
                        isInUse = true;
                    }
                });
                return isInUse
            },
            //Show Pop-up Confirmation before Deleting
            showDeleteConfirmation(leaveTypeID, leaveTypeName) {
                let isInUse = this.checkIfInUse(leaveTypeID);
                const title = (!isInUse) ?
                    'Are you sure you want to delete this leave type?' :
                    'Cannot delete leave type.';
                const message = (!isInUse) ?
                    `${leaveTypeName}` :
                    'Leave type is in use.';
                if (!isInUse)   {
                    this.confirmDialog(title, message, 'Yes', 'No', 'sm')
                        .then(({ok}) => {
                            if (ok) {
                                this.delete(leaveTypeID).then(() => this.reloadList());
                                this.notifyDialog('error', 'Successfully deleted!');
                            }
                        }
                    );
                }
                else {
                    this.alertDialog(title, message, 'Okay', 'sm');
                }
            },
            //Delete Leave Type
            delete(leaveTypeID) {
                return this.deleteLeaveType(leaveTypeID);
            },
            //Open Modal
            openModalDialog(formOptions) {
                this.form = formOptions
                this.showModal = true
            },
            //Close Modal
            closeModalDialog() {
                this.showModal = false;
                this.form = {};
            },
        },
        components: {
            Select2,
            DataTable,
            PageHeader,
            PageContent,
            ModalDialog,
            CreateUpdateLeaveTypeModal,

        },
        mixins: [
            ModalDialogMixin,
            DataTableMixin,
            AlertMixin
        ],
    }
</script>
