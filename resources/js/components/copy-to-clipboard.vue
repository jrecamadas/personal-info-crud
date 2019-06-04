<template>
    <transition name="modal-fade">
        <div class="modal-backdrop">
            <div class="modal" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription"
                 :style="modalStyle"
            >
                <!-- BEGIN MODAL HEADER -->
                <header class="modal-header" id="modalTitle">
                    <h4>
                        Copy Link
                    </h4>
                        <span>
                            <button type="button" class="btn btn-primary" @click="close" area-label="Close Modal">{{ closeButtonText }}</button>
                            &nbsp;
                            <button type="button" class="btn btn-info" @click="proceed" area-label="Close Modal">{{ proceedButtonText }}</button>
                        </span>
                </header>
                <!-- END MODAL HEADER -->

                <!-- BEGIN MODAL BODY -->
                <section class="modal-body" id="modalDescription">
                    <slot name="body">
                        <span>The link was successfully copied to clipboard.</span>
                        <div>
                            <span class="copyText" @click="copyToClipboard('span.copyText')">{{ url }}</span>
                            <input name="url" id="url" type="text" v-model="url" class="copiedText" />
                        </div>
                        <span>If you wish to redirect from this page, click the "Access Link" button.</span>
                    </slot>
                </section>
                <!-- END MODAL BODY -->
            </div>
        </div>
    </transition>
</template>

<style scoped lang="scss">
    .copyText{
        position: absolute;
        margin-top: 13px;
        margin-left: 7px;
    }
    input#url{
        margin-top: 10px!important;
        margin-bottom: 10px!important;
        width: 100%;
        padding-left: 5px!important;
    }
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.3);
        padding: 15px;
    }
    .modal {
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
import EDBMixin from '@common/mixin/EDBMixin';
import jQuery from 'jquery';

export default {
    props: {
        options: {
            type: Object,
            default: function() {
                return {
                    width: '500px',
                    height: 'auto',
                    /*minHeight: '440px',
                    maxHeight: '640px',*/
                    bottom: '0',
                    overflowY: 'auto'
                }
            }
        },
        title: {
            type: String,
            default: 'URL copied successfully to clipboard'
        },
        url: {
            type: String,
            default: ''
        },
        closeButtonText: {
            type: String,
            default: 'Close'
        },
        proceedButtonText: {
            type: String,
            default: 'Access Link'
        },
        accessLinkTarget: {
            type: String,
            default: '_self'
        }
    },
    created(){
        let $ = jQuery;
        let vm = this;
        $(document).ready(function(){
            $('span.copyText').click();

            setTimeout(function(){
                $('input.copiedText').select();
                $('span.copyText').hide();
            },120);
        });
    },
    methods: {
        copyToClipboard(cssSelector){
            (function(){
                let urlSrc = document.querySelector(cssSelector);
                let range  = document.createRange();
                range.selectNodeContents(urlSrc);

                let selected = window.getSelection();
                selected.removeAllRanges();
                selected.addRange(range);
                document.execCommand("copy");
            })();
        },
        close() {
            // display back the original url
            window.history.pushState('', document.title, window.location.pathname);

            // emit this close event
            this.$emit('close');
        },
        proceed() {
            top.window.open(this.url, this.accessLinkTarget);
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
    }
}
</script>
