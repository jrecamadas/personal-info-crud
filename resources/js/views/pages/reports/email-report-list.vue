<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
			<div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
						<Can I="add" a="report_template">
							<div class="row">
								<div class="col-sm-12 col-md-7">
									<div class="dataTable_buttons">
										<button type="button" @click="openTemplateModal({key: 'create-update-template', name: 'Add Report'})" tag="button" class="btn btn-primary">Create</button>
									</div>
								</div>
							</div>
						</Can>
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
                            <!-- BEGIN SKILLS DATA -->
                            <tbody v-if="reportTemplates.length">
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(reportTemplate, index) in reportTemplates"
                                    :key="reportTemplate.id">

									<td>{{ reportTemplate.name }}</td>
                                    <td>{{ report(reportTemplate.report) }}</td>
                                    <td>{{ reportTemplate.view_file }}</td>

                                    <td align="center">
										<Can I="update" a="report_template">
											<a href="#" class="action-button" title="Edit Template" @click="showEditDialogoue({key: 'create-update-template', name:'Update Report', template: reportTemplate.id})">
												<i class="la la-pencil"></i>
											</a>
										</Can>
										<Can I="delete" a="report_template">
											<a href="#" class="action-button" title="Delete Template" @click="showDeleteConfirmation(reportTemplate.id, reportTemplate.name)">
												<i class="la la-trash"></i>
											</a>
										</Can>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END SKILLS DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
            <!-- BEGIN TEMPLATE DIALOG -->
	         <create-report-modal v-if="form.key == 'create-update-template' && open" :openModal="open" @success="reload" @close="open = false" :info="form">
	         </create-report-modal>
	        <!-- END TEMPLATE DIALOG -->
		</page-content>
	</div>
</template>
<style scope>
	.action-button {
	    font-size: 20px;
	}
</style>

<script>

	// components
	import PageHeader from '@components/page-header.vue';
	import PageContent from '@components/page-content.vue';
	import DataTable from '@components/datatable.vue';

	import ModalDialog from '@components/modal-dialog.vue';
	// import CreateSkillsModal from '@views/pages/skills/_modals/create-skills.vue';
	import CreateReportModal from '@views/pages/reports/_modals/create-report.vue';
	import Select2 from '@components/select2.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin';
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';
	import ReportTemplateMixin from '@common/mixin/ReportTemplateMixin'; 

	import { mapActions, mapGetters } from 'vuex';

	export default {
		data() {
        	let sortOrder = {};
			let sortKey = 'name';
	        let columns = [
				{ label: 'Name', key: 'name', sortKey: 'name', width: '40%', sortable: true },
	            { label: 'Type', key: 'type', sortKey: 'type', width: '25%', sortable: true },
				{ label: 'Template', key: 'view_file', sortKey: 'view_file', width: '25%', sortable: true },
	            { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'desc'
	        });

			return {
				title:'Email Reporting Template',
				pageClass: 'ks-content-nav',
				sortKey:sortKey,
				sortOrder:sortOrder,
				limit: 10,
            	open: false,
				data: {
					columns:columns,
					rows: []
				},
				form: {
	                key: '',
	                name: '',
	                template:{}
	            }
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			await this.getReportTemplates({query: this.getParams()});
     		this.setPagination(this.meta.pagination);
		},
		computed: {
			...mapGetters({
				reportTemplates:'reportTemplates/data',
				meta:'reportTemplates/meta'
			})
		},
		methods : {
			...mapActions({
				getReportTemplates: 'reportTemplates/getReportTemplates',
				deleteReportTemplate: 'reportTemplates/deleteReportTemplate'
			}),
			openTemplateModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
			async paginate(page) {
	            this.gotoPage(page);
	            await this.getReportTemplates({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async search(term) {
	            this.setSearch(term);
	            await this.getReportTemplates({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
	            await this.getReportTemplates({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
	            await this.getReportTemplates({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
		    async reload() {
		    	await this.getReportTemplates({query: this.getParams()});
		    	this.setPagination(this.meta.pagination);
		    	this.open = false;
		    },
		    delete(reportId) {
		    	return this.deleteReportTemplate(reportId);
		    },
		    showEditDialogoue(options) {
		    	this.openTemplateModal(options);
		    },
		    showDeleteConfirmation(reportId, reportName) {
	        	const title = 'Are you sure you want to delete this report?';
	            const msg = `${reportName}`;
	            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
	                .then(({ok}) => {
						if (ok) {
							this.delete(reportId).then(() => this.reload());
							this.notifyDialog('error', 'Successfully deleted!');
						}
	                });
		    }
		},
		components: {
			Select2,
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			CreateReportModal

		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin,
			ReportTemplateMixin
		]
	}
</script>
