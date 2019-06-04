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
                                	<button type="button" @click="openAccessModal({key: 'create-update-user', name: 'Add User'})" tag="button" class="btn btn-primary">Add User</button>
                                </div> 
                            </div>
                        </div>
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            :searchPlaceholder="setPlaceholder"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <!-- BEGIN USERS DATA -->
                            <tbody v-if="users.length" id='user-list'>
                                <tr
                                    :class="setClass(index, user.id)"
                                    style="cursor: pointer"
                                    v-for="(user, index) in users"
                                    :key="user.id">

                                    <td>{{ user.user_name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td align="center">
										<div class="access-wrapper">
                                    	<a href="#" class="action-button" title="Revoke Access" @click="revokeUserAccess(user)" v-if="user.can_login">
                                    		<i class="la la-unlock-alt"></i>
                                        </a>
										<a href="#" class="action-button" title="Grant Access" @click="grantUserAccess(user)" v-else>
                                    		<i class="la la-lock"></i>
                                        </a>
										</div>
                                        <a href="#" class="action-button" title="Edit User" @click="showEditDialogoue({key: 'create-update-user', name:'Edit User', user: user.id})">
                                            <i class="la la-pencil"></i>
                                        </a>
                                        <!-- <a href="#" class="action-button" title="Delete Employee" @click="showDeleteConfirmation(user.id, user.user_name)">
                                            <i class="la la-trash"></i>
                                        </a> -->
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END USERS DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
            <!-- BEGIN WORK DETAIL DIALOG -->
	         <create-user-modal v-if="form.key == 'create-update-user' && open" :openModal="open" @success="reload" @close="open = false" 
	         :info="form"></create-user-modal>
	        <!-- END WORK DETAIL DIALOG -->
		</page-content>
	</div>
</template>
<style scope>
	.action-button {
	    font-size: 20px;
	} 
	/* todo: change color please */
	#user-list tr.admin {
		background-color: #e6ffed;
	}
	.access-wrapper {
		display: inline;
	}
</style>

<script>

	// components
	import PageHeader from '@components/page-header.vue'
	import PageContent from '@components/page-content.vue'
	import DataTable from '@components/datatable.vue'

	import ModalDialog from '@components/modal-dialog.vue'
	import CreateUserModal from '@views/pages/users/_modals/create-user.vue'
	import Select2 from '@components/select2.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex'

	export default {
		data() {
        	let sortOrder = {};
			let sortKey = 'user_name';
	        let columns = [
	            { label: 'Username', key: 'user_name', sortKey: 'user_name', width: '40%', sortable: true },
	            { label: 'Email', key: 'email', sortKey: 'email', width: '40%', sortable: true },
	            { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'desc' 
	        });

			return {
				title:'User Management',
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
	                user:{}
				},
				admins: ',1,',
				roleData: {
					role_id: '', 
					user_id: '', 
					user_type: ''
				}
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			await this.getUsers({query: this.getParams()});
			this.setPagination(this.meta.pagination);	
			await this.getUserRoles({query: {take: 999999, role: 2}});
			this.adminRoles.forEach(role => {
				this.admins += role.user_id + ',';
			});
		},
		computed: {
			...mapGetters({
				users:'users/data',
				meta:'users/meta',
				adminRoles: 'roleUsers/data',
				role: 'roleUsers/role'
			}),
			setPlaceholder() { return 'Search user'; }
			
		},
		methods : {
			...mapActions({
				getUsers: 'users/getUsers',
				deleteUser: 'users/deleteUser',
				saveUser: 'users/saveUser',
				getUserRoles: 'roleUsers/getUserRoles',
				getUserRole: 'roleUsers/getUserRole',
				saveUserRole: 'roleUsers/saveUserRole'
			}),
			isAdmin(toCheck) {
				if(this.admins.indexOf(',' + toCheck + ',') >= 0)
					return true;
			},
			setClass(index, id) {
				let className = index % 2 == 0 ? 'even' : 'odd';
				if(this.isAdmin(id)) {
					className += ' admin';
				}
				return className;
			},
			openAccessModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
			async paginate(page) {
	            this.gotoPage(page);
	            await this.getUsers({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async search(term) {
	            this.setSearch(term);
	            await this.getUsers({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
	            await this.getUsers({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
	            await this.getUsers({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
		    async reload() {
		    	await this.getUsers({query: this.getParams()});
				this.setPagination(this.meta.pagination);
				await this.getUserRoles({query: {take: 999999, role: 2}});
				this.admins = ',1,';
				this.adminRoles.forEach(role => {
					this.admins += role.user_id + ',';
				});
		    	this.open = false;
		    },
		    delete(userId) {
		    	return this.deleteUser(userId);
		    },
		    showEditDialogoue(options) {
		    	this.openAccessModal(options);
		    },
		    showDeleteConfirmation(userId, username) {
	        	const title = 'Are you sure you want to delete this record?';
	            const msg = `${userId} ${username}`;
	            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
	                .then(({ok}) => {
	                    if (ok) this.delete(userId).then(() => this.reload());
	                });
			},
			grantUserAccess(user) {
				this.getUserRole(user.id).catch(() => {});
				const title = 'Grant Access';
	            const msg = `Are you sure you want to grant access to ${user.user_name}`;
	            let data = { id: user.id, can_login: 1, password: 'fullscale1234'};
	            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
	                .then(({ok}) => {
	                    if (ok) {
							this.saveUser(data).then((res) => {
							this.roleData.role_id = this.role.role_id || 3;
							this.roleData.id = (this.role.role_id == undefined) ? 0 : res.data.id;
							this.roleData.user_id = res.data.id;
							this.roleData.user_type = "App\\Models\\User";
							this.saveUserRole(this.roleData).then(() => {
								this.reload();
							});
							});
						}	
	                });
			},
		    revokeUserAccess(user) {
		    	const title = 'Revoke Access';
	            const msg = `Are you sure you want to revoke access to ${user.user_name}`;
	            let data = {id:user.id,can_login:0}
	            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
	                .then(({ok}) => {
	                    if (ok) this.saveUser(data).then(() => this.reload());
	                });
		    }
		},
		components: {
			Select2,
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			CreateUserModal,

		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin
		]
	}
</script>
