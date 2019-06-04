<template>
	<modal-dialog v-show="openModal" :closeButtonText="'Close'" :options="option" :title="info.name" @close="closeModal" :closeIsDisabled="isDisabled">
		<template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 permission-table-container">

							<data-table
								:columns="data.columns"
								:showSearch="false"
								:showFilter="false"
								:showPagination="false">

								<!-- BEGIN PERMISSION DATA -->
								<tbody v-if="rolePermissions.length">
									<tr
										:class="index % 2 == 0 ? 'even' : 'odd'"
										style="cursor: pointer"
										v-for="(permission, index) in rolePermissions"
										:key="index">

										<td>{{ permission.resource_name }}</td>
										<td class="text-center">
											<span class="custom-control custom-checkbox">
												<input type="checkbox" :name="'view_'+index+'_'+permission.id" :id="'view_'+index+'_'+permission.id" class="custom-control-input" @change="togglePermission(permission)"  v-model="permission.can_view" />
												<label :for="'view_'+index+'_'+permission.id" class="custom-control-label"></label>
											</span>
										</td>
										<td class="text-center">
											<span class="custom-control custom-checkbox">
												<input type="checkbox" :disabled="!hasPermission(permission)" :name="'add_'+index+'_'+permission.id" :id="'add_'+index+'_'+permission.id" class="custom-control-input" @change="togglePermission(permission)" v-model="permission.can_add" />
												<label :for="'add_'+index+'_'+permission.id" class="custom-control-label"></label>
											</span>
										</td>
										<td class="text-center">
											<span class="custom-control custom-checkbox">
												<input type="checkbox" :disabled="!hasPermission(permission)" :name="'edit_'+index+'_'+permission.id" :id="'edit_'+index+'_'+permission.id" class="custom-control-input" @change="togglePermission(permission)"  v-model="permission.can_edit" />
												<label :for="'edit_'+index+'_'+permission.id" class="custom-control-label"></label>
											</span>
										</td>
										<td class="text-center">
											<span class="custom-control custom-checkbox">
												<input type="checkbox" :disabled="!hasPermission(permission)" :name="'delete_'+index+'_'+permission.id" :id="'delete_'+index+'_'+permission.id" class="custom-control-input" @change="togglePermission((permission))" v-model="permission.can_delete" />
												<label :for="'delete_'+index+'_'+permission.id" class="custom-control-label"></label>
											</span>
										</td>
									</tr>
								</tbody>
								<!-- END PERMISSION DATA -->
								
							</data-table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped>
	table {		
		border-collapse: collapse !important;
	}
	table tr {
		cursor: default !important;
	}	
	span.custom-control.custom-checkbox {
		padding: 0 !important;
		width: 18px !important;
		height: 18px !important;
		display: inline-block;
	}
	.custom-control-label {
		position: absolute !important;
		width: 18px !important;
		height: 18px !important;
		top: 0 !important;
		left: 0 !important;
	}
	.custom-control-label::before {
		left: 0 !important;
	}	
</style>

<!-- Hide Datatable header -->
<style>
	.modal div.dataTables_wrapper .row:first-child {
		display: none !important;
	}
	.permission-table-container{
		overflow-y: auto;
    	height: 400px;
	}
	.permission-table-container::-webkit-scrollbar {
        width: 8px;
    }
    .permission-table-container::-webkit-scrollbar-thumb {
        background-color: #e2e2e2;
        outline: 1px solid slategrey;
    }
</style>

