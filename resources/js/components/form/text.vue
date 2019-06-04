<template>
    <div class="form-group">
        <label>
            {{label}}<span v-show="required" class="text-danger">*</span>
        </label>
        <input :id="id" class="form-control" :placeholder="placeholder" :value="value" @input="onInputChange" />
        <small v-show="helpText" class="form-text text-muted">{{helpText}}</small>
        <small v-show="error"  class="form-text text-danger">{{errorString}}</small>
    </div>
</template>

<script>

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
            error: {
                type: Boolean,
                default: false,
            },
            errorString: {
                type: String,
                default: null,
            }
        },
        methods: {
            onInputChange({ target }) {
                this.$emit('change', target.value);
            }
        },
    };

</script>
