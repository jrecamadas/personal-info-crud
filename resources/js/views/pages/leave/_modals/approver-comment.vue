<template>
    <modal-dialog v-show="openModal" :title="'Approver Comment'" @close="closeModal" :options="option">
        <template slot="body">
            <div class="row">
                <div class="col-12">
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Date: </label>
                            <span>{{ request.start_date }}</span>
                        </div>
                        <div class="col-12">
                            <label>Status: </label>
                            <span>{{ request.status }}</span>
                        </div>
                        <div class="col-12">
                            <label>Approver: </label>
                            <span>{{ request.approver.data.name }}</span>
                        </div>
                        <div class="col-12">
                            <label>Comment: </label>
                            <div v-html="request.approver_comment"></div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
    label {
        font-weight: bold;
    }
</style>

<script>
    //Components
    import ModalDialog from '@components/modal-dialog.vue';

    //Mixins
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

    export default {
        props: {
            request: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                loading: false,
                option: {
                    width: '480px',
                    height: 'auto !important',
                    bottom: 'auto',
                    overflowY: 'auto',
                    maxHeight: '680px',
                },
            };
        },
        components: {
            ModalDialog,
        },
        mixins: [
            ModalDialogMixin,
        ],
    };
</script>