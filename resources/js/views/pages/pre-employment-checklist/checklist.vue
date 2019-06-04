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
                                    <button type="button" @click="openPositionModal({key: 'create-update-position', name: 'Add Inventory'})" tag="button" class="btn btn-primary">Add New Inventory</button>
                                </div>
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
                                    v-for="(inventory, index) in data.rows"
                                    :key="inventory.id">

                                    <td>{{ inventory.id }}</td>	
                                    <td>{{ inventory.document }}</td>
                                    <td>{{ inventory.description }}</td>
                                    <td>Delete</td>
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
	import Select2 from '@components/select2.vue';
	import EmployeeForm from '@views/pages/employee/_forms/employee.vue';
	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex'

	export default {
		data() {
        	let sortOrder = {};
			let sortKey = 'id';
	        let columns = [
	        	{ label: 'ID', key: 'id', sortKey: 'id', width: '45%', sortable: true },
	            { label: 'Item Name', key: 'document', sortKey: 'document', width: '45%', sortable: true },
	            { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'desc'
	        });
 
			return {
				title:'Pre Employment Checklist',
				pageClass: 'ks-content-nav',
				sortKey:'id',
	            sortOrder: sortOrder,
	            filterPosition: '0',
	            limit: 50,
	            open: false,
	            data: {
	                columns: columns,
	                rows: []
	            },
	            form: {
	                key: '',
	                name: ''
	            },
	            modal: {
	                width: '800px',
	                height: '400px'
	            },
			}
		},
		async created() {
	        // init
	        this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
	        this.setPaginationLimit(this.limit);

	        await this.getPreEmploymentChecklist({query: {take: 50}, extra: {}});
	        this.getData();
		},
		computed: {
			...mapGetters({
	            meta: 'preEmploymentChecklists/meta',
	            checklists: 'preEmploymentChecklists/data'				
			})
		},
		methods : {
			...mapActions({
				getPreEmploymentChecklist: 'preEmploymentChecklists/getPreEmploymentChecklist',
			}),
	        async getData() { 
	            let data = [];

	            await this.getPreEmploymentChecklist({query: this.getParams()});

	            // set pagination
	            this.setPagination(this.meta.pagination);

	            this.checklists.forEach((inv) => {
	                data.push({
	                    id: inv.id,
	                    document: inv.document,
	                    description: inv.description,
	                });
	            });

	            this.data.rows = data;
	        },			
		},
		components: {
			Select2,
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin
		]
	}
</script>