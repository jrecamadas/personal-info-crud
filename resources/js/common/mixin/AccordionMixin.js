export default {
    data() {
        return {
            isOpen: false
        }
    },
    computed: {
        accordionClasses: function() {
            return {
                'is-closed': !this.isOpen,
                'is-primary': this.isOpen,
                'is-dark': !this.isOpen
            }
        }
    },
    methods: {
        toggleAccordion() {
            this.isOpen = !this.isOpen;
        }
    }
}
