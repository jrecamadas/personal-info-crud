<template>
    <div class="ks-column ks-sidebar ks-info">
        <div class="ks-wrapper ks-sidebar-wrapper">               
            <!-- BEGIN MENU -->
            <ul class="nav nav-pills nav-stacked" v-if="menuItems">
                <li class="nav-item dropdown" v-for="menuItem in menuItems" :key="menuItem.key">
                    {{ menuItem.can_access }}
                    <router-link v-if="setAbility(menuItem.resource)" :data-log="getRoutePath(menuItem)" :to="{name: getRoutePath(menuItem)}" :class="menuItemClass(menuItem)" role="button" aria-haspopup="true" aria-expanded="false">
                        <span :class="menuIcon(menuItem.icon)"></span>
                        <span>{{ menuItem.label }}</span>
                    </router-link>
                    <!-- SUB MENU ITEMS -->
                    <div class="dropdown-menu" v-if="menuItem.children">
                        <div v-for="sub in menuItem.children" :key="sub.key">
                            <router-link v-if="setAbility(sub.resource)" :data-log="getRoutePath(sub)" :to="{name: getRoutePath(sub)}" class="dropdown-item" role="button" aria-haspopup="true" aria-expanded="false">
                                <span v-if="sub.icon" :class="menuIcon(sub.icon)"></span>
                                <span>{{ sub.label }}</span>
                            </router-link>
                        </div>
                    </div>
                    <!-- END SUB MENU ITEMS -->
                </li>
            </ul>
            <!-- END MENU -->
        </div>
    </div>

</template>

<style scoped>
.open .active{
    color: #fff!important;
}
.ks-wrapper.ks-sidebar-wrapper {
    width: 260px !important;
}
</style>


<script>

import OAuth from '@common/oauth/OAuth';
import menuItems from '@common/var/menu/superadmin';
import _ from 'lodash';
import { mapActions, mapGetters } from 'vuex';
import ObjectMixinHelpers from '@common/mixin/ObjectHelperMixin';
import { ability } from "@common/oauth/ability.js";

export default {
    data() {
        return {
            listItems: {
                employees: ['employees', 'positions', 'skills'],
                resource_allocation: ['resource_allocation'],
                client_management: ['client_management'],
                applicants: ['applicants'],
                reports: ['daily_report_list']
            },
            // isAdmin:true,
            menuItems: null
        }
    },
    mounted() {
        const ref = this.$route.name;
        if (this.$refs[ref]) {
            this.$refs[ref].click();
        }
    },
    created() {
        // this.getEmployee({user_id:this.loggedInUser.data.id});
        this.initMenuItems();
    },
    computed: {
        ...mapGetters({
            loggedInUser: 'auth/data',
            roles: 'roles/data',
            employee: 'employees/single'
        }),
        menuIcon: function() {
            return (icon) => {
                return {
                    ['ks-icon']: true,
                    'la': true,
                    [`${icon}`]: true
                };
            };
        },
        menuItemClass: function() {
            return (menuItem) => {
                return {
                    'nav-link': true,
                    'dropdown-toggle': menuItem.children
                };
            };
        },
        isLoggedInUserAdmin() {
            if (this.isUserAdmin(this.loggedInUser)) {
                return true;
            }
            return false;
        },
        state: function() {
            return (ref) => _.includes(this.listItems[ref], this.$route.name) ? 'open' : '';
        },
        loggedInUserRole() {
            return _.find(this.roles, (item) => {
                return this.loggedInUser.data.role.data.role_id === item.id;
            });
        },
        // isAdmin() {
        //   return this.loggedInUserRole && this.loggedInUserRole.name === 'admin';
        // },
        // isUser() {
        //   return this.loggedInUserRole && this.loggedInUserRole.name === 'user';
        // },
        // isSuperAdmin() {
        //   return this.loggedInUserRole && this.loggedInUserRole.name === 'superadmin';
        // },
    },
    methods: {
        ...mapActions({
            getEmployee: 'employees/getEmployee'
        }),
        getRoutePath(menuItem) {
            return menuItem.children ? '' : menuItem.key;
        },
        getState(dropdown){
            let state = '';
            this.sidebar.dropdowns.every(function(obj) {
                if (obj.item == dropdown){
                    state = obj.state;
                    return false;
                } else {
                    return true;
                }
            });
            return state;
        },
        toggleDropdown(dropdown = '') {
            this.$router.push(this.$refs[`${dropdown}_default`].to);
        },
        forceLogout(){
            top.window.open('/applicant','_blank');
            setTimeout(function(){
                OAuth.logout().then(() => {
                    this.$router.push("/login");
                });
            }, 500);
        },
        restrictItems(resource, list) {
            let items = list;
            if(this.isUserAdmin(this.loggedInUser)){
                items.forEach(function(element, index){
                    if(element.resource == resource){
                        items.splice(index, 1);
                    }
                });
            }
            return items;
        },
        initMenuItems() {
            let finalMenuItems = this.restrictItems('daily_report', menuItems);
            this.menuItems = finalMenuItems;
        },
        setAbility(resource) {
            return (resource) ? ability.can('view', resource) : true;
        }
    },
    mixins: [
        ObjectMixinHelpers
    ]
}
</script>
