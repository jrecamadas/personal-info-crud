<template>
    <div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label>House No:</label>
                    <input v-model="data.houseNo" type="text" class="form-control" name="house_no" autofocus/>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="form-group">
                    <label>Street</label>
                    <input v-model="data.street" type="text" class="form-control" name="street" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Barangay</label>
                    <input v-model="data.barangay" type="text" class="form-control" name="barangay" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Town / City / Municipality</label>
                    <input v-model="data.townCity" type="text" class="form-control" name="town_city" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Province</label>
                    <input v-model="data.province" type="text" class="form-control" name="province" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Zip Code</label>
                    <input v-model="data.zipCode" type="text" class="form-control" name="zip_code" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <footer class="dialog-footer">
                    <button type="button" class="btn btn-danger" @click="$emit('close')" :disabled="loading">Cancel</button>
                    <save-button :loading="loading" :options="button" @action="save">
                        Add
                    </save-button>
                </footer>
            </div>
        </div>
    </div>
</template>

<style scoped>
textarea {
    min-height: 200px;
}
.row {
    margin-top: 0 !important;
}
</style>

<script>
import SaveButton from '@components/form/button.vue';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import _ from 'lodash';

export default {
    props: {
        data: {
            type: Object
        }
    },
    data() {
        return {
            loading: false,
            button: {
                class: 'btn btn-primary',
                type: 'button'
            }
        }
    },
    methods: {
        save() {
            this.loading = true;

            setTimeout(() => {
                this.loading = false;
                this.$emit('success', _.cloneDeep(this.data));
                this.clearForm();
                this.$emit('close');
            }, 1000);
        },
        clearForm() {
            for (let key of Object.keys(this.data)) {
                this.data[key] = '';
            }
        }
    },
    mixins: [
        StringHelperMixin
    ],
    components: {
        SaveButton
    }
}
</script>
