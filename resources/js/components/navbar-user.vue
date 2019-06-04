<template>
    <div class="nav-item dropdown ks-user">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="ks-avatar">
                <img :src="employeeAvatar" width="36" height="36">
            </span>
            <span class="ks-info">
                <span class="ks-name">{{employeeFirstname}}</span>
                <span class="ks-description"></span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
            <router-link v-if="employeeId" v-bind:to="getProfileLink()" class="dropdown-item">
                <span class="ks-icon la la-user"></span>
                <span>My Profile</span>
            </router-link>
            <a class="dropdown-item" @click="openAccessModal({key: 'change-pass', name: 'Change Password', id: loggedInUser.data.id})" href="#">
                <span class="ks-icon la la-cog"></span>
                <span>Change Password</span>
            </a>

            <!-- <a class="dropdown-item" href="#">
                <span class="la la-wrench ks-icon" aria-hidden="true"></span>
                <span>Settings</span>
            </a>
            <a class="dropdown-item" href="#">
                <span class="la la-question-circle ks-icon" aria-hidden="true"></span>
                <span>Help</span>
            </a> -->

            <a class="dropdown-item" href="#" @click.prevent="logout">
                <span class="la la-sign-out ks-icon" aria-hidden="true"></span>
                <span>Logout</span>
            </a>
        </div>
        <change-pass-modal v-if="form.key == 'change-pass' && open" :openModal="open" @success="updateChange" @close="closeModal" :info="form"></change-pass-modal>
    </div>
</template>
<style>
    .dropdown-item.active {
        background-color: transparent;
    }
    .dropdown-item.router-link-exact-active.active {
        background-color: #dedbdc;
    }
</style>
<script>
    import OAuth from '@common/oauth/OAuth';
    import EmployeeMixin from "@common/mixin/EmployeeMixin";

    import ChangePassModal from '@views/pages/users/_modals/change-pass.vue'

    import { mapActions, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                open: false,
                employeeId: '',
                employeeFirstname: this.employeeFirstname,
                employeeAvatar: this.employeeAvatar,
                include: [
                    "photo"
                ],
                form: {
	                key: '',
                    name: '',
                    id: ''
                },
                isChanged: false
            }
        },
        computed: {
            ...mapGetters({
                loggedInUser: 'auth/data', //get logged in user data
                employee: 'employees/user',
                employeeGlobal: 'employees/single'
            })
        },
        watch: {
            employeeGlobal: function(value){
                if(value && value.user && value.user.data && this.loggedInUser && this.loggedInUser.data){
                    if(this.loggedInUser.data.id == value.user.data.id){
                        this.employeeAvatar = this.photo(value);
                    }
                }
            }
        },
        created() {
            this.loggedInUser;
            this.getData();
        },
        methods: {
            ...mapActions({
                getEmployee: 'employees/getUserEmployee'
            }),
            async getData(){
                await this.getEmployee({
                    user_id: this.loggedInUser.data.id,
                    include: this.include.join(",")
                });

                this.employeeFirstname = this.loggedInUser.data.user_name;
                this.employeeAvatar = '/assets/img/avatars/male.png';

                let employeeArray = Object.keys(this.employee).map(i => this.employee[i]);

                if(!this.employee || (employeeArray && employeeArray.length <= 0)){ //if user is not an employee
                    return false;
                }

                this.employeeId = employeeArray[0].id;
                this.employeeFirstname = employeeArray[0].first_name;

                /** Mike 02112019 - We need to use the enhanced logic how to decide which photo needs to be used **/
                this.employeeAvatar = this.photo(this.employee[0]);
            },
            getProfileLink(){
                return '/my/' + this.employeeId + '/profile';
            },
            updateChange() {
                this.isChanged = true;
            },
            closeModal() {
                this.open = false;
                if(this.isChanged) {
                    this.isChanged = false;
                    this.logout();
                }
            },
            logout() {
                OAuth.logout().then(() => {
                    localStorage.removeItem('rules');
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('vuex');

                    try{
                        window.location.href = '/login';
                    }catch(e){
                        this.$router.replace('/login');
                    }
                });
            },
            openAccessModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
        },
        mixins: [
            EmployeeMixin
        ],
        components: {
            ChangePassModal
        }
    }
</script>
