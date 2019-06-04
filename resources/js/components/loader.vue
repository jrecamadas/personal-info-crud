<template>
    <transition name="modal-fade">
        <div class="modal-backdrop">
            <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; padding-right: 15px;">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content tp-3">
                        <div class="modal-body text-center">
                            <div class="loader"></div>
                            <div class="text-muted">Processing...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>

.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader {
    position: relative;
    text-align: center;
    margin: 15px auto 35px auto;
    z-index: 9999;
    display: block;
    width: 80px;
    height: 80px;
    border: 10px solid rgba(0, 0, 0, .3);
    border-radius: 50%;
    border-top-color: #000;
    animation: spin 1s ease-in-out infinite;
    -webkit-animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        -webkit-transform: rotate(360deg);
    }
}

@-webkit-keyframes spin {
    to {
        -webkit-transform: rotate(360deg);
    }
}

</style>

<script>

    export default {};

</script>
