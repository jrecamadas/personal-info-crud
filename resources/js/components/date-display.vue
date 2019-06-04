<template>
    <span :class="displayClass">{{ date }}</span>
</template>

<script>

import moment from 'moment';

export default {
    props: {
        displayClass: {
            type: String,
            default: '',
        },
        value: {
            type: String,
            default: '',
        },
        displayType: {
            type: String,
            default: 'datetime',
        },
    },
    computed: {
        date() {
            const cond = this.displayType === 'date';
            const format = cond ? 'MMMM DD, YYYY' : 'MMMM DD, YYYY hh:mm:ss A';
            return moment(this.value).format(format);
        },
    },
};
</script>
