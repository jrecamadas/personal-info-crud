<template>
    <transition name="modal-fade">
        <div class="modal-backdrop">
            <div class="modal" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription" :style="modalStyle">
                <!-- BEGIN MODAL HEADER -->
                <header class="modal-header" id="modalTitle">
                    <h4>{{ title }}</h4>
                    <span>
                        <button type="button" class="btn btn-danger" @click="close" area-label="Close Modal" :disabled="closeIsDisabled">{{ closeButtonText }}</button>
                        &nbsp;
                        <slot name="button"></slot>
                    </span>
                </header>
                <!-- END MODAL HEADER -->

                <!-- BEGIN MODAL BODY -->
                <section class="modal-body" id="modalDescription">
                    <slot name="body">
                        I'm the default body!
                    </slot>
                </section>
                <!-- END MODAL BODY -->
                <!-- BEGIN MODAL FOOTER -->
                <!-- <footer class="modal-footer">
                    <button type="button" class="btn btn-danger" @click="close">Cancel</button>
                    <slot name="footer"></slot>
                </footer> -->
                <!-- END MODAL FOOTER -->
            </div>
        </div>
    </transition>
</template>

<style scoped lang="scss">
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.3);
        padding: 15px;
    }
    .modal {
        z-index: 1;
        position: relative;
        display: block;
        height: auto;
        max-height: 100%;
        background: #ffffff;
        box-shadow: 2px 2px 2px 1px;
        padding: 0 8px;
        margin: 0 auto;
    }
    .modal-header,
    .modal-footer {
        padding: 15px;
        h4 {
            margin: 0 !important;
        }
    }
    .modal-header {
        border-bottom: 1px solid #eeeeee;
        color:  #4AAE9B;
        justify-content: space-between;
    }
    .modal-footer {
        border-top: 1px solid #eeeeee;
        justify-content: flex-end;
    }
    .modal-body {
        max-height: calc(100vh - 109px);
        overflow: auto;
    }
    .btn-close {
        border: none;
        font-size: 20px;
        padding: 20px;
        cursor: pointer;
        font-weight: bold;
        color: #4AAE9B;
        background: transparent;
    }
    .modal-fade-enter,
    .modal-fade-leave-active {
        opacity: 0;
    }
    .modal-fade-enter-active,
    .modal-fade-leave-active {
        transition: .5s ease;
    }
</style>

<script>
import AlertMixin from '@common/mixin/AlertMixin';

export default {
    props: {
        options: {
            type: Object,
            default: function() {
                return {
                    width: '800px',
                    height: 'auto',
                    minHeight: '440px',
                    maxHeight: '640px',
                    bottom: '0',
                    overflowY: 'auto'
                }
            }
        },
        title: {
            type: String
        },
        closeIsDisabled: {
            type: Boolean,
            default: false
        },
        closeButtonText: {
            type: String,
            default: 'Cancel'
        },
        confirmCancel: {
            type: Boolean,
            default: false
        },
        confirmCancelText: {
            type: String,
            default: 'Are you sure you want to cancel?'
        }

    },
    methods: {
        close() {
            if(this.confirmCancel){
                let vm = this;
                this.confirmDialog(this.confirmCancelText, '', 'Yes', 'No', 'sm')
                    .then(({ok}) => {
                        if (ok) {
                            window.history.pushState('', document.title, window.location.pathname);
                            vm.$emit('close');
                        }
                    });
                return;
            }
            // display back the original url
            window.history.pushState('', document.title, window.location.pathname);

            // emit this close event
            this.$emit('close');
        }
    },
    computed: {
        modalStyle() {
            return {
                width: this.options.width || '',
                height: this.options.height || '',
                minHeight: this.options.minHeight || '',
                maxHeight: this.options.maxHeight || '',
                overflowY: this.options.overflowY || '',
                bottom: this.options.bottom || ''
            }
        }
    },
    mixins: [
        AlertMixin
    ]
}
</script>
