<template>
    <div class="form-group">
        <input id="touchspin" ref="touchspin" type="text" class="form-control touchspin-default" :value="value" @input="newValue($event)"/>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Number
        },
        options: {
            type: Object,
            default() {
                return {
                    initval: 5,
                    min: 1,
                    max: 10,
                    step: 1,
                    decimals: 0,
                    stepinterval: 100,
                    stepintervaldelay: 500,
                    verticalbuttons: false,
                    verticalupclass: 'la la-plus',
                    verticaldownclass: 'la la-minus',
                    prefix: '',
                    postfix: '',
                    prefix_extraclass: '',
                    postfix_extraclass: '',
                    booster: true,
                    boostat: 10,
                    maxboostedstep: false,
                    mousewheel: true,
                    buttondown_class: 'btn btn-default',
                    buttonup_class: 'btn btn-default'
                }
            }
        }
    },
    mounted() {
        let vm = this;
        $(this.$el).find('#touchspin').TouchSpin(this.options)
            .on('touchspin.on.startspin', function() {
                let val = parseInt(this.value);
                val = isNaN(val)
                      ? vm.options.min
                      : (val > vm.options.max ? vm.options.max : val);

                vm.$emit('change', val);
            });
    },
    destroyed() {
        $(this.$el).find('#touchspin').off();
    },
    methods: {
        newValue(e) {
            $(this.$el).find('#touchspin').trigger('touchspin.on.startspin');
        }
    }
}
</script>
