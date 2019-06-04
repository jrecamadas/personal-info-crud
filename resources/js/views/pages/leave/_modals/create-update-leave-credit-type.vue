<template>
    <modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="saveData" :disabled="!isValid">{{ info.operation }}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('name') || hasDBError || hasDuplicate}">
                                <label>Name<span class="error">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    ref="name"
                                    name="name"
                                    v-model="leaveCreditTypeData.name"
                                    data-vv-as="Name"
                                    v-validate="'required'"
                                    @keyup="resetDBError"/>
                                <span v-show="errors.has('name')" class="help-block form-error">{{ errors.first('name') }}</span>
                                <span v-show="hasDBError" class="help-block form-error">{{ getDBError('name') }}</span>
                                <span v-show="hasDuplicate" class="help-block form-error">{{ duplicateErrMsg }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('limit') || hasDBError}">
                                <label>Default Allocation<span class="error">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    ref="limit"
                                    name="limit"
                                    v-model="leaveCreditTypeData.limit"
                                    v-validate="'required|numeric|max_value:366'"
                                    data-vv-as="Limit"
                                    v-mask="'###'"
                                    @keyup="resetDBError"/>
                                <span v-show="hasDBError" class="help-block form-error">{{ getDBError('limit') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script>
    //Components
    import GenerateButton from '@components/form/button.vue';
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';

    //Mixins
    import DataTableMixin from '@common/mixin/DataTableMixin'
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import AlertMixin from '@common/mixin/AlertMixin';

    //Libraries
    import _ from 'lodash';
    import { mapActions, mapGetters } from 'vuex';
    import { mask } from 'vue-the-mask';
    import VeeValidate from 'vee-validate';

    export default {
        props: {
            info: { type: Object, required: true}
        },
        directives: {
            mask
        },
        data() {
            return {
                leaveCreditTypeData: {id: '', name: '', limit: 0},
                valid: false,
                option: { height: 'auto', width: '500px', bottom: 'auto' },
                button: { class: 'btn btn-primary',type: 'button' },
                loading: false,
                manualInput: false,
                hasDBError: false,
                hasDuplicate: false,
                duplicateErrMsg: '',
                dbError: {},
                leaveCreditTypeDataDBVal: ''
            }
        },
        computed: {
            ...mapGetters({
                leaveCreditTypes: 'leaveCreditTypes/single',
                leaveCreditTypesData: 'leaveCreditTypes/data',
            }),
            isValid() {
                let valid = true;
                this.hasDuplicate = false;
                //Check if fields are still blank
                _.each(this.leaveCreditTypeData, (data) => {
                    if (this.isEmpty(data)) {
                        valid = false;
                        return;
                    }
                });
                if (!valid) return;

                //Check if there are errors in Validation
                if (this.errors.any()) { valid = false; }
                return valid;
            }
        },
        methods: {
            ...mapActions({
                getLeaveCreditType: 'leaveCreditTypes/getLeaveCreditType',
                saveLeaveCreditType: 'leaveCreditTypes/saveLeaveCreditType'
            }),
            getDBError(key)
            { 
                if(Object.keys(this.dbError).length){
                    return (this.dbError.hasOwnProperty(key)) ? this.dbError[key] : '';
                }
                return;
            },
            setData () {
                this.leaveCreditTypeData.id = this.info.data.id;
                this.leaveCreditTypeData.name = this.info.data.name;
                this.leaveCreditTypeData.limit = this.info.data.limit;
                this.leaveCreditTypeDataDBVal = this.info.data.name;
            },
            saveData () {
                this.loading = true;
                this.hasDBError = false;
                this.dbError = {};
                this.errors.clear();
                this.saveLeaveCreditType(this.leaveCreditTypeData).then(() => {
                    this.$emit('success');
                    setTimeout(() => {
                        this.closeModal();
                        this.loading = false;
                        this.leaveCreditTypeData = {};
						this.notifyDialog('success', 'Successfully saved!');
                    },150)
                }).catch((e) => {
                    this.loading = false;
                    this.hasDBError = true;
                    let counter = 0;
                    _.each(e.response.data.message, (errMsg) => {
                        this.dbError[Object.keys(e.response.data.message)[counter]] = errMsg[0];
                        counter++;
                    });
                });
            },
            resetDBError (event) {
                if(event.target.value.trim() != this.leaveCreditTypeDataDBVal) {
                    this.hasDBError = false;
                    this.dbError = {};
                }
            }
        },
        created () {
            this.setData();
        },
        components: {
            GenerateButton,
            SaveButton,
            ModalDialog
        },
        mixins: [
            DataTableMixin,
            ModalDialogMixin,
            StringHelperMixin,
            AlertMixin
        ]
    }
</script>
