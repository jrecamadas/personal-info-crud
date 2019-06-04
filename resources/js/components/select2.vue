<template>
    <select class="form-control" :style="css">
        <slot></slot>
        <option
            v-for="option in options"
            :value="option.id || option.text"
            :selected="option.id == value"
        >{{ option.text }}</option>
        <slot name="bot"></slot>
    </select>
</template>

<script>
export default {
    props: {
        options: {
            type: Array,
            required: true
        },
        closeOnSelect: {
            type: Boolean,
            default: true
        },
        placeholder: {
            type: String,
            default: 'Select'
        },
        multiple: {
            type: Boolean,
            default: false
        },
        hideSearchBox: {
            type: Boolean,
            default: true
        },
        tags: {
            type: Boolean,
            default: false
        },
        css: {
            type: String,
            default: 'width: 100%'
        },
        value: [Number, String, Array]
    },
    async mounted() {
        let vm = this;
        let options = {
            closeOnSelect: this.closeOnSelect,
            placeholder: this.placeholder,
            multiple: this.multiple,
            tags: this.tags,
            width: 'resolve'
        };

        if (this.hideSearchBox) {
            options['minimumResultsForSearch'] = Infinity;
        }

        await $(vm.$el).select2(options)
            .val(this.value)
            .trigger('change')
            // emit event on change
            .change('change', function() {
                vm.$emit('select', this.value);
            });
    },
    watch: {
        value: function(value) {
            // update value
            $(this.$el)
                .val(value)
                .trigger('change');
        },
        options: function(options) {
            // update options
            $(this.$el).empty().select2({ data: options });
        }
    },
    destroyed: function() {
        $(this.$el).off().select2('destroy');
    }
}
</script>
