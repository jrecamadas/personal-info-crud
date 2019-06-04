<template>
    <modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid">{{info.name}}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('approver_id') || hasSSerror}">
                                <label>Name:<span class="error">*</span></label>
                                <select3
                                    :options="employeesList.options"
                                    :value="approverData.approver_id"
                                    v-validate="'required'"
                                    name="approver_id"
                                    data-vv-name="approver_id"
                                    @select="setApprovalSelectedValue"
                                >
                                </select3>
                                <span v-show="errors.has('approver_id')" class="help-block form-error">{{ errors.first('approver_id') }}</span>
                                <span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('oic_id') || hasSSerror}">
                                <label>Officer-in-Charge:<span class="error">*</span></label>
                                <select3
                                    :options="oicOptions"
                                    :value="approverData.oic_id"
                                    :disabled="disableOIC"
                                    :placeholder = "`Select Employee`"
                                    v-validate="'required'"
                                    data-vv-name="oic_id"
                                    name="oic_id"
                                    @select="setOICSelectedValue"
                                >
                                </select3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script>
    import _ from 'lodash';

    //Components
    import GenerateButton from '@components/form/button.vue';
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import Select3 from '@components/select3.vue';

    import DataTableMixin from '@common/mixin/DataTableMixin'
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import AlertMixin from '@common/mixin/AlertMixin';

    import { mapActions, mapGetters } from 'vuex';

    export default {
        props: {
            info: { type: Object, required: true}
        },
        data() {
            return {
                valid:false,
                option: { height: 'auto', width: '500px', bottom: 'auto' },
                approverData: {id: '', approver_id: -1, oic_id: -1},
                button: { class: 'btn btn-primary',type: 'button' },
                loading: false,
                manualInput : false,
                disableOIC: true,
                validation: [
                    { 
                        path: 'approver_id', 
                        name: 'approver_id', 
                        rule: 'required', 
                        msg: {
                            required: 'The Approver field is required'
                        } 
                    },
                    { 
                        path: 'oic_id', 
                        name: 'oic_id', 
                        rule: 'required', 
                        msg: {
                            required: 'The OIC field is required'
                        } 
                    }
                ],
                hasSSerror: false,
                ssError: null,
                employeesList:{
                    options:[],
                    fullOptions:[]
                },
                oicOptions: []
            }
        },
        computed: {
            ...mapGetters({
                approversAll: 'leaveApprovers/approversAll',
                employees: 'employees/formatted',
            }),
            isValid() {
                let valid = true;
                _.each(this.validation, (form) => {
                    let rules = form.rule.split('|')
                    // validate accordingly
                    _.each(rules, (rule) => {
                        if (rule == 'required') {
                            if (this.isEmpty(_.get(this.approverData, form.path))) {
                                valid = false;
                                return;
                            }
                            if (_.get(this.approverData, form.path) == -1){
                                valid = false;
                                return;
                            }
                        }
                    });

                    if (!valid) return;
                })
                return valid;
            }
        },
        async created() {
            this.employeesList.options.push({ id: -1, text: 'Select Employee', disabled: true });
            this.employees.forEach((obj) => {
                let isApprover = _.find(this.approversAll, function(approver) {
                    return approver.approver_id == obj.employee_id;
                });

                if (!isApprover) {
                    this.employeesList.options.push({
                        id: obj.employee_id,
                        text: obj.text
                    });
                }
                this.employeesList.fullOptions.push({
                    id: obj.employee_id,
                    text: obj.text
                });
            });
            if (this.info.approverDetail) {
                this.approverData.id = this.info.approverDetail.id;
                this.addApproverDataInOption(this.info.approverDetail);
                this.setApprovalSelectedValue(this.info.approverDetail.approver_id);
                this.setOICSelectedValue(this.info.approverDetail.oic_id);
            }
        },
        methods: {
            ...mapActions({
                saveApprover: 'leaveApprovers/saveApprover',
                fetchApprover: 'leaveApprovers/getApprover',
                getEmployees: 'employees/getEmployeeNames'
            }),
            save() {
                this.hasSSerror = false;
                this.ssError = '';
                this.loading = true;
                this.errors.clear();
                this.saveApprover(this.approverData).then(() => {
                    this.$emit('success');
                    setTimeout(() => {
                        this.closeModal();
                        this.approverData = {};
                        this.notifyDialog('success', 'Successfully saved!');
                    },150);
                }).catch((e) => {
                    this.loading = false;
                    this.hasSSerror = true;
                    this.ssError = e.response.data.message.employee_id[0];
                });
            },
            addApproverDataInOption(approver) {
                this.employeesList.options.push({
                    id: approver.approver.data.id,
                    text: approver.approver.data.name
                });
            },
            setApprovalSelectedValue(selectedValue) {
                this.approverData.approver_id = selectedValue;
                this.oicOptions = []; //removing options
                // filter options
                let tempOICOption = _.cloneDeep(this.employeesList.fullOptions); //copying the original source of options
                let approverSelectedOptionIndex = tempOICOption.findIndex(x => x.id == selectedValue); //getting the index of the selected option
                tempOICOption.splice(approverSelectedOptionIndex, 1); //removing the selected value from the copied options

                this.oicOptions = [{ id: -1, text: 'Select Employee', disabled: true }].concat(tempOICOption); //assigning to the options for OIC
                this.disableOIC = false;
            },
            setOICSelectedValue(selectedValue){
                this.approverData.oic_id = selectedValue;
            }
        },
        components: {
            GenerateButton,
            SaveButton,
            ModalDialog,
            Select3
        },
        mixins: [
            DataTableMixin,
            ModalDialogMixin,
            StringHelperMixin,
            AlertMixin
        ]
    }
</script>
