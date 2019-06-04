<template>
    <select
        v-model="selectedOption"
        class="form-control"
        @input="event => { $emit('input', event.target.value) }"
        :style="css">
        <slot name="top"></slot>
        <!-- Option data will be propagate in select2 instance -->
        <slot name="bottom"></slot>
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
            default: false
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
    data() {
        return {
            selectedOption: this.value,
            confOpts: {},
        }
    },
    async mounted() {
        let vm = this;
        let options = {
            closeOnSelect: this.closeOnSelect,
            placeholder: this.placeholder,
            multiple: this.multiple,
            tags: this.tags,
            width: 'resolve',
            data: this.options
        };

        if (this.hideSearchBox) {
            options['minimumResultsForSearch'] = Infinity;
        }
        this.confOpts = options;

        // Setup Select2 instance
        await $(vm.$el).select2(options)
            .val(this.value)
            .trigger('change')
            // Emit event on change
            .change('change', function() {
                vm.$emit('select', this.value);
            });
    },
    watch: {
        value: function(value) {
            // Update Select2 value
            $(this.$el).val(value).trigger('change');
        },
        options: function(options) {
            // Select2 Update options
            this.confOpts.data = options;
            $(this.$el).empty()
                .select2(this.confOpts)
                .val(this.value)
                .trigger('change');
        }
    },
    destroyed: function() {
        // Destroy Select2 instance
        $(this.$el).off().select2('destroy')
    }
}
</script>
