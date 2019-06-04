<template>
    <div class="ks-page">
        <span>Redirecting...</span>
    </div>
</template>

<style scoped src="../views/auth/auth.min.css">
</style>

<style type="text/css">

</style>

<script>
import jQuery from 'jquery';

export default {
    data() {
        return {}
    },
    created() {
        let $ = jQuery;
        $(document).ready(function() {
            localStorage.removeItem('vuex');
            localStorage.removeItem('auth_token');

            setTimeout(function(){
                window.open('/login', '_self');
            }, 200);
        });
    },
    methods: {

    },
    computed: {

    },
    components: {

    },
    mixins: [

    ]
}
</script>
