<template>
    <button :type="options.type" :class="options.class" :style="'width:' + options.width" :disabled="loading || disabled" @click="$emit('action')">
        <i v-show="loading" class="fa fa-spinner fa-spin"></i>
        <span v-show="!loading">
            <slot></slot>
        </span>
    </button>
</template>

<script>
export default {
    props: {
        disabled: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        },
        options: {
            type: Object,
            default() {
                return {
                    class: 'btn btn-primary',
                    width: '120px',
                    type: 'button'
                }
            }
        }
    }
}
</script>
