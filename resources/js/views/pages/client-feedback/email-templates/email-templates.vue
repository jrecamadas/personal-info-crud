<template>
    <div>
        <page-header v-bind:title="title"></page-header>
        <page-content>
            <div class="ks-nav-body">
                <loader v-show="isProcessing" />
                <div class="ks nav body wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-md-7 mb-2">
                                <Can I="add" a="email_templates">
                                    <div class="dataTable_buttons">
                                        <br>
                                        <router-link
                                                to="/feedback/add-email-template"
                                                class="btn btn-primary"
                                        >Add Templates</router-link>
                                    </div>
                                </Can>
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
                            @page="paginate($event)"
                        >
                            <tbody v-if="!creating">
                                <tr
                                    :class="index % 2 == 0 ? 'odd' : 'even'"
                                    style="cursor: pointer"
                                    v-for="(email, index) in emails"
                                    :key="email.id"
                                >
                                    <td>
                                        <span v-if="email.templateName">{{ email.templateName }}</span>
                                    </td>
                                    <td>
                                        <span v-if="!creating">{{ email.createdAt.date | formatDate }}</span>
                                    </td>
                                    <td @click="updateStatus({id: email.id, index: index})">
                                        <span
                                            class="badge ks-circle badge-success no_selection"
                                            :title="status_instruction"
                                            v-if="email.isActive"
                                        >Active</span>
                                        <span
                                            class="badge ks-circle badge-danger no_selection"
                                            :title="status_instruction"
                                            v-else
                                        >Inactive</span>
                                    </td>
                                    <td class="action-buttons">
                                        <Can I="update" a="email_templates">
                                            <router-link :to="{ name: 'update-email-template', params: { id: email.id } }"><i class="la la-pencil"></i></router-link>
                                        </Can>
                                        <Can I="delete" a="email_templates">
                                            <a
                                                href="#"
                                                title="Delete"
                                                @click="showConfirm(email.id, email.templateName)"
                                            >
                                                <i class="la la-trash"></i>
                                            </a>
                                        </Can>
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                    </div>
                </div>
            </div>
        </page-content>
    </div>
</template>

<style scoped>

.action-buttons {
    font-size: 20px;
    text-align: center;
}

</style>

<script>

import PageHeader from "@components/page-header.vue";
import PageContent from "@components/page-content.vue";
import DataTable from "@components/datatable.vue";
import Loader from "@components/loader.vue";

import DataTableMixin from "@common/mixin/DataTableMixin";
import AlertMixin from '@common/mixin/AlertMixin';
import DateMixin from '@common/mixin/DateMixin';

import { EmailTemplate } from '@common/model/client-feedback/EmailTemplate'

import { mapActions, mapGetters } from "vuex";

export default {
    data() {
        let sortKey = "template_name";
        let columns = [
            {
                label: "Template Name",
                key: "template_name",
                sortKey: "template_name",
                width: "60%",
                sortable: true
            },
            {
                label: "Date Created",
                key: "date_created",
                sortKey: "created_at",
                width: "20%",
                sortable: true
            },
            {
                label: "Status",
                key: "status",
                sortKey: "",
                width: "10%",
                sortable: false
            },
            {
                label: "Action",
                key: "action",
                sortKey: "",
                width: "10%",
                sortable: false
            }
        ];

        let sortOrder = {};

        columns.forEach(col => {
            sortOrder[col.sortKey] = "desc";
        });

        return {
            title: "Email Templates",
            pageClass: "ks-content-nav",
            sortKey: "template_name",
            sortOrder: sortOrder,
            searchPlaceholder: "Search Template",
            data: {
                columns: columns,
                rows: []
            },
            limit: 50,
            creating: false,
            filterPosition: "0",
            status_instruction: "Click to change status",
            isProcessing: false
        };
    },
    async created() {
        this.creating = true;
        this.setPaginationLimit(this.limit)
        await this.getEmailTemplates({query: this.getParams()});
        this.setPagination(this.meta.pagination);
        this.creating = false;
    },
    components: {
        PageHeader,
        PageContent,
        DataTable,
        Loader
    },
    computed: {
        ...mapGetters({
            emails: "emailTemplates/data",
            meta: "emailTemplates/meta"
        })
    },
    methods: {
        ...mapActions({
            getEmailTemplates: "emailTemplates/getEmailTemplates",
            saveEmailTemplate: "emailTemplates/saveEmailTemplate",
            updateTemplateStatus: "emailTemplates/updateTemplateStatus",
            editEmailTemplate: "emailTemplates/editEmailTemplate",
            deleteEmailTemplate: "emailTemplates/deleteEmailTemplate"
        }),
        async sortList(key) {
            this.sortKey = key;
            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
            await this.getEmailTemplates({query: this.getParams()})
            this.setPagination(this.meta.pagination)
        },
        async search(term) {
            this.gotoPage();
            this.setSearch(term);
            await this.getEmailTemplates({query: this.getParams()})
            this.setPagination(this.meta.pagination)
        },
        async updateList(limit) {
            this.setPaginationLimit(limit);
            await this.getEmailTemplates({query: this.getParams()})
            this.setPagination(this.meta.pagination)
        },
        async paginate(page) {
            this.gotoPage(page);
            await this.getEmailTemplates({ query: this.getParams() });
            this.setPagination(this.meta.pagination);
        },
        async reload() {
            await this.getEmailTemplates({ query: this.getParams() });
            this.setPagination(this.meta.pagination);
        },
        async updateStatus(data) {
            this.isProcessing = true;
            data.isActive = !(this.emails[data.index].isActive);
            let thisEmailTemplate = new EmailTemplate({id: data.id});
            thisEmailTemplate.save(data).then((res) => {
                this.getEmailTemplates({query: this.getParams()})
                this.isProcessing = false;
            })
        },
        showConfirm(id, name) {
            const title = 'Are you sure you want to delete this email template?'
            const msg = `${name}`

            this.confirmDialog(title, msg, 'Yes', 'No', 'sm').then(({ok}) => {
                if (ok) {
                    this.deleteEmailTemplate(id).then((res) => {
                        if(res == 0){
                            this.alertDialog('Email Template cannot be deleted', msg + ' was already in use.', 'Ok', 'sm');
                        }
                        this.reload();
                    });
                }
            });
        },
        showPreview(data) {
            let routeData = this.$router.resolve({query: {data: data}});
            window.open(routeData.href, '_blank')
        },
        showEdit(data) {
            this.editEmailTemplate(data)
            this.$router.push({name: 'add_email_template'})
        }
    },
    filters: {
        formatDate(date) {
            return moment(date).format('LLL')
        }
    },
    mixins: [DataTableMixin, AlertMixin, DateMixin]
};
</script>
