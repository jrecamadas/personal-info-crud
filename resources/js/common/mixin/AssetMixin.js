export default {

    data() {
        return {
            AssetMixin: {
                assetPath: '/api/asset'
            }
        };
    },

    methods: {
        /**
         * This gets the centralized path for asset. The source is either s3 or public (local) depending
         * on the .env configuration.
         * @param pathURL - standard URL of the asset
         * @param force - this appends unique string in the link so it forces to download, not from browser's cache
         * @returns {string}
         */
        getAssetPath(pathURL, force = false) {
            return pathURL ? this.AssetMixin.assetPath + '?path=' + pathURL + (force ? '&r=' + (new Date().getTime()) : '') : this.AssetMixin.assetPath;
        }
    }
}
