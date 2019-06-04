<template>
    <div class="fs-custom-textarea">
        <p class="fs-main-text" v-if="!isNowEditing" @click="isNowEditing = !isNowEditing">
            {{ trimText }}
        </p>
        <textarea v-if="isNowEditing" v-model="editedText" :rows="rows"></textarea>
        <div></div>
    </div>
</template>

<style lang="scss" scoped>
    .fs-main-text {
        margin: 0;
        cursor: pointer;
    }
    textarea {
        background: #ffffffb8;
        border: 1px solid #bdbdbd;
        border-radius: 3px;
        height: 100%;
        resize: none;
        width: 100%;
    }
</style>

<script>
export default {
    props: {
        text: {
            type: String,
            default: ''
        },
        showAsEditing: {
            type: Boolean,
            required: true
        },
        rows: {
            type: Number,
            default: 5
        }
    },
    data() {
        return {
            editedText: '',
            isNowEditing: this.showAsEditing
        }
    },
    computed: {
        trimText() {
            return (this.text) ? this.text.trim() : '';
        }
    },
    watch: {
        text: function() {
            this.editedText = this.trimText
        },
        editedText: function(value) {
            this.$emit('change', value);
        },
        isNowEditing: function(value) {
            this.$emit('focus', value);
            this.editedText = this.text;
        },
        showAsEditing: function(value) {
            this.isNowEditing = this.showAsEditing
        }
    },
}
</script>
