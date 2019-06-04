<template>
    <modal-dialog v-show="openModal" :options="option" :title="modal_title" @close="closeModal">
        <template slot="body">
            <div class="showResponseBody">
                <data-table
                    :columns="data.responseColumns"
                    :sortKey="sortKey"
                    :sortOrder="sortOrder"
                    :pagination="config.pagination"
                    :showSearch="false"
                    @sort="sortList($event)"
                    @select="updateList($event)"
                    @search="search($event)"
                    @prev="paginate('prev')"
                    @next="paginate('next')"
                    @page="paginate($event)"
                >
                <div class="flex-row filter-position" slot="filter"><i v-show="loadingSentData" class="fa fa-spinner fa-spin"></i></div>
                <tbody v-if="surveySentData.length">
                    <tr
                        :class="index % 2 == 0 ? 'even' : 'odd'"
                        style="cursor: pointer;"
                        v-for="(sent, index) in surveySentData"
                        :key="sent.id">
                        <td>
                            <span v-if="sent.dateSent != null">
                                <date-display :value="sent.dateSent.date" displayType="datetime" />
                            </span>
                            <span v-else> - </span>
                        </td>
                        <td>
                            <span>{{sent.surveyStatus}}</span>
                        </td>
                        <td>
                            <span v-if="sent.dateReplied != null">
                                <span v-if="sent.surveyStatus != 'Responded'"> - </span>
                                <span v-else><date-display :value="sent.dateReplied.date" displayType="datetime" /></span>
                            </span>
                            <span v-else> - </span>
                        </td>
                        <td>
                            <span>{{ sent.contactName }}</span>
                        </td>
                        <td align="center">
                            <span v-if="sent.surveyStatus != 'Responded'"> - </span>
                            <span v-else>
                                <router-link
                                    :to="{name: 'view-responses', params: {id: sent.id, link: sent.surveyLink }}"
                                    class="action-button la la-file-text disabled: true"
                                    target="_blank">
                                </router-link>
                            </span>

                        </td>
                    </tr>
                    </tbody>
                </data-table>
            </div>
        </template>
    </modal-dialog>
</template>

<style type="text/css">
    .showResponseBody{
        overflow-y: scroll;
        overflow-x: hidden!important;
        height:300px!important;
    }
    .showResponseBody#modalDescription div.row.show-response-list{
        left: 0px!important;
        margin-left: 0%!important;
        padding-left: 25px!important;
    }
    .modal-body > .showResponseBody > .row{
        margin-left: 0px!important;
    }
    .action-button {
        font-size: 20px;
    }
</style>

<script>
//Components
import ModalDialog from '@components/modal-dialog.vue';
import DateDisplay from "@components/date-display.vue";
import DataTable from '@components/datatable.vue';

//Mixins
import DataTableMixin from '@common/mixin/DataTableMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DateMixin from '@common/mixin/DateMixin';

//Models
import { mapGetters, mapActions } from 'vuex';
import jQuery from 'jquery'

export default {
    props: {
        survey: {
            type: Object,
            required: false
        }
    },
    data() {
        let responseColumns = [
                { label: 'Date Sent',      key: 'dateSent',      sortKey: 'dateSent',       width: '27%', sortable: false },
                { label: 'Status',         key: 'status',        sortKey: 'status',         width: '15%', sortable: false },
                { label: 'Date Responded', key: 'dateResponded', sortKey: 'dateResponded',  width: '27%', sortable: false },
                { label: 'Responder',      key: 'responder',     sortKey: 'responder',      width: '25%', sortable: false },
                { label: 'Action',        key: '',              sortKey: '',               width: '5%', sortable: false }
        ]

        let sortKey = '';
        let sortOrder = {};

        responseColumns.forEach((col) => {
            sortOrder[col.sortKey] = 'asc';
        });

        return {
            sortKey: 'date_sent',
            sortOrder: sortOrder,
            searchPlaceholder: 'Enter Responder Name',
            option: {
                height: 'auto',
                width: '800px',
                bottom: 'auto'
            },
            data: {
                responseColumns: responseColumns,
            },
            modal_title: 'View Responses for ' + this.survey.projectSurveyName,
            loadingSentData: false,
            open: false,
            surveySentData: []
        }
    },
    computed: {
        ...mapGetters({
            surveySent: 'surveySent/data',
            meta: 'surveySent/meta'
        }),
    },
    async created (){
        // Overrides button text and color in the modal
        let $ = jQuery;
        $(document).ready(function(){
            $("header.modal-header > span > button.btn").text("Close");
            $("header.modal-header > span > button.btn").attr('class','btn btn-danger');
        });

        // Load specific survey
        await this.getData();
    },
    methods: {
        ...mapActions({
            getSurveySent: 'surveySent/getSurveySent',
        }),
        closeDialog(){
            this.loading = false;
            this.openViewResponse = false;
            this.$emit("success");
        },
        async paginate(page){
            this.gotoPage(page);
            this.getData();
        },
        async updateList(limit) {
            this.setPaginationLimit(limit);
            this.getData();
        },
        async search(term) {
            this.setSearch(term);
            this.getData();
        },
        async sortList(key) {
            this.sortKey = key;
            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';

            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);

            this.setPagination(this.meta.pagination);
        },
        async getData(){
            this.surveySentData = [];
            this.loadingSentData = true;
            await this.getSurveySent({
                query: _.merge(
                    this.getParams(),
                    {
                        projectSurveyId: this.survey.projectSurveyId,
                        viewOrderByDateReplied: true
                    }
                )
            }).then(() => {
                this.loadingSentData = false;
                this.surveySentData = this.surveySent;

            });
            this.setPagination(this.meta.pagination);
        },

        viewResponseBySurveySentId(surveySentId, surveyLink) {
            window.open('/survey/responses/'+ surveyLink, '_blank');
        }
    },
    components: {
        ModalDialog,
        DateDisplay,
        DataTable
    },
    mixins: [
        StringHelperMixin,
        ModalDialogMixin,
        DateMixin,
        DataTableMixin
    ]
}
</script>
