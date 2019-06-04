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
                                    <button @click="openSuperAdminUserInvite({ key: 'create-update-user', name: 'Invite New Super Admin' })" type="button" tag="button" class="btn btn-primary">
										<span class="la la-plus ks-icon"></span>
                    					<span class="ks-text">Invite New Super Admin User</span>
									</button>
                                </div>
                            </div>
                        </div>
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
							:searchPlaceholder="searchPlaceholder"
							:tableLoading="loading"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <!-- BEGIN USERS DATA -->
                            <tbody  v-if="users.length" id='user-list'>
                                <tr v-for="user in users" :key="user.id">
									<td>
										<Can I="update" a="users">
											<label class="ks-checkbox-switch ks-primary" :class="{ 'fs-is-disabled': disableToggle(user) }">
												<input type="checkbox" v-model="user.can_login" v-on:change="toggleCanLogin(user)" :disabled="disableToggle(user)">
												<span class="ks-wrapper"></span>
												<span class="ks-indicator"></span>
												<span class="ks-on">On</span>
												<span class="ks-off">Off</span>
											</label>
										</Can>
									</td>
                                    <td>
										<template v-for="(role, index) in displayRoles(user.roles.data)">
											<span :class="role.is_enabled == 1 ? 'fs-active-user' : '' " :key="index">{{ role.details.display_name }}</span>
										</template>
									</td>
									<td>{{ getUserName(user) }}</td>
                                    <td>{{ user.user_name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.updated_by ? user.updated_by.initial : '' }}</td>
                                    <td>{{ formatDate(user.updated_at,'MM/DD/YYYY') }}</td>
                                    <td align="center">
										<Can I="add" a="user_roles">
											<a href="javascript:;" class="action-button" title="Assign Role" @click="showAddUserRoleDialogue({ key: 'add-user-role', name: 'Assign Role', user: user })">
												<i class="la la-cube"></i>
											</a>
										</Can>
										<Can I="update" a="users">
											<a href="javascript:;" class="action-button" title="Edit User" @click="showEditDialogoue({ key: 'edit-user', name:'Edit User', user: user.id })">
												<i class="la la-pencil"></i>
											</a>
										</Can>
										<!-- <Can I="update" a="resource_user_role_permission">
											<router-link v-if="displayRole(user.roles.data).length" :to="{name: 'user', params: {id: user.id}}"><i title="Edit User Role Permissions" class="la la-user-secret"></i></router-link>
										</Can> -->
										<Can I="delete" a="users">
											<a href="javascript:;" class="action-button" title="Delete User" @click="showDeleteConfirmation(user.id, user.user_name, user.email)">
												<i class="la la-trash"></i>
											</a>
										</Can>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END USERS DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
			<!-- BEGIN MODAL LIST -->
			<edit-user-modal v-if="form.key == 'edit-user' && open" :openModal="open" @success="reload" @close="open = false" :info="form"></edit-user-modal>
			<add-user-role-modal v-if="form.key == 'add-user-role' && open" :openModal="open" @success="reload" @close="open = false" :info="form"></add-user-role-modal>
			<create-user-modal v-if="form.key == 'create-update-user' && open" :openModal="open" @success="reload" @close="open = false" :info="form" :showDropdown="false"></create-user-modal>
			<!-- END MODAL LIST -->
		</page-content>
	</div>
</template>

<style lang="scss" scoped>
	.action-button {
	    font-size: 18px;
	}
    .access-wrapper {
		display: inline;
	}
	i.la-user-secret{
		font-size: 18px;
	}
	.inactive {
        background: gray!important;
	}
	.fs-active-user {
		font-weight: 600;
	}
	.ks-checkbox-switch > .ks-wrapper {
        background: #EF5350;
    }
	.fs-is-disabled .ks-wrapper {
		opacity: 0.5;
    }
</style>

