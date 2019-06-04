<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title">
        </page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="dataTable_buttons">
                                    <Can I="add" a="clients">
                                        <button type="button" @click="openModals({ key: 'create-client', name: 'Add New Client' })" tag="button" class="btn btn-primary">Add New Client</button>
                                    </Can>
                                    <Can I="view" a="clients">
                                        <button type="button" @click="accessForm" tag="button" class="btn btn-primary btn-onboarding-form">Client Onboarding Form</button>
                                    </Can>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
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
                                        <template  v-for="client in clients">
                                            <tr :class="{ 'fs-updating-hightlight': editIndex == client.id, trClassIsEven }" :key="client.id">
                                                <td>
                                                    <router-link :to="{ name: 'client', params: { id: client.id.toString() }}" class="client-profile">{{ client.company }}</router-link>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge ks-circle no_selection fs-clickable"
                                                        title="Edit Status"
                                                        @click="clickEditableClient(client)"
                                                        :class="setClientStatus(client.status).badge">
                                                            {{ setClientStatus(client.status).status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fs-clickable" title="Edit Start Date" @click="clickEditableClient(client)">
                                                        {{ (client.start_date) ? formatDate(client.start_date, 'MM-DD-YYYY') : "TBD" }}
                                                    </span>
                                                </td>
                                                <td class="client-description">
                                                    <span class="fs-clickable" title="Edit Description" @click="clickEditableClient(client)">{{ client.description }}</span>
                                                </td>
                                                <td class="text-center">{{ client.projects_count }}</td>
                                                <td class="text-center">{{ client.resources_count }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge ks-circle badge-success no_selection fs-clickable"
                                                        title="Edit High Growth Client"
                                                        @click="clickEditableClient(client)"
                                                        :class="{ 'badge-success': client.is_high_growth_client, 'badge-danger': !client.is_high_growth_client }">
                                                            {{ setHighGrowthClient(client.is_high_growth_client) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr v-if="editIndex == client.id" :key="client.id + '-update-fields'" class="fs-update-fields">
                                                <td colspan="7">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Company Name:</label>
                                                                        <input
                                                                            type="text"
                                                                            ref="company"
                                                                            name="company"
                                                                            class="form-control"
                                                                            v-model="formEdit.company"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Is High Growth Client?</label>
                                                                        <div>
                                                                            <toggle-checkbox
                                                                                :class="'short-toggle'"
                                                                                :status="highGrowth.options"
                                                                                :byDefault="highGrowth.default"
                                                                                @change="formEdit.is_high_growth_client = $event">
                                                                            </toggle-checkbox>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Company Status:</label>
                                                                        <select2
                                                                            name="status"
                                                                            :options="status.options"
                                                                            :value="client.status"
                                                                            @select="formEdit.status = $event">
                                                                        </select2>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Start Date:</label>
                                                                        <flat-pickr
                                                                            :config="getConfig(true, false, { minDate: 'today', allowInput: false })"
                                                                            placeholder="Select start date"
                                                                            name="start_date"
                                                                            v-model="formEdit.start_date"
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label>Description:</label>
                                                                <div>
                                                                    <textarea v-model="formEdit.description" rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 text-center">
                                                            <button class="btn btn-danger" title="Cancel" @click="cancelForm">Cancel</button>
                                                            <button class="btn btn-success" title="Update" @click="updateClient" :disabled="loading">Update</button>
                                                            <span v-show="loading">
                                                                <i class="fa fa-spinner fa-spin"></i>
                                                                Updating...
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                    <!-- END EMPLOYEES DATA -->
                                </data-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="copy-to-clipboard">{{ getOnboardingLink() }}</span>
        </page-content>
        <!-- END PAGE CONTENT -->

        <!-- BEGIN WORK DETAIL DIALOG -->
        <create-client-modal v-if="open" :openModal="open" @success="closeModal" @close="open = false" :info="form"></create-client-modal>
        <copy-to-clipboard v-if="cofOpen" :openModal="cofOpen" @success="closeModal" @close="cofOpen = false" :url="getOnboardingLink()"></copy-to-clipboard>
        <!-- END WORK DETAIL DIALOG -->
    </div>
</template>

<style lang="scss" scoped>
    .copy-to-clipboard{
        position: absolute;
        top: -9999px;
    }
    .btn-onboarding-form{
        position: absolute;
        margin-left: auto;
        left: auto;
        right: 15px!important;
    }
    .show-tooltip{
        font-size: 13px;
        position: relative;
        top: -3px!important;
        padding-left: 10px!important;
    }
    .tooltip-indicator{
        position: absolute;
        left: 100px;
        font-size: 23px!important;
        cursor: pointer;
    }
    .client-profile {
        color: #333;
        &:hover {
            text-decoration: underline;
        }
    }
    .action-button {
        font-size: 20px;
    }
    .badge.ks-circle.badge-end:before {
        border-color: #827e7e;
    }
    .client-description {
    //   white-space: nowrap;
        width: 50px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fs-clickable {
        cursor: pointer;
    }
    tr.fs-updating-hightlight {
        background: #fff;
        td {
            border-top: solid 2px #6c757d7a!important;
            &:first-child {
                border-left: solid 2px #6c757d7a!important;
            }
            &:last-child {
                border-right: solid 2px #6c757d7a!important;
            }
        }
    }
    tr.fs-update-fields {
        background: #fff!important;
        td {
            border-bottom: solid 2px #6c757d7a!important;
            &:first-child {
                border-left: solid 2px #6c757d7a!important;
            }
            &:last-child {
                border-right: solid 2px #6c757d7a!important;
            }
        }
    }
</style>
<style type="text/css">
    textarea {
        resize: none;
        height: 100%;
        width: 100%;
    }
    /*.td-align{
        text-align: center;
    }
    !*This forces the element holding text to not be selectable when being double clicked*!
    span.no_selection {
        -webkit-user-select: none; !* webkit (safari, chrome) browsers *!
        -moz-user-select: none; !* mozilla browsers *!
        -khtml-user-select: none; !* webkit (konqueror) browsers *!
        -ms-user-select: none; !* IE10+ *!
    }
    table td{
        cursor: auto;
    }*/
</style>

<script>
import { mapActions, mapGetters } from 'vuex';
import $ from 'jquery';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

// components
import PageHeader from '@components/page-header.vue';
import PageContent from '@components/page-content.vue';
import DataTable from '@components/datatable.vue';
import CopyToClipboard from '@components/copy-to-clipboard.vue';
import ModalDialog from '@components/modal-dialog.vue';
import Select2 from '@components/select2.vue';
import ToggleCheckbox from '@components/toggle-checkbox.vue';

// modals
import CreateClientModal from '@views/pages/client/_modals/create-client.vue';

// mixins
import DataTableMixin from '@common/mixin/DataTableMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DateMixin from '@common/mixin/DateMixin';
import EDBMixin from '@common/mixin/EDBMixin';
import DatePickerMixin from '@common/mixin/DatePicker';

export default {
    components: {
        PageHeader,
        PageContent,
        DataTable,
        ModalDialog,
        CreateClientModal,
        CopyToClipboard,
        Select2,
        FlatPickr,
        ToggleCheckbox,
    },
    mixins: [
        DataTableMixin,
        ModalDialogMixin,
        AlertMixin,
        DateMixin,
        EDBMixin,
        DatePickerMixin,
    ],
    data() {
        let sortKey = 'company';
        let columns = [
            { label: 'Client Name', key: 'company', sortKey: 'company', width: '18%', sortable: true },
            { label: 'Status', key: 'status', sortKey: 'status', width: '6%', sortable: true },
            { label: 'Start Date', key: 'start_date', sortKey: 'start_date', width: '9%', sortable: true },
            { label: 'Description', key: 'description', sortKey: 'description', width: '30%', sortable: false },
            { label: 'No. of Projects', key: 'projects_count', sortKey: 'projects_count', width: '11%', sortable: true },
            { label: 'No. of Resources', key: 'resources_count', sortKey: 'resources_count', width: '12%', sortable: true },
            { label: 'High Growth Client', key: 'is_high_growth_client', sortKey: 'is_high_growth_client', width: '14%', sortable: true },
        ];

        let sortOrder = {};

        columns.forEach((col) => {
            sortOrder[col.sortKey] = 'desc';
        });

        return {
            pageClass: 'ks-content-nav',
            title: 'Clients',
            sortKey: 'company',
            sortOrder: sortOrder,
            searchPlaceholder: 'Enter Company Name',
            filterPosition: '0',
            limit: 50,
            open: false,
            data: {
                columns: columns,
                rows: []
            },
            form: {
                key: '',
                name: '',
                client_id: '',
                contact_id: ''
            },
            modal: {
                width: '800px',
                height: '400px'
            },
            status_instruction: 'Click to change status',
            cofOpen: false,
            loading: false,
            editIndex: -1,
            status: {
                options: [
                    {id: '0', text: "Active"},
                    {id: '1', text: "End of Contract"},
                    {id: '2', text: "Prospect"},
                ]
            },
            highGrowth: {
                options: [
                    { label: "Yes", value: 1, isOn: true },
                    { label: "No", value: 0, isOn: false }
                ],
                default: { label: "Yes", value: 1, isOn: true },
            },
            formEdit: {
                id: '',
                company: '',
                start_date: '',
                description: '',
                is_high_growth_client: 0,
            }
        }
    },
    async created() {
        $(document).ready(function(){
            $("div.dataTables_filter div.flex-row label input#search-field").css({
                'width': "100%",
                'left': "auto"
            });
            $("div.dataTables_filter div.flex-row label i.search-icon").css({
                'right': '30px'
            });
        });

        this.edbFadeElement("span.show-tooltip",15000, 2000);
        await this.getClients({query:this.getParams()});
        this.setPagination(this.meta.pagination);
    },
    computed: {
		...mapGetters({
			clients:'clients/data',
            editclient:'clients/client',
			meta:'clients/meta'
		}),
        contactId() {
            return (client) => client.contacts.data.length ? client.contacts.data[0].id : null;
        }
	},
    methods: {
        ...mapActions({
            getClientContact: 'clientContacts/getClientContact',
			getClients: 'clients/getClients',
            deleteClient: 'clients/deleteClient',
            deleteClientContact: 'clientContacts/deleteContact',
            pullClient: 'clients/getClient',
            saveClient: 'clients/saveClient',
        }),
        clickEditableClient(client) {
            this.highGrowth.default = {
                label:  client.is_high_growth_client ? "Yes" : "No",
                value:  client.is_high_growth_client,
                isOn:   true,
            };
            this.formEdit = {
                id: client.id,
                company: client.company,
                start_date: client.start_date,
                description: client.description,
                is_high_growth_client: client.is_high_growth_client,
            };

            this.editIndex = client.id;
        },
        cancelForm() {
            this.loading = false;
            this.editIndex = -1;
        },
        async updateClient() {
            let data = this.formEdit;

            this.loading = true;
            await this.saveClient(data).then((res) => {
                this.editIndex = -1;
                this.reload();
                this.notifyDialog('success', 'Successfully saved!');
            }).catch((e) => {
                console.log(e);
            });
            this.loading = false;
        },
        accessForm() {
            this.edbCopyToClipboard('span.copy-to-clipboard');
            this.cofOpen = true;
            //top.window.open('/client', '_self');
        },
        getOnboardingLink() {
            return top.window.location.protocol + '//' + top.window.location.hostname + '/client-onboarding';
        },
        async paginate(page) {
            this.gotoPage(page);
            await this.getClients({query:this.getParams()});
            this.setPagination(this.meta.pagination);
        },
        async updateList(limit) {
            this.setPaginationLimit(limit);
            await this.getClients({query:this.getParams()});
            this.setPagination(this.meta.pagination);
        },
        async search(term) {
            this.setSearch(term);
            await this.getClients({query:this.getParams()});
            this.setPagination(this.meta.pagination);
        },
        async reload() {
		    await this.getClients({query:this.getParams()});
		    this.setPagination(this.meta.pagination);
		    this.open = false;
		},
        async sortList(key) {
            this.sortKey = key;
            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';

            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);

            await this.getClients({query:this.getParams()});
            this.setPagination(this.meta.pagination);
        },
        openModals(form){
            this.form = form;
            this.open = true;
        },
        async closeModal(){
            this.open = false;
            this.cofOpen = false;
            await this.getClients({query:this.getParams()});
            this.setPagination(this.meta.pagination);
        },
        // showEditDialogue(options) {
        //     this.$set(options,'key','create-client');
        //     this.$set(options,'name','Update Client');
		//     this.openModals(options);
		// },
        showConfirm(client) {
            //id, contact_id, company
            //client.id, client.contacts.data[0].id, client.company
            const title = 'Are you sure you want to delete this client?';
            const msg = `${client.company} `;

            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                .then(({ok}) => {
                    if(ok){

                        this.deleteClient(client.id).then(() => {
                            client.contacts.data.forEach((contact) => {
                                this.deleteClientContact(contact.id);
                            });
                            this.reload();
                        });
                    }
                });
        },
        // async updateStatus(data){
        //     let thisClient = new Client({id: data.id});
        //     thisClient.save(data).then((res) => {
        //         this.getClients({query:this.getParams()});
        //     });
        // },
        setClientStatus(statusID) {
            let status = '';
            let badgeClass = '';
            switch(statusID) {
                case 0:
                    status = 'Active';
                    badgeClass = 'badge-success';
                    break;
                case 1:
                    status = 'End Contract';
                    badgeClass = 'badge-end';
                    break;
                default:
                    status = 'Prospect';
                    badgeClass = 'badge-danger';
                    break;
            }

            return { status: status, badge: badgeClass };
        },
        setHighGrowthClient(isHighGrowth) {
            return isHighGrowth ? 'Yes' : 'No';
        },
        trClassIsEven(index) {
            return index % 2 == 0 ? 'even' : 'odd';
        }
    }
}
</script>