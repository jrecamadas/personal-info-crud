<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
			<div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
								<div>
									<button squared variant="outline-secondary" @click="openPersonalModal({key: 'create-update-personalinfo', name: 'Add New Info'})" tag="button" class="btn btn-primary">Add New Info</button>
									<!-- <Can I="add" a="personalinfo">
										<div class="dataTable_buttons">
											<button type="button" @click="openPersonalModal({key: 'create-update-personalinfo', name: 'Add New Info'})" tag="button" class="btn btn-primary">Add New Info</button>
										</div>
									</Can> -->
								</div>
								<label>&nbsp;</label>
                            </div>
                        </div>
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
                            <!-- BEGIN SKILLS DATA -->
                            <tbody v-if="personalinfo.length">
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(info, index) in personalinfo"
										:key="info.id">

										<td>{{ info.name }}</td>
										<td>{{ info.address }}</td>
										<td>{{ info.birthday }}</td>
										<td>{{ info.phone_number }}</td>
										<td>{{ info.email }}</td>

										<td align="center">
											<!-- <Can I="update" a="personalinfo"> -->
												<a href="#" class="action-button" title="Edit Personal Info" @click="showEditDialogoue({key: 'create-update-personalinfo', name:'Update Info', infoId: info.id})">
													<i class="la la-pencil"></i>
												</a>
											<!-- </Can> -->
											<!-- <Can I="delete" a="personalinfo"> -->
												<a href="#" class="action-button" title="Delete Personal Info" @click="showDeleteConfirmation(info.id, info.name)">
													<i class="la la-trash"></i>
												</a>
											<!-- </Can> -->
										</td>
                                </tr>
                            </tbody>
                            <!-- END SKILLS DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
            <!-- BEGIN WORK DETAIL DIALOG -->
	        <create-personalinfo-modal v-if="form.key == 'create-update-personalinfo' && open" :openModal="open" @success="reload" @close="open = false" :info="form"></create-personalinfo-modal>
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
	import PageHeader from '@components/page-header.vue';
	import PageContent from '@components/page-content.vue';
	import DataTable from '@components/datatable.vue';

	import ModalDialog from '@components/modal-dialog.vue';
	import CreatePersonalinfoModal from '@views/pages/personal-info/_modals/create-info.vue';
	import Select2 from '@components/select2.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin';
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex';
	export default {
		data() {
        	let sortOrder = {};
			let sortKey = 'name';
	        let columns = [
	            { label: 'Name', key: 'name', sortKey: 'name', width: '20%', sortable: true },
				{ label: 'Address', key: 'address', sortKey: 'address', width: '20%', sortable: false },
				{ label: 'Birthday', key: 'birthday', sortKey: 'birthday', width: '20%', sortable: false },
				{ label: 'Phone Number', key: 'phone_number', sortKey: 'phone_number', width: '20%', sortable: false },
				{ label: 'Email Address', key: 'email', sortKey: 'email', width: '20%', sortable: false },
	            { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'desc'
	        });

			return {
				title:'Personal Information',
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
	                information:{}
	            },
                applicants: []
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			this.setPaginationLimit(9999);
			this.getPersonalInfo({query: this.getParams()});
			this.setPagination(this.meta.pagination);
		},
		computed: {
			...mapGetters({
				meta:'personalInfo/meta',
				personalinfo: 'personalInfo/data'
				
			})
		},
		methods : {
			...mapActions({
				getPersonalInfo: 'personalInfo/getPersonalInfo',
				deletPersonalInfo: 'personalInfo/deletPersonalInfo'
                //getEmployees: 'employees/getEmployees',
			}),
			openPersonalModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
			async paginate(page) {
	            this.gotoPage(page);
	            await this.getPersonalInfo({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async search(term) {
				this.setSearch(term);
	            await this.getPersonalInfo({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
			},
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
	            await this.getPersonalInfo({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
	            await this.getPersonalInfo({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
		    async reload() {
		    	await this.getPersonalInfo({query: this.getParams()});
		    	this.setPagination(this.meta.pagination);
		    	this.open = false;
		    },
		    delete(personalId) {
		    	return this.deletPersonalInfo(personalId);
		    },
		    showEditDialogoue(options) {
		    	this.openPersonalModal(options);
		    },
		    showDeleteConfirmation(personalId, personalName) {
                if(1 != 1){
                    let flags = [];

                } else {
                    const title = 'Are you sure you want to delete this record?';
                    const msg = `${personalName}`;
                    this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                        .then(({ok}) => {
                            if (ok) {
								this.delete(personalId).then(() => this.reload());	
								this.notifyDialog('error', 'Successfully deleted!');
							}
                        });
                }
		    }
		},
		components: {
			Select2,
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			CreatePersonalinfoModal,
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin
		]
	}
</script>
