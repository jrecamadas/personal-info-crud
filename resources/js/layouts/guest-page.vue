<template>
    <router-view></router-view>
</template>

<script>
import LoaderMixin from '@common/mixin/LoaderMixin';

export default {
    mounted() {
        this.hideLoader();
    },
    mixins: [
        LoaderMixin
    ]
}
</script>
