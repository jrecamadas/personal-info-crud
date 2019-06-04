<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
			<div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid user-permissions">
                        <h3>{{ user.user_name }} ({{ user.email }})</h3>
                        <div class="fs-accordion" v-for="user_role in userRole" :key="user_role.id">
                            <div class="card panel panel-default ks-information ks-light">
                                <div class="card-header" @click.stop="toggleAccordion">
                                    <h4 class="ks-text">
                                        <a href="#" class="action-button" title="Delete User Role" @click="showDeleteConfirmation(user_role)">
                                            <i class="la la-trash"></i>
                                        </a>{{ roleName(user_role.role_id) }}
                                    </h4>
                                    <label class="ks-checkbox-switch ks-primary">
                                        <input type="checkbox" v-model="user_role.is_enabled" @change="toggleRole(user_role)">
                                        <span class="ks-wrapper"></span>
                                        <span class="ks-indicator"></span>
                                        <span class="ks-on">On</span>
                                        <span class="ks-off">Off</span>
                                    </label>
                                </div>
                            </div>

                            <div v-if="user_role.is_enabled" class="card-block fs-accordion-content" id="user_role.id">
                                <data-table
                                    :columns="data.columns"
                                    :showFilter="false"
                                    :showSearch="false"
                                    :showPagination="false"
                                >
                                    <tbody v-if="resource.length">
                                        <tr
                                            v-for="(permission, index) in resource"
                                            :key="index"
                                            v-if="permission.role_id == user_role.role_id"
                                        >
                                            <td>{{ permission.resource_name }}</td>
                                            <td class="text-center">
                                                <span class="custom-control custom-checkbox">
                                                    <input type="checkbox" v-model="permission.can_view" :name="'view_'+index+'_'+permission.id" :id="'view_'+index+'_'+permission.id" class="custom-control-input" @change="triggerCheckboxPermission(permission)"/>
                                                    <label :for="'view_'+index+'_'+permission.id" class="custom-control-label"></label>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="custom-control custom-checkbox">
                                                    <input :disabled="!hasPermission(permission)" type="checkbox" v-model="permission.can_add" :name="'add_'+index+'_'+permission.id" :id="'add_'+index+'_'+permission.id" class="custom-control-input" @change="triggerCheckboxPermission(permission)"/>
                                                    <label :for="'add_'+index+'_'+permission.id" class="custom-control-label"></label>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="custom-control custom-checkbox">
                                                    <input :disabled="!hasPermission(permission)" type="checkbox" v-model="permission.can_edit" :name="'edit_'+index+'_'+permission.id" :id="'edit_'+index+'_'+permission.id" class="custom-control-input" @change="triggerCheckboxPermission(permission)"/>
                                                    <label :for="'edit_'+index+'_'+permission.id" class="custom-control-label"></label>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="custom-control custom-checkbox">
                                                    <input :disabled="!hasPermission(permission)" type="checkbox" v-model="permission.can_delete" :name="'delete_'+index+'_'+permission.id" :id="'delete_'+index+'_'+permission.id" class="custom-control-input" @change="triggerCheckboxPermission(permission)"/>
                                                    <label :for="'delete_'+index+'_'+permission.id" class="custom-control-label"></label>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </data-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</page-content>
	</div>
</template>