<script>
	//components
	import ModalDialog from '@components/modal-dialog.vue';
	import DataTable from '@components/datatable.vue';

	//mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';

	import { mapActions, mapGetters } from 'vuex'

	import _ from 'lodash';

	export default {
		props: {
			info: { type: Object, required: true}
		},
		data() {
			let sortOrder = {};
			let sortKey = 'permission';
			let columns = [
				{ label: 'Permission', key: 'permission', width: '40%', sortable: false},
				{ label: 'View', key: 'delete', width: '15%', sortable: false, text_align: 'text-center' },
				{ label: 'Add', key: 'add', width: '15%', sortable: false, text_align: 'text-center' },
				{ label: 'Edit', key: 'edit', width: '15%', sortable: false, text_align: 'text-center' },
				{ label: 'Delete', key: 'view', width: '15%', sortable: false, text_align: 'text-center' }
			];
			
			columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'asc'
			});

			return {
				sortKey:sortKey,
				sortOrder:sortOrder,
				option: { height: 'auto', width: '600px', bottom: 'auto' },				
				data: {
					columns: columns
				},
				resource: [],
				rolePermissions: [],
				isDisabled: false,
				userRoleIncludes: [
					'permissions'
                ],
			}
		},
		async created() {			
			await this.getRole(this.info.role);
			await this.getPermissions({query: {take: 99999}});
			await this.getResources({query: {take: 99999}});
			this.pushInitialPermissions();
		},
		computed: {
			...mapGetters({
				permissions: 'rolePermissions/data',
				resources: 'resources/formatted',
				roles: 'roles/data',
				loggedInUser: 'auth/data',
				role: 'roles/role',
				userRoles: 'userRoles/role',
				userRolePermissions: 'userRolePermissions/role',
			}),
			hasPermission: function() {
				return permission => permission.can_view == 1;
			}
		},
		methods: {
			...mapActions({
				getPermissions: 'rolePermissions/getPermissions',
				toggleResourcePermission: 'rolePermissions/savePermission',
				getResources: 'resources/getResources',
				getRole: 'roles/getRole',
				saveRole: 'roles/saveRole',
				getUserRole: 'userRoles/getUserRole',
				saveUserRolePermission: 'userRolePermissions/saveUserRolePermission',
			}),
			async togglePermission(permission) {
				// pre-process data prior to saving
				if (permission.can_view == 0) {
					permission.can_add = 0;
					permission.can_edit = 0;
					permission.can_delete = 0;
				}
				// disable cancel button
				this.isDisabled = true;

				await this.getUserRole({
					role_id: permission.role_id,
					include: this.userRoleIncludes.join(","),
					take: 99999
				});
				_.each(this.userRoles, element => {
					let user_role_permission = {
							id:'',
							can_add: permission.can_add,
							can_edit: permission.can_edit,
							can_view: permission.can_view,
							can_delete: permission.can_delete,
							resource_id: permission.resource_id,
							user_role_id: element.id
					}
					_.each(element.permissions.data, user_permission => {
						if(user_permission.resource_id == permission.resource_id){
							user_role_permission.id = user_permission.id
						}
					})

					this.saveUserRolePermission(user_role_permission).then((res) => {
						user_role_permission.id = res.data.id;
                    })
				})

				this.toggleResourcePermission(permission).then((res) => {
					// we need to update the id for this resource permission so it won't keep on saving new record for this resource
					permission.id = res.data.id;

					// enable cancel button
					this.isDisabled = false;
				})
				this.role.updated_by_user_id = this.loggedInUser.data.id;
				this.saveRole(this.role);
			},
			pushInitialPermissions(){
				_.each(this.resources, (resource) => {
					this.rolePermissions.push({
						id:'',
						can_add: 0, 
						can_edit: 0, 
						can_view: 0,
						can_delete: 0,
						resource_id: resource.id,
						role_id: this.info.role,
						resource_name: resource.text
					})
					_.each(this.permissions, (permission) => {
						_.each(this.rolePermissions, (rolePermission) => {
							if( rolePermission.resource_id == permission.resource_id && rolePermission.role_id == permission.role_id) {
								rolePermission.id = permission.id;
								rolePermission.can_add = permission.can_add;
								rolePermission.can_edit = permission.can_edit;
								rolePermission.can_view = permission.can_view;
								rolePermission.can_delete = permission.can_delete;
							}
						});
					});
				});
			}
		},
		components: {
			ModalDialog,
			DataTable
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
	        StringHelperMixin
	    ]
	}
</script>
