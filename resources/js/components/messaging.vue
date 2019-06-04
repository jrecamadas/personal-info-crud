<template>
    <span v-show="show" :class="_class">
        <slot></slot>
    </span>
</template>

<script>
export default {
    props: {
        _class: {
            type: String,
            default: 'alert alert-success'
        },
        show: {
            type: Boolean,
            default: false
        }
    }
}
</script>
