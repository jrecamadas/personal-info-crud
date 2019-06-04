<template>
    <div class="popover" :id="popoverId">
        <div class="popover-heading">
            <slot name="header">
                This is the header
            </slot>
        </div>

        <div class="popover-body">
            <slot name="body">
                This is the body
            </slot>
        </div>
    </div>
</template>

<style scoped>
.popover {
    display: none;
}

</style>

<script>
export default {
    props: {
        popoverId: {
            required: true
        }
    },
    methods: {
        
    }
}
</script>
