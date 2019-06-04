export default {
    props: {
        openModal: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        }
    }
}
