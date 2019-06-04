<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            :showSearch="true"
                            @search="search($event)"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <!-- BEGIN USER REPORT DATA -->
                            <tbody v-if="employees.length">
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(employee, index) in employees"
                                    :key="employee.id">
                                    <td>
                                        {{ employee.employee_no }}
                                    </td>
                                    <td>
                                        {{ employee.name }}
                                    </td>
                                    <td>{{ position(employee.positions ? employee.positions.data : "") }}</td>
                                    <td>{{ employee.department && employee.department.data ? employee.department.data.name : "Unassigned" }}</td>
                                    <td>
                                        <router-link
                                        :to="{name: 'employee-daily-reports', params: {id: employee.id}}"
                                        class="user-report"
                                        >View Reports
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END USER REPORT DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
        </page-content>
    </div>
</template>
<style lang="scss" scoped>
.user-report {
  &:hover {
    text-decoration: underline;
  }
}
</style>
<script>

	// components
	import PageHeader from '@components/page-header.vue';
	import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';

    // mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import EmployeeMixin from "@common/mixin/EmployeeMixin";
    
    import { mapActions, mapGetters } from 'vuex';

    export default {
		data() {
			let sortOrder = {};
			let sortKey = 'employee_no';
	        let columns = [
                { label: 'ID', key: 'employee_no', sortKey: 'employee_no', width: '10%', sortable: true },
	            { label: 'Name', key: 'name', sortKey: 'last_name', width: '30%', sortable: true },
                { label: 'Position', key: 'position', sortKey: 'job_positions.job_title', width: '25%', sortable: true },
                { label: 'Department', key: 'departments.name', sortKey: 'departments.name', width: '20%', sortable: true },
                { label: 'Action', key: 'action', sortKey: 'action', width: '15%', sortable: false }
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'asc';
	        });
			return {
                isTyping: false,
                timeOut: null,
                term: "",
				title:'Employee Daily Report',
				pageClass: 'ks-content-nav',
            	open: false,
            	sortKey:sortKey,
            	sortOrder:sortOrder,
				data: {
					columns:columns,
					rows: []
				},
				form: {
	                key: '',
	                name: ''
                },
                include: ["positions", "department"]
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPagination(this.meta.pagination);
            this.getData();
		},
		computed: {
			...mapGetters({
                meta: "employees/meta",
                employees: "employees/data",
			})
		},
		methods : {
			...mapActions({
                getEmployees: "employees/getEmployees"
			}),
			showComposeModal(formOptions) {
				this.form = formOptions;
				this.open = true;
			},
			closeModalDialogue() {
				this.open = false;
            },
            async getData() {
                let data = [];

                await this.getEmployees({
                    query: _.merge(this.getParams(), { include: this.include.join(",") })
                });

                // set pagination
                this.setPagination(this.meta.pagination);
            },
			async paginate(page) {
	            this.gotoPage(page);
				this.getData();
	        },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
				this.getData();
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
				this.getData();
	        },
		    async reload() {
				this.getData();
		    	this.open = false;
            },
            async doSearch() {
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
            }
		},
		components: {
			DataTable,
			PageHeader,
			PageContent
		},
		mixins: [
            DataTableMixin,
            EmployeeMixin
		]
	}
</script>