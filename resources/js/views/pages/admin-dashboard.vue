<template>
    <!-- BEGIN PAGE HEADER -->
    <page-header v-bind:title="title"></page-header>
    <!-- END PAGE HEADER -->
</template>

<script>
import PageHeader from '@components/page-header.vue'

export default {
    data() {
        return {
            title: 'Dashboard'
        }
    },

    created() {
        this.$emit('pageTitle', this.title);
    },

    components:  {
        PageHeader
    }
}
</script>
