<template>
    <div id="main-wrapper">
        <app-header></app-header>
        <vue-snotify></vue-snotify>
        <div class="ks-page-container ks-dashboard-tabbed-sidebar-fixed-tabs">
            <!-- BEGIN DEFAULT SIDEBAR -->
            <app-sidebar></app-sidebar>
            <!-- END DEFAULT SIDEBAR -->
            <!-- BEGIN PAGE -->
            <div class="ks-column ks-page">
                <router-view></router-view>
            </div>
            <!-- END PAGE -->
        </div>
    </div>
</template>

<script>
    import AppHeader from '@layouts/header.vue'
    import AppSidebar from '@layouts/sidebar.vue'

    export default {
        components: {
            AppHeader,
            AppSidebar
        }
    }
</script>
