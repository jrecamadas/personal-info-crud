<template>
    <div style="text-align: center">
        <div class="ks-error-code">404</div>
        <div class="ks-error-description">
            Sorry, but this page doesn't exists
        </div>
        <router-link to="/" class="btn btn-primary ks-light">Go to the main page</router-link>
    </div>
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
