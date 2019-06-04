/**
 * Mixin for use in managing the screen loading overlay which is done via jQuery
 */
export default {
    methods: {
        /**
         * Show loading overlay
         * 
         * @return void
         */
        showLoader() {
            $.LoadingOverlay('show');
        },
        /**
         * Hide loading overlay on screen
         * 
         * @param  delay in milliseconds, default is 300
         * @return void 
         */
        hideLoader(delay = 300) {
            setTimeout(function() {
                $.LoadingOverlay('hide');
                $('body').removeClass('ks-page-loading');
            }, delay);
        }
    }
}