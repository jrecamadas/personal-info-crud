<template>
    <!-- BEGIN-HEADER -->
    <nav class="navbar ks-navbar">
        <!-- BEGIN HEADER INNER -->
        <!-- BEGIN LOGO -->
        <div class="navbar-brand">
            <!-- BEGIN RESPONSIVE SIDEBAR TOGGLER -->
            <a href="#" class="ks-sidebar-toggle">
                <i class="ks-icon la la-bars" aria-hiden="true"></i>
            </a>
            <a href="#" class="ks-sidebar-mobile-toggle">
                <i class="ks-icon la la-bars" aria-hidden="true"></i>
            </a>
            <!-- END RESPONSIVE SIDEBAR TOGGLER -->
            <div class="ks-navbar-logo">
                <router-link to="/" class="ks-logo"><img :src="fullScaleLogo" :alt="organizationShortNameAllCaps" class="comp-logo" /></router-link>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN MENUS -->
        <div class="ks-wrapper">
            <nav class="nav navbar-nav">
                <!-- BEGIN NAVBAR MENU -->
                <div class="ks-navbar-menu">
                    
                </div>
                <!-- END NAVBAR MENU -->
                <!-- BEGIN NAVBAR ACTIONS -->
                <div class="ks-navbar-actions">
                    <Can I="view" a="employee_search_bar">
                        <search-form></search-form>
                    </Can>
                    <!-- BEGIN NAVBAR MESSAGES -->
                   <!--  <navbar-messages></navbar-messages> -->
                    <!-- END NAVBAR MESSAGES -->
                    <!-- BEGIN NAVBAR NOTIFICATIONS -->
                   <!--  <navbar-notifications></navbar-notifications> -->
                    <!-- END NAVBAR NOTIFICATIONS -->
                    <!-- BEGIN NAVBAR USER -->
                    <navbar-user></navbar-user>
                    <!-- END NAVBAR USER -->
                </div>
                <!-- END NAVBAR ACTIONS -->
            </nav>
        </div>
        <!-- END MENUS -->
        <!-- END HEADER INNER -->
    </nav>
    <!-- END HEADER -->
</template>

<style lang="scss" scoped>
    .ks-navbar-actions {
        padding-right: 20px !important;
    }
    .comp-logo {
        width: 108px;
    }
</style>

<script>
    import SearchForm from '@components/search-form.vue'
    import NavbarMessages from '@components/navbar-messages.vue'
    import NavbarNotifications from '@components/navbar-notifications.vue'
    import NavbarUser from '@components/navbar-user.vue'
    import { mapGetters } from 'vuex';

    export default {
        components: {
            SearchForm,
            NavbarMessages,
            NavbarNotifications,
            NavbarUser
        },
        mounted() {
            let commonJs = document.createElement('script');
            commonJs.setAttribute('src', '/js/common.min.js?r=' + (new Date().getTime()));
            commonJs.defer = true;
            document.body.appendChild(commonJs);
        },
        computed : {
            ...mapGetters({
                organizationShortNameAllCaps: 'appSettings/getShortNameTextAllCaps',
                fullScaleLogo: 'appSettings/getFullScaleLogo',
            }),
        }
    }
</script>

