<template>
    <label class="ks-checkbox-switch switch-lg ks-primary" :class="{ 'fs-is-disabled': isDisabled }">
        <input type="checkbox" v-model="value" :disabled="isDisabled">
        <span class="ks-wrapper"></span>
        <span class="ks-indicator"></span>
        <!-- This is the on / off choices -->
        <span v-for="(stat, i) in sortStatus" :key="i" :class="klass(stat.isOn)">{{ stat.label }}</span>
    </label>
</template>

<style lang="scss" scoped>
// small-toggle
    .short-toggle.ks-checkbox-switch > .ks-wrapper {
        width: 4rem!important;
    }
    .short-toggle.ks-checkbox-switch > .ks-on,
    .short-toggle.ks-checkbox-switch > .ks-off {
        width: 3rem!important;
    }
    .short-toggle.ks-checkbox-switch input[type=checkbox]:checked + .ks-wrapper + .ks-indicator {
        left: 2.7rem!important;
    }
// default-toggle
    .medium-toggle.ks-checkbox-switch > .ks-wrapper,
    .ks-checkbox-switch > .ks-wrapper {
        width: 6rem;
        background: #EF5350;
    }
    .medium-toggle.ks-checkbox-switch > .ks-on,
    .medium-toggle.ks-checkbox-switch > .ks-off,
    .ks-checkbox-switch > .ks-on,
    .ks-checkbox-switch > .ks-off {
        width: 5rem;
        text-align: center;
    }
    .medium-toggle.ks-checkbox-switch > .ks-off,
    .ks-checkbox-switch > .ks-off {
        left: 1rem;
    }
    .ks-checkbox-switch > .ks-on,
    .medium-toggle.ks-checkbox-switch > .ks-on {
        left: 0;
    }
    .medium-toggle.ks-checkbox-switch input[type=checkbox]:checked + .ks-wrapper + .ks-indicator,
    .ks-checkbox-switch input[type=checkbox]:checked + .ks-wrapper + .ks-indicator {
        left: 4.7rem;
    }
// long-toggle
    .long-toggle.ks-checkbox-switch > .ks-wrapper {
        width: 9rem!important;
    }
    .long-toggle.ks-checkbox-switch > .ks-on,
    .long-toggle.ks-checkbox-switch > .ks-off {
        width: 8rem!important;
    }
    .long-toggle.ks-checkbox-switch input[type=checkbox]:checked + .ks-wrapper + .ks-indicator {
        left: 7.7rem!important;
    }
    .fs-is-disabled .ks-wrapper {
        opacity: 0.5;
    }
</style>

<script>
    import _ from 'lodash';
    
    export default {
        props: {
            // this is the list of statuses, and it's default value when not assigned
            status: {
                type: Array,
                default: [
                    { label: "ON", value: 1, isOn: true },
                    { label: "OFF", value: 0, isOn: false }                 
                ]
            },
            // byDefault is used if you need to set default, but if not set- toggle is OFF
            byDefault: {
                type: Object,
                default: function() { return {} }
            },
            // this is to set if toggle is disabled
            isDisabled: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                value: this.setDefault(this.byDefault),
                tempDefault: false
            }
        },
        watch: {
            value: function(data) {
                // this is a toggle event sending value to parent component
                let status = _.find(this.status, function(stats) { return stats.isOn === data });
                this.$emit('change', status.value);
            },
            byDefault: function(info) {
                // this is when in parent component there is a change to the default value
                this.value = this.setDefault(this.byDefault);
            }
        },
        methods: {
            klass(isOn) {
                // this is for classes bases only, but required
                return isOn ? 'ks-on' : 'ks-off';
            },
            setDefault(def) {
                // this is finding default value within choices. Make sure default value is same element as any of the choices
                let finalDefault = this.tempDefault;
                if(!this.isEmpty(def)) {
                    let findDefault = _.filter(this.status, def);
                    let statusDefault = _.head(findDefault);
                    finalDefault = _.isUndefined(statusDefault) ? false : statusDefault.isOn;
                }
                
                return finalDefault;
            },
            isEmpty(obj) {
                for(var key in obj) {
                    if(obj.hasOwnProperty(key)) {
                        return false;
                    }
                }
                
                return true;
            }
        },
        computed: {
            sortStatus() {
                // this will sort status, setting status with isOn=true first
                return this.status.sort(function(a, b) { return b.isOn - a.isOn })             
            }
        },
        mounted() {
            // this triggers to set parent component dynamic default
            // false here is by default as off switch
            const temp = _.find(this.status, function(stats) { return stats.isOn === false });
            let toParentDefault = this.isEmpty(this.byDefault) ? temp.value : this.byDefault.value;
            this.$emit('change', toParentDefault);
        }
    }
</script>