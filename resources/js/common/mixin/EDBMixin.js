/** @Author: Mike **/

import jquery from 'jquery';

export default {
    methods: {

        /** Force the element to disappear, when to disappear after calling this method, and the transition of
         *  disappearance in milliseconds
         *
         * @param selector - The CSS Selector of the element to be hidden
         * @param whenMillis - when method is called, how many milliseconds it would wait to start the element fading
         * @param delayMillis - fading time from full visible to totally invisible.
         */
        edbFadeElement(selector, whenMillis, delayMillis){
            let $ = jquery;
            $(document).ready(function(){
                setTimeout(function(){
                    $(selector).fadeOut(delayMillis);
                },whenMillis);
            });
        },

        /**
         * Searches needed within haystack (String based array)
         * @param needle string to be searched on
         * @param haystack string array use to search needed
         * @returns {boolean} true if found, else false
         */
        edbInArray(needle,haystack){
            let passed = false;
            haystack.every(function(item){
                if(needle === item || needle == item){
                    passed = true;
                    return false;
                } else {
                    return true;
                }
            });
            return passed;
        },

        edbCopyToClipboard(className){
            (function(){
                let urlSrc = document.querySelector(className);
                let range  = document.createRange();
                range.selectNodeContents(urlSrc);

                let selected = window.getSelection();
                selected.removeAllRanges();
                selected.addRange(range);
                document.execCommand("copy");

                setTimeout(function(){
                    document.getSelection().empty();
                },120);
            })();
        }
    }
}
