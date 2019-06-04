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
                                    v-for="(workFromHomeRequest, index) in workFormHomeRequests"
                                    :key="workFromHomeRequest.id">

                                    <td>{{ workFromHomeRequest.employee_name }}</td>
                                    <td>{{ workFromHomeRequest.projects }}</td>
                                    <td>{{ workFromHomeRequest.positions }}</td>
                                    <td>{{ [workFromHomeRequest.start_date, "YYYY-MM-DD"] | moment("MMM D, YYYY") }}</td>
                                    <td>{{ [workFromHomeRequest.end_date, "YYYY-MM-DD"] | moment("MMM D, YYYY") }}</td>
                                    <td>{{ workFromHomeRequest.reason }}</td>
                                </tr>
                            </tbody>
                        </data-table>
                    </div>
                </div>
            </div>
        </page-content>
    </div>
</template>

<script>

    // Components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import Select2 from '@components/select2.vue';

    // Mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';

    // Libraries
    import { mapActions, mapGetters } from 'vuex';

    export default {
        data() {
            let sortKey = 'start_date';
            let sortOrder = {};
            let columns = [
                { label: 'Name', key: 'employee.name', sortKey: 'employee.name', width: '20%', sortable: false },
                { label: 'Project', key: 'projects', sortKey: 'projects', width: '15%', sortable: false },
                { label: 'Position', key: 'employee.positions.job_title', sortKey: 'employee.positions.job_title', width: '15%', sortable: false },
                { label: 'Start Date', key: 'start_date', sortKey: 'start_date', width: '10%', sortable: true },
                { label: 'End Date', key: 'end_date', sortKey: 'end_date', width: '10%', sortable: true },
                { label: 'Reason', key: 'reason', sortKey: 'reason', width: '30%', sortable: true },
            ];

            columns.forEach(function(col) {
                sortOrder[col.sortKey] = 'desc'
            });

            return {
                title: 'Work From Home Report',
                pageClass: 'ks-content-nav',
                sortKey: sortKey,
                sortOrder: sortOrder,
                pageLimit: 50,

                data: {
                    columns:columns,
                    rows: []
                },
            }
        },
        async created() {
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            await this.getWorkFromHomeRequests(this.getParams());
            this.setPagination(this.meta.pagination);
        },
        computed: {
            ...mapGetters({
                workFormHomeRequests: 'workFromHome/list',
                meta: 'workFromHome/meta',
            })
        },
        methods: {
            ...mapActions({
                getWorkFromHomeRequests: 'workFromHome/getWfhList',
            }),
            async setPaginate(page) {
                this.gotoPage(page);
                await this.getWorkFromHomeRequests(this.getParams());
                this.setPagination(this.meta.pagination);
            },
            async search(term) {
                this.gotoPage();
                this.setSearch(term);
                await this.getWorkFromHomeRequests(this.getParams());
                this.setPagination(this.meta.pagination);
            },
            async sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
                this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                await this.getWorkFromHomeRequests(this.getParams());
                this.setPagination(this.meta.pagination);
            },
            async updateList(pageLimit) {
                this.setPaginationLimit(pageLimit);
                await this.getWorkFromHomeRequests(this.getParams());
                this.setPagination(this.meta.pagination);
            },
        },
        components: {
            Select2,
            DataTable,
            PageHeader,
            PageContent,

        },
        mixins: [
            DataTableMixin,
        ],
    }
</script>
