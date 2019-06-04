<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <vue-tags-input
                        v-model="interest"
                        :tags="interests"
                        @tags-changed="newInterest => interests = newInterest"
                    />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <footer class="dialog-footer">
                    <button type="button" class="btn btn-danger" @click="$emit('close')" :disabled="loading">Cancel</button>
                    <save-button :loading="loading" :options="button" @action="save" :disabled="isEmpty(interests)">Save</save-button>
                </footer>
            </div>
        </div>
    </div>
</template>

<style>
.row {
    margin: 0 !important;
}
</style>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
import _ from 'lodash';
import ArrayHelperMixin from '@common/mixin/ArrayHelperMixin';
import { Employee } from '@common/model/Employee';
import SaveButton from '@components/form/button.vue';

export default {
    props: {
        info: {
            type: Object,
            required: true
        },
        modal: {
            type: Object,
            default: function() {
                return {
                    width: '800px',
                    height: '400px'
                }
            }
        }
    },
    components: {
        VueTagsInput,
        SaveButton
    },
    data() {
        return {
            loading: false,
            interest: '',
            interests: [],
            button: {
                class: 'btn btn-primary',
                type: 'button'
            }
        }
    },
    created() {
        // adjust modal height
        this.modal.height = '253px';
    },
    methods: {
        save() {
            let promises = [];

            _.each(this.interests, (interest) => {
                promises.push(this.saveInterest({
                    employee_id: this.info.id,
                    interest: interest.text
                }));
            });

            Promise.all(promises).then((res) => {
                // get updated employee info
                this.getEmployee().then((res) => {
                    this.$emit('success', res.data);
                });
            });
        },
        saveInterest(data) {
            return this.info.interests.save(data);
        },
        getEmployee() {
            return Employee.get({id: this.info.id});
        }
    },
    mixins: [
        ArrayHelperMixin
    ]
}
</script>
