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
									<Can I="add" a="roles">
										<button type="button" @click="openRolesModal({key: 'add-new-role', name: 'Add New Role'})" tag="button" class="btn btn-primary">
											<span class="la la-plus ks-icon"></span>
											<span class="ks-text">Add New Role</span>
										</button>
									</Can>
                                </div>
                            </div>
                        </div>
						<data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
							:itemsFilter="limit"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">

                            <!-- BEGIN ROLES DATA -->
                            <tbody v-if="roles.length">
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"                                    
                                    v-for="(role, index) in roles"
                                    :key="role.id">

									<td>
										<Can I="update" a="roles">
											<label class="ks-checkbox-switch ks-primary">
												<input type="checkbox" v-model="role.is_enabled" @change="toggleEnable(role)" />
												<span class="ks-wrapper"></span>
												<span class="ks-indicator"></span>
												<span class="ks-on">On</span>
												<span class="ks-off">Off</span>
											</label>
										</Can>
									</td>
                                    <td>{{ role.display_name }}</td>
                                    <td>{{ role.description }}</td>
									<td>{{ role.updated_by ? role.updated_by.initial : '' }}</td>
									<!-- TEMPORARY FIXED. -->
									<td>{{ role.updated_at ? formatDate(role.updated_at.date,'MM/DD/YYYY') : '' }}</td>
									<!-- END TEMPORARY FIXED. -->
                                    <td align="center">
										<Can I="update" a="resource_role_permission">
											<a href="javascript: void(0);" class="action-button" title="Edit Permission" @click="showEditDialogoue({ key: 'edit-permission', name:'Edit Permission - '+ role.display_name +' Role', role: role.id })">
												<i class="la la-lock"></i>
											</a>
										</Can>
										<Can I="update" a="roles">
											<a href="javascript: void(0);" class="action-button" title="Edit Role" @click="showEditRole({ key: 'add-new-role', name:'Edit Role', role: role.id })">
												<i class="la la-pencil"></i>
											</a>
										</Can>
										<Can I="delete" a="roles">
											<a href="javascript: void(0);" class="action-button" title="Delete Role" @click="showDeleteConfirmation(role)">
												<i class="la la-trash"></i>
											</a>
  										</Can>										
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END ROLES DATA -->
							
                        </data-table>
                    </div>
                </div>
            </div>
			<!-- BEGIN CREATE ROLE DIALOG -->
	        <add-new-role-modal v-if="form.key == 'add-new-role' && open" :openModal="open" @close="open = false" :info="form" @success="reload"></add-new-role-modal>
	        <!-- END CREATE ROLE DIALOG -->

            <!-- BEGIN EDIT PERMISSION DIALOG -->
	        <edit-permission-modal v-if="form.key == 'edit-permission' && open" :openModal="open" @close="open = false" :info="form"></edit-permission-modal>
	        <!-- END EDIT PERMISSION DIALOG -->
		</page-content>
	</div>
</template>

<style scoped>
	.action-button {
	    font-size: 20px;
	}
	table tr {
		cursor: default !important;
	}
</style>

<script>
	// components
	import PageHeader from '@components/page-header.vue';
	import PageContent from '@components/page-content.vue';
	import DataTable from '@components/datatable.vue';
	import ModalDialog from '@components/modal-dialog.vue';
	import EditPermissionModal from '@components/modal/role/permission.vue';
	import AddNewRoleModal from '@components/modal/role/add-new-role.vue';
	import Select2 from '@components/select2.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin';
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';
	import DateMixin from '@common/mixin/DateMixin';
	
	import { mapActions, mapGetters } from 'vuex'

	import _ from 'lodash';

	export default {
		data() {
        	let sortOrder = {};
			let sortKey = 'display_name';
	        let columns = [
	            { label: 'Enable', key: 'enable', sortKey: 'enable', width: '10%', sortable: false },
				{ label: 'Role', key: 'display_name', sortKey: 'display_name', width: '15%', sortable: true },
				{ label: 'Description', key: 'description', sortKey: 'description', width: '35%', sortable: false },
				{ label: 'Updated By', key: 'updated_by', sortKey: 'updated_by', width: '15%', sortable: false },
				{ label: 'Updated Date', key: 'updated_at', sortKey: 'updated_at', width: '12%', sortable: true },
	            { label: 'Action', key: 'action', sortKey: '', width: '13%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'asc'
			});

			return {
				title: 'Role Management',
				pageClass: 'ks-content-nav',
				sortKey: sortKey,
				sortOrder: sortOrder,
				limit: 15,
            	open: false,
				data: {
					columns: columns,
					rows: []
				},				
				form: {
	                key: '',
	                name: '',
	                role: {}
				}
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			this.setPaginationLimit(this.limit);
			await this.getRoles({query: this.getParams()});       
		
			this.setPagination(this.meta.pagination);
			this.loggedInUser;
		},
		computed: {
			...mapGetters({
				roles: 'roles/data',
				meta: 'roles/meta',
				loggedInUser: 'auth/data'
			})
		},		
		methods : {
			...mapActions({
				getRoles: 'roles/getRoles',
				deleteRole: 'roles/deleteRole',
				toggleRole: 'roles/saveRole',
			}),
			openRolesModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
		    showEditDialogoue(options) {
				this.openRolesModal(options);
				this.open = true
			},
			showEditRole(options) {
		    	this.openRolesModal(options);
		    },
			async paginate(page) {
	            this.gotoPage(page);
	            await this.getRoles({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async search(term) {				
	            this.setSearch(term);
	            await this.getRoles({query:this.getParams()});
				this.setPagination(this.meta.pagination);
	        },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
	            await this.getRoles({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
	            await this.getRoles({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
			async reload() {
		    	await this.getRoles({query: this.getParams()});
		    	this.setPagination(this.meta.pagination);
		    	this.open = false;
		    },
			delete(roleId) {
		    	return this.deleteRole(roleId);
		    },		    
		    showDeleteConfirmation(role) {
				const title = 'Are you sure you want to delete this record?';
				const msg = role.name +' - '+ role.display_name;
				this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
					.then(({ok}) => {
						if (ok) this.delete(role.id).then(() => this.reload());
						this.notifyDialog('error', 'Successfully deleted!');
					});
			},
			async toggleEnable(role) {
				role.updated_by_user = this.loggedInUser.data.id;				
				await this.toggleRole(role);
				this.reload();
			}			
		},
		components: {
			Select2,
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			EditPermissionModal,
			AddNewRoleModal
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin,
			DateMixin
		]
	}
</script>
