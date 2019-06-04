<template>
    <div class="form-group">
        <label>
            {{label}}<span v-show="required" class="text-danger">*</span>
        </label>
        <multi-select :options="options"
                      :placeholder="placeholder"
                      :track-by="config.trackBy"
                      :name="config.name"
                      :label="config.label"
                      :taggable="config.taggable"
                      :multiple="config.multiple"
                      :hideSelected="config.hideSelected"
                      :value="selectedOptions"
                      @input="onMultiSelectChange" />
        <small v-show="helpText" class="form-text text-muted">{{helpText}}</small>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>

    import MultiSelect from 'vue-multiselect';

    export default {
        props: {
            id: {
                type: String,
                required: true,
            },
            label: {
                type: String,
                required: true,
            },
            placeholder: {
                type: String,
                default: '',
            },
            options: {
                required: true,
            },
            selectedOptions: {
                required: true,
            },
            value: {
                type: String,
                default: '',
            },
            helpText: {
                type: String,
                default: null,
            },
            required: {
                type: Boolean,
                default: false,
            },
            config: {
                type: Object,
                default: {}
            },
        },
        methods: {
            onMultiSelectChange(selected) {
                this.$emit('change', selected);
            }
        },
        components: {
            MultiSelect,
        },
    };

</script>
