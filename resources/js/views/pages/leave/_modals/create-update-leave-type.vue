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
                            <div class="form-group" :class="{'has-error': errors.has('name') || hasDBError}">
                                <label>Name<span class="error">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    ref="name"
                                    name="name"
                                    v-model="leaveTypeData.name"
                                    data-vv-as="Name"
                                    v-validate="'required'"
                                    @keyup="resetDBError"/>
                                <span v-show="errors.has('name')" class="help-block form-error">{{ errors.first('name') }}</span>
                                <span v-show="hasDBError" class="help-block form-error">{{ getDBError('name') }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group" :class="{'has-error': errors.has('is_enabled') || hasDBError}">
                                        <div>
                                            <label>Status<span class="error">*</span></label>
                                        </div>
                                        <div class="center">
                                            <label class="ks-checkbox-switch switch-lg ks-primary">
                                                <input type="checkbox" v-model="leaveTypeData.is_enabled" @change="toggleStatus(leaveTypeData.is_enabled)">
                                                <span class="ks-wrapper"></span>
                                                <span class="ks-indicator"></span>
                                                <span class="ks-on">{{ status[1] }}</span>
                                                <span class="ks-off">{{ status[0] }}</span>
                                            </label>
                                        </div>
                                        <span v-show="errors.has('is_enabled')" class="help-block form-error">{{ errors.first('is_enabled') }}</span>
                                        <span v-show="hasDBError" class="help-block form-error">{{ getDBError('is_enabled') }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group" :class="{'has-error': errors.has('leave_credit_type_id') || hasDBError}">
                                        <label>Leave Credit Type<span class="error">*</span></label>
                                        <select3
                                            :options="leaveCreditTypesOptions"
                                            :value="leaveTypeData.leave_credit_type_id"
                                            @select="leaveTypeData.leave_credit_type_id = $event"/>
                                        <span v-show="errors.has('leave_credit_type_id')" class="help-block form-error">{{ errors.first('leave_credit_type_id') }}</span>
                                        <span v-show="hasDBError" class="help-block form-error">{{ getDBError('leave_credit_type_id') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
    .action-button {
        font-size: 20px;
    }
    .ks-checkbox-switch {
        margin: 7px auto;
    }
    .ks-checkbox-switch.ks-primary input[type=checkbox]:checked + .ks-wrapper,
    .ks-checkbox-switch > .ks-wrapper {
        width: 75px!important;
    }
    .ks-checkbox-switch input[type=checkbox]:checked + .ks-wrapper + .ks-indicator {
        left: 55px!important;
    }
    .ks-checkbox-switch > .ks-off {
        left: 22px!important;
    }
</style>

<script>
    //Components
    import GenerateButton from '@components/form/button.vue';
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import Select3 from '@components/select3.vue';

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
            components: {
            GenerateButton,
            SaveButton,
            ModalDialog,
            Select3,
        },
        mixins: [
            DataTableMixin,
            ModalDialogMixin,
            StringHelperMixin,
            AlertMixin
        ],
        props: {
            info: { type: Object, required: true}
        },
        directives: {
            mask
        },
        data() {
            return {
                leaveTypeData: { id: 0, name: '', is_enabled: 1, leave_credit_type_id: 1 },
				valid: false,
				option: { height: 'auto', width: '500px', bottom: 'auto' },
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput: false,
	            hasDBError: false,
	            dbError: [],
	            leaveTypeDataDBVal: ''
			}
		},
        async created () {
            this.setData();
            await this.getLeaveCreditTypes({query:this.getParams(9999)});
        },
        computed: {
            ...mapGetters({
                status:'leaveTypes/status',
                leaveCreditTypesOptions:'leaveCreditTypes/formatted',
            }),
            //Validator flag for the Save button
            isValid() {
                let valid = true;
                //Check if fields are still blank
                _.each(this.leaveTypeData, (data) => {
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
                saveLeaveType: 'leaveTypes/saveLeaveType',
                getLeaveCreditTypes: 'leaveCreditTypes/getLeaveCreditTypes',
            }),
            //Set initial state of reactive Leave Type Data to the value passed to the modal
            setData () {
                this.leaveTypeData.id = this.info.data.id;
                this.leaveTypeData.is_enabled = this.info.data.is_enabled;
                this.leaveTypeData.leave_credit_type_id = this.info.data.leave_credit_type_id;
                this.leaveTypeData.name = this.info.data.name;
                this.leaveTypeDataDBVal = this.info.data.name;
            },
            //Save Leave Type Data to Database
			saveData () {
				this.loading = true;
				this.hasDBError = false;
				this.dbError = [];
				this.errors.clear();
				this.saveLeaveType(this.leaveTypeData).then(() => {
					this.$emit('success');
					setTimeout(() => {
                        this.closeModal();
                        this.loading = false;
                        this.leaveTypeData = {};
						this.notifyDialog('success', 'Successfully saved!');
					},150)
				}).catch((e) => {
					this.loading = false;
					this.hasDBError = true;
                    this.dbError = [];
                    let counter = 0;
                    _.each(e.response.data.message, (errMsg) => {
						this.dbError[Object.keys(e.response.data.message)[counter]] = errMsg[0];
						counter++;
	                });
				});
            },
            //Map the Toggle Switch to True: 1 and False: 0
            toggleStatus (status)   {
                return (status) ? 1 : 0;
            },
            //Get error message from Back End
            getDBError(key)
			{
				if(Object.keys(this.dbError).length){
					return (this.dbError.hasOwnProperty(key)) ? this.dbError[key] : '';
				}
				return;
            },
            //Clear error message from Back End upon key up
			resetDBError (event) {
				if(event.target.value.trim() != this.leaveTypeDataDBVal) {
					this.hasDBError = false;
					this.dbError = [];
				}
			}
        },
    }
</script>
