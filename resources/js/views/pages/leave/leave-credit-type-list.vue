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
                                    <Can I="add" a="leave_credit_type">
                                        <button type="button"
                                            @click="openModalDialog({
                                                key: 'create-update-leave-credit-type',
                                                name: 'Add New Leave Credit Type',
                                                operation: 'Add',
                                                data: {
                                                    id: 0,
                                                    name: '',
                                                    limit: '',
                                                },
                                            })"
                                            tag="button"
                                            class="btn btn-primary">
                                            Add New Leave Credit Type
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
                                    v-for="(leaveCreditType, index) in leaveCreditTypesData"
                                    :key="leaveCreditType.id">

                                    <td>{{ leaveCreditType.name }}</td>
                                    <td>{{ leaveCreditType.limit }}</td>

                                    <td align="center">
                                        <Can  I="update" a="leave_credit_type">
                                            <a href="#"
                                                class="action-button"
                                                title="Edit Leave Credit Type"
                                                @click="openModalDialog({
                                                    key: 'create-update-leave-credit-type',
                                                    name: 'Update Leave Credit Type',
                                                    operation: 'Update',
                                                    data: {
                                                        id: leaveCreditType.id,
                                                        name: leaveCreditType.name,
                                                        limit: leaveCreditType.limit,
                                                    },
                                                })">
                                                <i class="la la-pencil"></i>
                                            </a>
                                        </Can>
                                        <Can  I="delete" a="leave_credit_type">
                                            <a href="#"
                                                class="action-button"
                                                title="Delete Leave Credit Type"
                                                @click="showDeleteConfirmation(leaveCreditType.id, leaveCreditType.name)">
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
            <create-update-leave-credit-type-modal
                v-if="form.key == 'create-update-leave-credit-type' && 'showModal'"
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
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';

    import ModalDialog from '@components/modal-dialog.vue';
    import CreateUpdateLeaveCreditTypeModal from '@views/pages/leave/_modals/create-update-leave-credit-type.vue';
    import Select2 from '@components/select2.vue';

    // Mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import AlertMixin from '@common/mixin/AlertMixin';

    // Libraries
    import { mapActions, mapGetters } from 'vuex';

    export default {
        data() {
            let sortOrder = {};
            let sortKey = 'name';
            let columns = [
                { label: 'Name', key: 'name', sortKey: 'name', width: '60%', sortable: true },
                { label: 'Default Allocation', key: 'limit', sortKey: 'limit', width: '20%', sortable: true },
                { label: 'Action', key: 'action', sortKey: '', width: '20%', sortable: false },
            ];

            columns.forEach(function(col) {
                sortOrder[col.sortKey] = 'desc'
            });

            return {
                title:'Leave Credit Types',
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
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            await this.getLeaveCreditTypes({query:this.getParams()});
            this.setPagination(this.meta.pagination);
            //Get Employee Leave Credits
            await this.getEmployeeLeaveCredits({query:{take:99999}});
            //Get Leave Types
            await this.getLeaveTypes({query:{take:99999}});
        },
        computed: {
            ...mapGetters({
                leaveCreditTypesData:'leaveCreditTypes/data',
                meta:'leaveCreditTypes/meta',
                employeeLeaveCreditsData:'employeeLeaveCredits/data',
                leaveTypesData:'leaveTypes/data',
            })
        },
        methods: {
            ...mapActions({
                getLeaveCreditTypes: 'leaveCreditTypes/getLeaveCreditTypes',
                deleteLeaveCreditType: 'leaveCreditTypes/deleteLeaveCreditType',
                getEmployeeLeaveCredits: 'employeeLeaveCredits/getEmployeeLeaveCredits',
                getLeaveTypes: 'leaveTypes/getLeaveTypes',
            }),
            async setPaginate(page) {
                this.gotoPage(page);
                await this.getLeaveCreditTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async search(term) {
                this.gotoPage();
                this.setSearch(term);
                await this.getLeaveCreditTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
                this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                await this.getLeaveCreditTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async updateList(pageLimit) {
                this.setPaginationLimit(pageLimit);
                await this.getLeaveCreditTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
            },
            async reloadList() {
                await this.getLeaveCreditTypes({query:this.getParams()});
                this.setPagination(this.meta.pagination);
                this.closeModalDialog();
            },
            //Open Modal
            openModalDialog(formOptions) {
                this.form = formOptions;
                this.showModal = true;
            },
            //Close Modal
            closeModalDialog() {
                this.showModal = false;
                this.form = {};
            },
            //Check if Leave Type is in Use
            checkIfInUse(leaveCreditTypeID) {
                let isInUse = false;
                _.each(this.employeeLeaveCreditsData, (employeeLeaveCredit) => {
                    if (employeeLeaveCredit.leave_credit_type_id === leaveCreditTypeID)   {
                        isInUse = true;
                    }
                });
                _.each(this.leaveTypesData, (leaveType) => {
                    if (leaveType.leave_credit_type_id === leaveCreditTypeID)   {
                        isInUse = true;
                    }
                });
                return isInUse
            },
            //Show Pop-up Confirmation before Deleting
            showDeleteConfirmation(leaveCreditTypeID, leaveCreditTypeName) {
                let isInUse = this.checkIfInUse(leaveCreditTypeID);
                const title = (!isInUse) ?
                    'Are you sure you want to delete this leave credit type?' :
                    'Cannot delete leave type.';
                const message = (!isInUse) ?
                    `${leaveCreditTypeName}` :
                    'Leave credit type is in use.';
                if (!isInUse)   {
                    this.confirmDialog(title, message, 'Yes', 'No', 'sm')
                        .then(({ok}) => {
                            if (ok) {
                                this.delete(leaveCreditTypeID).then(() => this.reloadList());
						        this.notifyDialog('error', 'Successfully deleted!');
                            }
                        }
                    );
                }
                else {
                    this.alertDialog(title, message, 'Okay', 'sm');
                }
            },
            //Delete Leave Credit Type
            delete(leaveCreditTypeID) {
                return this.deleteLeaveCreditType(leaveCreditTypeID);
            },
        },
        components: {
            Select2,
            DataTable,
            PageHeader,
            PageContent,
            ModalDialog,
            CreateUpdateLeaveCreditTypeModal,

        },
        mixins: [
            ModalDialogMixin,
            DataTableMixin,
            AlertMixin
        ],
    }
</script>
