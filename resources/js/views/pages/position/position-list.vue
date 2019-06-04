<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
			<div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
								<Can I="add" a="positions">
									<div class="dataTable_buttons">
										<button type="button" @click="openPositionModal({key: 'create-update-position', name: 'Add Position'})" tag="button" class="btn btn-primary">Add New Position</button>
									</div>
								</Can>
                            </div>
                        </div>
                        <!-- BEGIN SKILLS DATA -->
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            
                            <tbody>
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(position, index) in this.positions"
                                    :key="position.id">

                                    <td>{{ position.job_title }}</td>
                                    <td>{{ position.job_description }}</td>
                                    
                                    <td align="center">
										<Can  I="update" a="positions">
											<a href="#" class="action-button" title="Edit Employee" @click="showEditDialogoue({key:'create-update-position',name:'Update Position', position:position.id})">
												<i class="la la-pencil"></i>
											</a>
										</Can>
										<Can  I="delete" a="positions">
											<a href="#" class="action-button" title="Delete Employee" @click="showDeleteConfirmation(position.id, position.job_title)">
												<i class="la la-trash"></i>
											</a>
										</Can>
                                    </td>
                                </tr>
                            </tbody>
                        </data-table>
                        <!-- END SKILLS DATA -->
                    </div>
                </div>
            </div>
            <!-- BEGIN WORK DETAIL DIALOG -->
	        <create-position-modal v-if="form.key == 'create-update-position' && open" :openModal="open" @success="reload" @close="open = false" :info="form"></create-position-modal>
	        <!-- END WORK DETAIL DIALOG -->
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
	import PageHeader from '@components/page-header.vue'	
	import PageContent from '@components/page-content.vue'
	import DataTable from '@components/datatable.vue'
	
	import ModalDialog from '@components/modal-dialog.vue'
	import CreatePositionModal from '@views/pages/position/_modals/create-position.vue'
	import Select2 from '@components/select2.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex'

	export default {
		data() {
        	let sortOrder = {};
			let sortKey = 'job_title';
	        let columns = [
	            { label: 'Title', key: 'job_title', sortKey: 'job_title', width: '45%', sortable: true },
	            { label: 'Description', key: 'job_description', sortKey: 'job_description', width: '45%', sortable: true },
	            { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'desc'
	        });

			return {
				title:'Job Position Management',
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
	                position:{}
	            }
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			await this.getPositions({query:this.getParams()});
			this.setPagination(this.meta.pagination);
		},
		computed: {
			...mapGetters({
				positions:'jobPositions/data',
				meta:'jobPositions/meta'
			})
		},
		methods : {
			...mapActions({
				getPositions: 'jobPositions/getJobPositions',
				deletePosition: 'jobPositions/deletePosition'
			}),
			openPositionModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
			async paginate(page) {
	            this.gotoPage(page);
	            await this.getPositions({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async search(term) {
	            this.setSearch(term);
	            await this.getPositions({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
	            await this.getPositions({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
	            await this.getPositions({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
		    async reload() {
		    	await this.getPositions({query:this.getParams()});
		    	this.setPagination(this.meta.pagination);
		    	this.open = false;
		    },
		    delete(positionId) {
		    	return this.deletePosition(positionId);
		    },
		    showEditDialogoue(options) {
		    	this.openPositionModal(options);
		    },
		    showDeleteConfirmation(positionId, positionName) {
	        	const title = 'Are you sure you want to delete this record?';
	            const msg = `${positionId} ${positionName}`;
	            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
	                .then(({ok}) => {
						if (ok) {
							this.delete(positionId).then(() => this.reload());
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
			CreatePositionModal,
			
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin
		]
	}
</script>