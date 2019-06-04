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
                                	<button type="button" @click="showComposeModal({key: 'compose-report', name: 'Send Report'})" tag="button" class="btn btn-primary">Compose new message</button>
                                </div> 
                            </div>
                        </div>
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
                            <!-- BEGIN USER REPORT DATA -->
                            <tbody v-if="employeeReports.length">
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(employeeReport, index) in employeeReports"
                                    :key="employeeReport.id">

                                    <td><a href="#" @click="showComposeModal({key: 'view-report', name: 'View Report', id: employeeReport.id})">{{ employeeReport.subject }}</a></td>
                                    <td>{{ formatDate(employeeReport.report_date, 'MM-DD-YYYY') }}</td>

                                    <!-- <td align="center"> -->
                                    <!-- 	<a href="#" class="action-button" title="Edit Employee" @click="showEditDialogoue({key: 'create-update-skills', name:'Update Skill', skill: skill.id})">
                                            <i class="la la-pencil"></i>
                                        </a>
                                        <a href="#" class="action-button" title="Delete Employee" @click="showDeleteConfirmation(skill.id, skill.name)">
                                            <i class="la la-trash"></i>
                                        </a> -->
                                    <!-- </td> -->
                                </tr>
                            </tbody>
                            <!-- END USER REPORT DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
		</page-content>
		<send-daily-report v-if="form.key=='compose-report' && open" :openModal="open" @success="reload" @close="closeModalDialogue" :info="form"></send-daily-report>
		<view-daily-report v-if="form.key=='view-report' && open" :openModal="open" @close="closeModalDialogue" :info="form"></view-daily-report>
	</div>
</template>
<style scope>
	.action-button {
	    font-size: 20px;
	}
</style>

<script>

	// components
	import PageHeader from '@components/page-header.vue'
	import PageContent from '@components/page-content.vue'
	import DataTable from '@components/datatable.vue'
	import ModalDialog from '@components/modal-dialog.vue'

	// 
	import SendDailyReport from '@views/pages/users/_modals/send-daily-report.vue';
	import ViewDailyReport from '@views/pages/users/_modals/view-daily-report.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';
	import DateMixin from '@common/mixin/DateMixin';

	import { mapActions, mapGetters } from 'vuex';

	export default {
		data() {
			let sortOrder = {};
			let sortKey = 'subject';
	        let columns = [
	            { label: 'Subject', key: 'subject', sortKey: 'subject', width: '60%', sortable: true },
	            { label: 'Date', key: 'created_at', sortKey: 'created_at', width: '40%', sortable: true },
	            // { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'asc';
	        });
			return {
				title:'Daily Report',
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
	            }
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			await this.fetchEmployee({user_id:this.loggedInUser.data.id});
			await this.getEmployeeReports({query: this.getParams(), employee_id: this.employee[0].id});
     		this.setPagination(this.meta.pagination);
		},
		computed: {
			...mapGetters({
				employee: 'employees/single',
				employeeReports:'employeeReports/data',
				meta:'employeeReports/meta',
				loggedInUser: 'auth/data'
			})
		},
		methods : {
			...mapActions({
				fetchEmployee: 'employees/getEmployee',
				getEmployeeReports:'employeeReports/getEmployeeReports'
			}),
			showComposeModal(formOptions) {
				this.form = formOptions;
				this.open = true;
			},
			closeModalDialogue() {
				this.open = false;
			},
			async paginate(page) {
	            this.gotoPage(page);
	           	await this.fetchEmployee({user_id:this.loggedInUser.data.id});
				await this.getEmployeeReports({query: this.getParams(), employee_id: this.employee[0].id});
	            this.setPagination(this.meta.pagination);
	        },
	        // async search(term) {
	        //     this.setSearch(term);
	        //     await this.getEmployeeReports({query: this.getParams(), user_id:this.loggedInUser.data.id});
	        //     this.setPagination(this.meta.pagination);
	        // },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
	            await this.fetchEmployee({user_id:this.loggedInUser.data.id});
				await this.getEmployeeReports({query: this.getParams(), employee_id: this.employee[0].id});
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
	            await this.fetchEmployee({user_id:this.loggedInUser.data.id});
				await this.getEmployeeReports({query: this.getParams(), employee_id: this.employee[0].id});
	            this.setPagination(this.meta.pagination);
	        },
		    async reload() {
		    	await this.fetchEmployee({user_id:this.loggedInUser.data.id});
				await this.getEmployeeReports({query: this.getParams(), employee_id: this.employee[0].id});
				this.setPagination(this.meta.pagination);
		    	this.open = false;
		    }
			
		},
		components: {
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			SendDailyReport,
			ViewDailyReport
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin,
			DateMixin
		]
	}
</script>
