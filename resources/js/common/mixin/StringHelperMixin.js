export default {
    methods: {
        isEmpty(str) {
            return $.trim(str) === '';
        },
        slugify(str) {
            return str.toString().toLowerCase()
                .replace(/\s+/g, '-')      // Replace spaces with -
                .replace(/[^\w\-]+/g, '')  // Remove all non-word chars
                .replace(/\-\-+/g, '-')    // Replace multiple - with single -
                .replace(/^-+/, '')        // Trim - from start of text
                .replace(/-+$/, '');       // Trim - from end of text
        },
        stringReplace(str,find,replace){
            if(str && !this.isEmpty(str) && !this.isEmpty(replace)){
                return str.replace(find,replace);
            }else { return str; }
        }
    }
}