<script>
	// components
	import DataTable from '@components/datatable.vue';
	import PageHeader from '@components/page-header.vue';
	import ModalDialog from '@components/modal-dialog.vue';
	import PageContent from '@components/page-content.vue';
    import ToggleCheckbox from '@components/toggle-checkbox.vue';
	import EditUserModal from '@components/modal/user/edit-user.vue';
	import CreateUserModal from '@components/modal/user/create-user.vue';
	import AddUserRoleModal from '@components/modal/user/add-user-role.vue';

	// mixins
	import DateMixin from '@common/mixin/DateMixin';
	import AlertMixin from '@common/mixin/AlertMixin';
	import DataTableMixin from '@common/mixin/DataTableMixin';
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

	import { mapActions, mapGetters } from 'vuex'
    import jQuery from 'jquery';

	export default {
		components: {
			DataTable,
			PageHeader,
			PageContent,
			EditUserModal,
			AddUserRoleModal,
			CreateUserModal,
			ToggleCheckbox
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin,
			DateMixin
		],
		data() {
        	let sortOrder = {};
			let sortKey = 'user_name';
	        let columns = [
                { label: 'Enabled', key: 'can_login', sortKey: 'can_login', width: '7%', sortable: true },
                { label: 'Role', key: 'role', sortKey: 'role', width: '13%', sortable: false },
				{ label: 'Name', key: 'name', sortKey: 'name', width: '25%', sortable: false },
	            { label: 'User Name', key: 'user_name', sortKey: 'user_name', width: '11%', sortable: false },
				{ label: 'Email', key: 'email', sortKey: 'email', width: '15%', sortable: false },
                { label: 'Updated By', key: 'updated_by', sortKey: 'updated_by', width: '11', sortable: false },
                { label: 'Last Updated', key: 'updated_at', sortKey: 'updated_at', width: '10%', sortable: true },
                { label: 'Action', key: 'action', sortKey: 'action', width: '8%', sortable: false }
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
				searchPlaceholder: 'Search username/email',
				data: {
					columns:columns,
					rows: []
				},
				form: {
	                key: '',
					name: '',
					hideOtherFields: false,
	                user:{}
				},
				include: ['employee'],
				loading: false,
				changeUserEnabled: 0
			}
		},
		async created() {
		    /** This adjusts the width of search field. We cannot control it over CSS on this page
             *  as scoping is different with the datatable. */
			this.loading = true;
		    let $ = jQuery;
		    $(document).ready(function() {
		        $("div.dataTables_filter > div.flex-row > label > input#search-field").css({ 'width': '195px' });
			});
			
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			this.getData();
		},
		computed: {
            ...mapGetters({
				users:'users/data',
				meta:'users/meta',
				roles: 'roles/data',
				loggedInUser: 'auth/data'
			})
		},
		methods : {
            ...mapActions({
				getUsers: 'users/getUsers',
				saveUser: 'users/saveUser',
				getRoles: 'roles/getRoles',
				deleteUser: 'users/deleteUser',
			}),
			async getData() {
				await this.getUsers({ 
					query: _.merge(this.getParams(), { include: this.include.join(",") })
				}).then(() => {
					this.loading = false;
				});

				this.setPagination(this.meta.pagination);
			},
			getUserName(user) {
				return user.employee ? user.employee.data.name : '';
			},
			openAccessModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
			closeModal() {
				this.open = false;
			},
			paginate(page) {
				this.gotoPage(page);
				this.reload();
	        },
	        sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
				this.reload();
            },
            reload() {
				this.loading = true;
				this.getData();
		    },
	        updateList(limit) {
	            this.setPaginationLimit(limit);
				this.reload();
			},
			search(term) {
	            this.setSearch(term);
				this.reload();
			},
			openSuperAdminUserInvite(options) {
		    	this.openAccessModal(options);
			},
		    showEditDialogoue(options) {
		    	this.openAccessModal(options);
			},
			showAddUserRoleDialogue(options) {
				this.openAccessModal(options);
			},
			displayRoles(userRoles) {
				let self = this;
				let updatedRoles = [];
				let findRole = [];
				let tempRole = {};

				if(!_.isEmpty(userRoles)) {
					_.forEach(userRoles, (userRole) => {
						findRole = _.find(self.roles, (dbRoles) => {
							return dbRoles.id === userRole.role_id
						})
						
						tempRole = userRole;
						tempRole.details = findRole 
					})

					updatedRoles.push(tempRole);
				}

				return updatedRoles
			},
			async toggleCanLogin(user) {
				this.changeUserEnabled = user.id
				user.updated_by_user_id = this.loggedInUser.data.id;
				if (user.can_login) {
					user.is_verified = 1;
				}

				await this.saveUser(user);
				this.getData();
				this.changeUserEnabled = 0;
			},
			delete(userId) {
		    	return this.deleteUser(userId);
			},
			showDeleteConfirmation(userId, username, userEmail) {
	        	const title = 'Are you sure you want to delete this user';
	            const msg = `${username} ${userEmail}`;
	            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
	                .then(({ ok }) => {
	                    if (ok) this.delete(userId).then(() => {
							this.reload();
							this.notifyDialog('error', 'Successfully deleted!');
						});
	                });
			},
			disableToggle(user) {
				let currentlyLoggedUser = this.loggedInUser.data.id == user.id;
				let processingUserPermition = this.changeUserEnabled == user.id;
				return currentlyLoggedUser ? true : processingUserPermition;
			}
		}
	}
</script>
