export default {
    methods: {
        removeSpaces(str) {
            if (typeof str != 'undefined') {
                return str.replace(/\>[\t\s ]+\</g, "><");
            }
        },
        cleanHtmlTags(value) {
            var div = document.createElement("div")
            div.innerHTML = this.removeSpaces(value);
            return div.innerText
        },
        editorBodyValue(value) {
            var bodyText = this.cleanHtmlTags(value)
            if (bodyText.length <= 1) {
                return false
            }
            return true
        }
    }
}