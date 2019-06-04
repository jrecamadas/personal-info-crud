export default {
    methods: {
        /**
         *
         * @param msg
         * @param yes
         * @param cancel
         * @param sm String('sm'or'lg')
         * @param prompt Object {value: 'input default value', invalidMessage: 'invalid', component: 'CustomComponent'}
         * @returns {boolean | *}
         */
        confirmDialog(title, msg, yes, cancel, size) {
            const options = {title: title, cancelLabel: cancel, okLabel: yes, size: size};
            return this.$dialogs.confirm(msg, options);
        },
        alertDialog(title, msg, cancel, size) {
            const options = {title: title, message: msg, okButtonText: cancel, size: size};
            return this.$dialogs.alert(msg, options);
        },
        /**
         * This method will trigger vue-snotify alert component
         * For more details visit this page: https://artemsky.github.io/vue-snotify/documentation/essentials/examples.html
         * SnotifyType: https://artemsky.github.io/vue-snotify/documentation/api/types.html#snotifytype
         *
         * @param  {string | SnotifyType} type
         * @param  {string} title
         * @param  {string} msg
         *
         * @returns void
         */
        notifyDialog(type, title, msg) {
            let options = {
                title: title || 'Successfully saved!',
                body: msg || '',
                config: {
                    type: type || 'success',
                }
            };

            this.$snotify.create(options);
        },
        promptDialog(title, msg, yes, size, prompt) {
            const options = {title: title, message: msg, okLabel: yes, size: size, prompt: prompt};
            return this.$dialogs.prompt(msg, options);
        },
    }
}
