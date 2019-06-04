<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <textarea class="form-control" placeholder="About Me" v-model="summary"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <footer class="dialog-footer">
                    <button type="button" class="btn btn-danger" @click="$emit('close')" :disabled="loading">Cancel</button>
                    <save-button :loading="loading" :options="button" :disabled="isEmpty(summary)" @action="save">
                        Save
                    </save-button>
                </footer>
            </div>
        </div>
    </div>
</template>

<style scoped>
textarea {
    min-height: 200px;
}
.row {
    margin-top: 0 !important;
}
</style>
<script>
import SaveButton from '@components/form/button.vue';
import StringHelperMixin from '@common/mixin/StringHelperMixin';

export default {
    props: {
        info: {
            type: Object,
            required: true
        },
        modal: {
            type: Object,
            default: function() {
                return {
                    width: '800px',
                    height: '400px'
                }
            }
        }
    },
    data() {
        return {
            summary: '',
            loading: false,
            button: {
                class: 'btn btn-primary',
                type: 'button'
            }
        }
    },
    methods: {
        save() {
            this.loading = true;

            this.info.save({
                summary: this.summary
            }).then((res) => {
                this.loading = false;
                // emit event and pass the response
                this.$emit('success', res.data);
            });
        }
    },
    created() {
        this.summary = this.info.summary;

        // adjust modal height
        this.modal.height = '370px';
    },
    mixins: [
        StringHelperMixin
    ],
    components: {
        SaveButton
    }
}
</script>