<style scoped>
    .fs-accordion {
        padding: 0 0 15px;
    }
    .fs-accordion .card.panel .card-header .ks-text {
        color: white;
    }
    .fs-accordion .card.panel .card-header {
        background-color: #008240;
    }
    .fs-accordion .fs-accordion-content {
        padding: 0 !important;
    }
    .fs-accordion .fs-accordion-content::-webkit-scrollbar {
        width: 8px;
    }
    .fs-accordion .fs-accordion-content::-webkit-scrollbar-thumb {
        background-color: #e2e2e2;
        outline: 1px solid slategrey;
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
    .table-striped tbody tr:nth-child(odd){
        background-color: #ffffff;
    }
    .table-striped tbody tr:nth-child(even){
        background-color: #ededed;
    }
    div.dataTables_wrapper table.dataTable.table-bordered td, 
    div.dataTables_wrapper table.dataTable.table-bordered th {
        border: 0!important;
    }
    .fs-accordion {
        padding: 0!important;
        margin-top: 10px;
    }
    h3 {
        margin-bottom: 20px;
    }
    .action-button {
        color: white;
        margin-right: 10px;
    }
</style>
<style>
    .user-permissions div.dataTables_wrapper table.dataTable.table-bordered th {
        border: 0;
        border-bottom: solid 1px #dddfe0;
    }
    .user-permissions div.dataTables_wrapper table.dataTable.table-bordered th:not(:first-child) {
        text-align: center;
    }
</style>
<script>
	import _ from 'lodash';

    //Components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
	import DataTable from '@components/datatable.vue'
	import Select2 from '@components/select2.vue';

    import AccordionMixin from '@common/mixin/AccordionMixin';
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    
    import { Validator } from 'vee-validate';
	import { mapActions, mapGetters } from 'vuex';

	export default {
		data() {
            let columns = [
                { label: 'Permission', key: 'permission', sortKey: 'permission', width: '40%' },
                { label: 'View', key: 'view', sortKey: 'view', width: '15%' },
	            { label: 'Add', key: 'add', sortKey: 'add', width: '15%'},
                { label: 'Edit', key: 'edit', sortKey: 'edit', width: '15%'},
                { label: 'Delete', key: 'delete', sortKey: 'delete', width: '15%'},
	        ];
			return {
                title:'Edit Permissions',
				pageClass: 'ks-content-nav',
                data: {
					columns:columns,
					rows: []
                },
                resource: [],
                userRoleIncludes: [
                    'role',
					'permissions'
                ],
                isDisabled: false,
                include: ['employee']
	        }
		},
		computed: {
			...mapGetters({
                userRole: 'userRoles/role',
                user: 'users/user',
                role: 'roles/role',
                resources: 'resources/data',
                userRolePermissions: 'userRolePermissions/data',
                roles: 'roles/data',
                loggedInUser: 'auth/data'
            }),
            hasPermission: function() {
				return permission => permission.can_view == 1;
			},
		},
		async created() {
            var self = this;
            await this.fetchUser(this.$route.params.id);
            await this.getUserRole({
                user_id: this.$route.params.id,
                include: this.userRoleIncludes.join(",")
            });
            this.fetchRole(this.userRole);
            await this.getResources({query: {take: 9999}});
            await this.getUserRolePermissions({});
            this.pushInitialData(this.resources);
            this.role.unshift({ id:0, text: 'Select Role...' });
        },
		methods: {
			...mapActions({
                getRoles: 'roles/getRoles',
                fetchUser: 'users/getUser',
                saveUser: 'users/saveUser',
                checkUsername :'users/checkUsername',
                checkEmail :'users/checkEmail',
                getUserRole: 'userRoles/getUserRole',
                fetchRole: 'roles/fetchRole',
                getResources: 'resources/getResources',
                getUserRolePermissions: 'userRolePermissions/getUserRolePermissions',
                saveUserRolePermission: 'userRolePermissions/saveUserRolePermission',
                saveUserRole: 'userRoles/saveUserRole',
                deleteUserRole: 'userRoles/deleteUserRole',
            }),
            roleName(roleId){
                let display_name;
                this.roles.forEach(element => {
                    if(element.id == roleId){
                        display_name = element.display_name
                    }
                });
                return display_name;
            },
            pushInitialData(array){
                _.each(array, (element) => {
                    _.each(this.userRole, (userRole) => {
                        this.resource.push({
                            id:'',
                            can_add: 0, 
                            can_edit: 0, 
                            can_view: 0,
                            can_delete: 0,
                            resource_id: element.id, 
                            user_role_id: userRole.id,
                            resource_name: element.display_name,
                            role_id: userRole.role_id
                        })
                        _.each(userRole.permissions.data, (permission) => {
                            _.each(this.resource, (resource) => {
                                if( resource.resource_id == permission.resource_id && 
                                    resource.user_role_id == permission.user_role_id
                                ) {
                                    resource.id = permission.id
                                    resource.can_add = permission.can_add;
                                    resource.can_edit = permission.can_edit
                                    resource.can_view = permission.can_view
                                    resource.can_delete = permission.can_delete
                                }
                            });
                        });
                    });
                });
            },
            triggerCheckboxPermission(permission){
                if (permission.can_view == 0) {
					permission.can_add = 0;
					permission.can_edit = 0;
					permission.can_delete = 0;
                }
                this.isDisabled = true;
                this.saveUserRolePermission(permission).then((res) => {
                    permission.id = res.data.id;
                    this.isDisabled = false;
                })
                this.saveUpdatedById();
            },
            toggleRole(role){
                _.each(this.userRole, userRole => {
                    if(userRole.id !== role.id && userRole.is_enabled == 1){
                        userRole.is_enabled = 0;
                        this.saveUserRole(userRole);
                    }
                })
                this.saveUserRole(role);
                this.saveUpdatedById();
            },
            saveUpdatedById(){
                this.user.updated_by_user_id = this.loggedInUser.data.id;
                this.saveUser(this.user);
            },
            getUserName(user){
				return user.employee ? user.employee.data.name : '';
            },
            delete(userRoleId) {
		    	return this.deleteUserRole(userRoleId);
            },
            async reload() {
		    	await this.getUserRole({
                    user_id: this.$route.params.id,
                    include: this.userRoleIncludes.join(",")
                });
		    },
            showDeleteConfirmation(userRole) {
                const title = 'Are you sure you want to delete this user role?';
                const msg = `This will also delete its permission`;
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                    .then(({ok}) => {
                        if (ok)
                            if(userRole.is_enabled == true){
                                userRole.is_enabled = 0;
                                this.saveUserRole(userRole);
                            }
                            this.delete(userRole.id).then(() => this.reload());
                    });
		    }
		},
		components: {
	        GenerateButton,
	        SaveButton,
	        ModalDialog,
            Select2,
            DataTable,
            PageHeader,
            PageContent
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
            StringHelperMixin,
            AccordionMixin,
            AlertMixin
	    ]
	}
</script>
