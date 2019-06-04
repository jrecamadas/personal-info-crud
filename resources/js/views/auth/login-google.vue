<template>
    <router-view></router-view>
</template>

<script>
import OAuth from '@common/oauth/OAuth';
import { User } from '@common/model/User';
import { mapActions } from 'vuex';

export default {
    methods: {
        ...mapActions({
            setAuth : 'auth/setAuthData',
            getRoles: 'roles/getRoles',
            getLoggedInEmployee: 'employees/getLoggedInEmployee',
        }),
    },
    beforeMount() {
        OAuth.isAuthenticated().then(response => {
            if (response) {
                User.me(true).then((res) => {
                    // redirect to dashboard
                    this.setAuth(res);
                    this.getRoles({}); //this is needed for the sidebar. this needs to be loaded first before the sidebar.vue
                    this.getLoggedInEmployee({
                        user_id: res.data.id,
                        include: _.join(this.dataInclude, ',')
                    }); //this is only used during login to insert value in loggedInEmployee.
                    this.$router.push('/dashboard');
                });
            }
        })
    }
}
</script>
