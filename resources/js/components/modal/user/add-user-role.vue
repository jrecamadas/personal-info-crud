<template>
    <modal-dialog v-show="openModal" :closeButtonText="'Close'" :options="option" :title="info.name" @close="closeModal" :closeIsDisabled="isDisabled">
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <template v-if="info.user.employee">
                        <h5>{{ info.user.employee.data.employee_no }} - {{ info.user.employee.data.name }}</h5>
                    </template>
                    <!-- BEGIN USER ROLE -->
                    <ul class="user-role-wrapper" v-if="roleList.length">
                        <li 
                            v-for="(role, index) in roleList" 
                            :key="index"
                            :class="index % 2 == 0 ? 'even' : 'odd'"
                        >
                            <span>{{ role.display_name }}</span>
                            <label class="ks-checkbox-switch ks-primary">
                                <input type="checkbox" v-model="role.is_enabled" @change="toggleUserRole(role, index)">
                                <span class="ks-wrapper"></span>
                                <span class="ks-indicator"></span>
                                <span class="ks-on">On</span>
                                <span class="ks-off">Off</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped lang="scss">
    ul.user-role-wrapper {
        list-style-type: none;
        margin: 0;
        margin-top: 15px;
        padding: 0;
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 5px;
            &.odd {
                background-color: #f5f6fa;
            }
        }
    }
</style>

<script>
    //components
	import AddButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';

	//mixins
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    
    import { mapActions, mapGetters } from 'vuex'
    
    export default {
        props: {
			info: { type: Object, required: true }
		},
        data() {
            let sortOrder = {};
			let sortKey = 'permission';
			let columns = [
				{ label: 'Role', key: 'role', width: '40%', sortable: false},
				{ label: 'View', key: 'delete', width: '15%', sortable: false, text_align: 'text-center' },
				{ label: 'Add', key: 'add', width: '15%', sortable: false, text_align: 'text-center' },
				{ label: 'Edit', key: 'edit', width: '15%', sortable: false, text_align: 'text-center' },
				{ label: 'Delete', key: 'view', width: '15%', sortable: false, text_align: 'text-center' }
			];
			
			columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'asc'
            });
            
            return {
                option: { height: 'auto', width: '500px', bottom: 'auto' },
                button: { class: 'btn btn-primary', type: 'button' },
                loading: false,
                userRoles: [],
                isDisabled: false,
                userRoleId: '',
                roleList: []
            }
        },
        async created() {
            await this.fetchUser(this.info.user.id);
            await this.getRoles();
            this.initUserRoles();
        },
        computed: {
            ...mapGetters({
                user: 'users/user',
				roles: 'roles/role',
                loggedInUser: 'auth/data',
                roleData: 'roles/data',
                userRole: 'userRoles/role'
            })
        },
        methods: {
            ...mapActions({
                fetchUser: 'users/getUser',
                getRoles: 'roles/getRole',
                addUserRole: 'userRoles/saveUserRole',
                saveUserRolePermission: 'userRolePermissions/saveUserRolePermission',
                saveUser: 'users/saveUser',
                getUserRole: 'userRoles/getUserRole',
                deleteUserRole: 'userRoles/deleteUserRole'
            }),
            initUserRoles() {
                let active, toggled = 0;
                if(this.user.roles.data){
                    _.each(this.user.roles.data, userRole => {
                        if(userRole.is_enabled){
                            active = userRole
                        }
                    })
                }
                _.each(this.roleData, role => {
                    if(active){
                        role.id == active.role_id ? toggled = 1 : toggled = 0
                    }
                    this.roleList.push({
                        id: role.id,
                        display_name: role.display_name,
                        is_enabled: toggled,
                    });
                });
            },
            saveDefaultUserRolePermission(permission){
                _.each(this.roles, (role) => {
                    if(role.id == permission.id){
                        _.each(role.permissions.data, (element) => {
                            this.saveUserRolePermission({
                                id:'',
                                can_add: element.can_add,
                                can_delete: element.can_delete,
                                can_edit: element.can_edit,
                                can_view: element.can_view,
                                resource_id: element.resource_id,
                                user_role_id: this.userRoleId,
                            })
                        })
                    }
                })
            },
            async toggleUserRole(userRole, index) {
                this.isDisabled = true;

                await this.getUserRole({
                    user_id: this.info.user.id,
                })
                if(this.roleList[this.roleList.findIndex(x => (x.is_enabled == 1) && x != userRole)])
                    this.roleList[this.roleList.findIndex(x => (x.is_enabled == 1) && x != userRole)].is_enabled = 0
                
                _.each(this.userRole, user => {
                    this.deleteUserRole(user.id).then((res) => {
                        this.isDisabled = false;

                        this.$emit('success');
                    })
                })
                if(userRole.is_enabled) {
                    this.addUserRole({
                        is_enabled: userRole.is_enabled, 
                        user_id: this.info.user.id, 
                        role_id: userRole.id 
                    }).then((res) => {
                        this.userRoleId = res.data.id;
                        this.isDisabled = false;

                        this.$emit('success');
                        this.saveDefaultUserRolePermission(userRole);
                    })
                }
                this.saveUpdatedById()
            },
            saveUpdatedById(){
                this.user.updated_by_user_id = this.loggedInUser.data.id;
                this.saveUser(this.user);
            },
        },
        components: {
            AddButton,
            ModalDialog
        },
        mixins: [
            ModalDialogMixin
        ]
    }
</script>