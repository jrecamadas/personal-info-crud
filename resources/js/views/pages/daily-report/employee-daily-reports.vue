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
                            :showSearch="false"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
							<label slot="filter" class="filter-by">
								Filter
								<select2
								style="width:130px"
								v-if="filterByOptions.length"
								:options="filterByOptions"
								:value="filterSpecific"
								@select="doFilter($event)"
								>
								</select2>
								<select2
									v-if="filterSpecific == 'project'"
									:options="projects"
									:value="filterProject"
									:hideSearchBox="false"
									style="width: 200px;"
									@select="doFilterByProject($event)"
								></select2>
								<div class="filter-date-wrapper" v-else>
									<flat-pickr
										v-model="filterDate.start"
										:config="getConfig(true, false, startDateOptions)"
										placeholder="Select a start date"
										name="start_date"
									/>
									<flat-pickr
										v-model="filterDate.end"
										:config="getConfig(true, false, endDateOptions)"
										placeholder="Select an end date"
										name="end_date"
									/>
								</div>
							</label>
                            <!-- BEGIN USER REPORT DATA -->
                            <tbody v-if="reportData.length">
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(employeeReport, index) in reportData"
                                    :key="employeeReport.id">
                                    <td>{{ employeeReport.clientProject.project_name }}</td>
                                    <td>{{ employeeReport.subject }}</td>
                                    <td>{{ formatDate(employeeReport.report_date, 'MMM DD, YYYY') }}</td>
									<td>{{ employeeReport.sent ? "Sent" : "Pending" }} </td>
									<td><a href="#" @click="showComposeModal({key: 'view-report', name: 'View Report', id: employeeReport.id})">View</a></td>
                                </tr>
                            </tbody>
                            <!-- END USER REPORT DATA -->
                        </data-table>
                    </div>
                </div>
                <view-daily-report v-if="form.key=='view-report' && open" :openModal="open" @close="closeModalDialogue" :info="form"></view-daily-report>
            </div>
		</page-content>
    </div>
</template>
<style>
	.filter-by {
		text-align: left;
	}
	.filter-date-wrapper {
		display: inline-block;
	}
	.filter-date {
		display: inline-block;
		width: 15em;
	}
</style>
<script>

	// components
	import PageHeader from '@components/page-header.vue'
	import PageContent from '@components/page-content.vue'
	import DataTable from '@components/datatable.vue'
	import ModalDialog from '@components/modal-dialog.vue'
	import Select2 from "@components/select2.vue";
	import FlatPickr from 'vue-flatpickr-component';
	import ViewDailyReport from '@views/pages/daily-report/_modals/view-daily-report.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';
	import DateMixin from '@common/mixin/DateMixin';
	import DatePickerMixin from '@common/mixin/DatePicker';

	import { mapActions, mapGetters } from 'vuex';
	import 'flatpickr/dist/flatpickr.css';

	export default {
		data() {
			let sortOrder = {};
			let sortKey = 'report_date';
	        let columns = [
                { label: 'Project', key: 'client_projects.project_name', sortKey: 'client_projects.project_name', width: '25%', sortable: true },
	            { label: 'Subject', key: 'subject', sortKey: 'subject', width: '45%', sortable: true },
				{ label: 'Report Date', key: 'report_date', sortKey: 'report_date', width: '15%', sortable: true },
				{ label: 'Status', key: 'sent', sortKey: 'sent', width: '8%', sortable: true },
				{ label: 'Action', key: 'action', sortKey: 'action', width: '8%', sortable: false }
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'desc';
	        });
			return {
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
	                name: '',
	                report:{}
				},
				filterProject: '0',
				filterSpecific: "project",
				filterByOptions: [
					{ id: "project", text: "Project"},
					{ id: "date", text: "Date"}
				],
				filterDate: { start: '', end: '' }
				,
				startDateOptions: {
					maxDate: 'today',
					allowInput: true,
					altInputClass: 'filter-date form-control',
					onClose: (selectedDates, dateStr, instance) => {
						this.setStart(dateStr);
						this.doFilterByDate();
					}
				},
				endDateOptions: {
					maxDate: 'today',
					allowInput: true,
					altInputClass: 'filter-date form-control',
					onClose: (selectedDates, dateStr, instance) => {
						this.setEnd(dateStr);
						this.doFilterByDate();
					}
				},
				reportData: []
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			await this.getData(this.$route.params.id);
			this.title = this.employee.name + " - Daily Report";
			await this.getReports();
			this.setPagination(this.meta.pagination);
			this.getProjects();
		},
		computed: {
			...mapGetters({
				employee: 'employees/single',
				employeeReports:'employeeReports/data',
				meta:'employeeReports/meta',
				loggedInUser: 'auth/data',
				projects: 'clientProjects/formatted'
			})
		},
		methods : {
			...mapActions({
				fetchEmployee: 'employees/getEmployee',
				getEmployeeReports:'employeeReports/getEmployeeReports',
				getProjects: 'clientProjects/getProjects'
			}),
			async getReports() {
				await this.getEmployeeReports({ query: _.merge(this.getParams(), { employee_id: this.$route.params.id }) });
				this.reportData = this.employeeReports;
			},
			async getData(employeeId) {
				try {
					await this.fetchEmployee({
						id: employeeId
					});
					console.log(this.employee, "__EMPLOYEE__");
				} catch (e) {
					console.log(e);
					// user cannot be found
					// redirect back to employees list
					this.$router.push("/daily-reports");
				}
			},
			showComposeModal(formOptions) {
				this.form = formOptions;
				this.open = true;
			},
			closeModalDialogue() {
				this.open = false;
			},
			setStart(start) {
				this.filterDate.start = start;
			},
			setEnd(end) {
				this.filterDate.end = end;
			},
			doFilter(toFilter) {
				this.filterSpecific = toFilter;

				if(toFilter == "date") {
					this.doFilterByDate();
				} else {
					this.doFilterByProject(this.filterProject);
				}
			},
			async doFilterByProject(toFilter) {
				this.filterProject = toFilter;

				if (this.filterProject == '0') this.setFilter(null);
				else this.setFilter(`project|${this.filterProject}`);

				await this.getReports();
				this.setPagination(this.meta.pagination);
			},

			async doFilterByDate() {
				if(this.filterDate.start !== '' && this.filterDate.end !== '') {
					let filterDateStr = this.filterDate.start + ":" + this.filterDate.end;
					this.setFilter(`date|${filterDateStr}`);

					await this.getReports();
					this.setPagination(this.meta.pagination);
				}
			},
			async paginate(page) {
	            this.gotoPage(page);
				await this.getReports();
	            this.setPagination(this.meta.pagination);
	        },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
				await this.getReports();
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
				await this.getReports();
	            this.setPagination(this.meta.pagination);
	        },
		    async reload() {
				await this.getReports();
				this.setPagination(this.meta.pagination);
		    	this.open = false;
		    }

		},
		components: {
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			ViewDailyReport,
			Select2,
			FlatPickr
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin,
			DateMixin,
			DatePickerMixin
		]
	}
</script>
