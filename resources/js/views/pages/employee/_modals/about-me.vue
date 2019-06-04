<template>
    <modal-dialog v-show="openModal" :title="'About Me'" @close="closeModal" :options="option">
        <template slot="button">
            <save-button :loading="loading" @action="save">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <textarea class="form-control" placeholder="About Me" v-model="summary" :maxlength="maxCharacter"></textarea>
                    </div>
                    <span class="words-left">Character Left: {{ remainingCharacter }}</span>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
textarea {
    min-height: 200px;
}
.row {
    margin-top: 0;
}

.form-group {
    margin-bottom: 0 !important;
}

.words-left {
    float: right;
}
</style>

<script>
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            loading: false,
            summary: '',
            maxCharacter: 350,
            remainingCharacter: 350,
            option: {
                width: '800px'
            }
        }
    },
    watch: {
        summary: function(value) {
            this.remainingCharacter = value ? (this.maxCharacter - value.length) : this.maxCharacter;
        }
    },
    created() {
        this.summary = this.employee.summary;
    },
    components: {
        SaveButton,
        ModalDialog
    },
    mixins: [
        ModalDialogMixin,
        StringHelperMixin,
        AlertMixin
    ],
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        })
    },
    methods: {
        save() {
            this.loading = true;

            this.employee.save({
                summary: this.summary
            }).then((res) => {
                this.loading = false;
                this.$emit('success');
                this.notifyDialog('success', 'Successfully saved!');
            });
        }
    }
}
</script>
