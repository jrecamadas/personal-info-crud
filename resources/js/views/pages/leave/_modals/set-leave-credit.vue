<template>
    <modal-dialog v-show="openModal" :title="'Set Leave Credits'" @close="closeModal" :options="option">
        <template slot="button">
            <save-button :loading="loading" @action="save" :disabled="!isValidForm">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-12">
                    <div class="row form-group">
                        <div class="col-12 col-sm-6">
                            <label>
                                Name
                                <strong>:</strong>
                            </label>
                            <span>{{ info.name }}</span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>
                                Employment Status
                                <strong>:</strong>
                            </label>
                            <span>{{ employmentStatusDisplay }}</span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>
                                Project
                                <strong>:</strong>
                            </label>
                            <span>{{ projectDisplay }}</span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>
                                Department
                                <strong>:</strong>
                            </label>
                            <span>{{ departmentDisplay }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row form-group">
                        <div class="col-12 col-sm-6"
                            v-for="(creditType, index) in creditTypes"
                            :key="index"
                        >
                            <label>{{ creditType.name }}</label>
                            <input 
                                type="number"
                                step=".5"
                                min="0"
                                class="form-control"
                                v-model="formData[creditType.id].balance"
                                @keyup="removeErrorMsg($event, creditType.id, 366)"
                                v-validate="'max_value:366|required'"
                                :name="creditType.name"
                                :id="creditType.id"
                            >
                            <span 
                                v-show="getErrorForField(creditType.name)"
                                class="help-block form-error"
                            >
                                {{  getFormattedErrorMessage(creditType.name) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped>
    .form-error {
        color: #f00;
    }
</style>

<script>
    //Components
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';

    //Mixins
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';

    import { mapActions } from 'vuex';
    import _ from 'lodash';

    export default {
        props: {
        info: {
            type: Object,
            required: true
        },
        creditTypes: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            loading: false,
            option: {
                width: '800px',
                height: 'auto !important',
                bottom: 'auto',
                overflowY: 'auto',
                maxHeight: '680px'
            },
            formData: {},
            hasDBError: false
        }
    },
    created() {
        _.each(this.creditTypes, (creditType) => {
            let object = _.find(this.info.leaveCredits.data, (leaveCredit) => {
                return leaveCredit.leave_credit_type_id === creditType.id;
            });

            this.formData[creditType.id] = {id: '', balance: 0};

            if (object) {
                this.formData[creditType.id].id = object.id;
                this.formData[creditType.id].balance = object.balance;
            }
        });
    },
    components: {
        SaveButton,
        ModalDialog
    },
    mixins: [
        ModalDialogMixin,
        StringHelperMixin
    ],
    computed: {
        isValidForm() {
            return Object.keys(this.errors.items).length === 0;
        },
        projectDisplay() {
            let projectNames = [];

            _.each(this.info.projects, (project) => {
                _.each(project, (employeeProject) => {
                    projectNames.push(employeeProject.clientProject.data.project_name);
                });
            });
            return projectNames.length ? projectNames.join(', ') : 'Unassigned';
        },
        employmentStatusDisplay(employeeStatuses) {
            return (this.info.employeeStatuses.data.length) ? _.last(this.info.employeeStatuses.data).status.name : 'Not Set';
        },
        departmentDisplay() {
            return this.info.department && this.info.department.data ? this.info.department.data.name : 'Unassigned';
        }
    },
    methods: {
        ...mapActions({
            saveEmployeeLeaveCredit: 'employeeLeaveCredits/saveEmployeeLeaveCredit'
        }),
        removeErrorMsg(value, id, limit) {
            if (value <= limit) {
                this.errors.items = this.deleteErrorArray(id);
            }
        },
        closeDialog() {
            if (this.errors.items.length === 0) {
                this.loading = false;
                this.$emit('success');
            }
        },
        getErrorForField(key) {
            return _.find(this.errors.items, function(o) { return o.field == key; });
        },
        deleteErrorArray(key) {
            return _.filter(this.errors.items, function(obj) {
                return obj.field != key;
            });
        },
        getErrorArray(key) {
            return _.filter(this.errors.items, function(obj) {
                return obj.field == key;
            });
        },
        getFormattedErrorMessage(key) {
            let errorArray = this.getErrorArray(key);

            if (errorArray && errorArray[0]) {
                return errorArray[0].msg;
            }

            return '';
        },
        async save() {
            await this.saveData();
        },
        async saveData() {
            let _this = this;
            this.errors.items = [];
            this.loading = true;
            await _.each(this.formData, async (leaveCredit, key) => {
                this.saveEmployeeLeaveCredit({
                    id: leaveCredit.id,
                    employee_id: this.info.id,
                    leave_credit_type_id: key,
                    balance: leaveCredit.balance,
                    action: 'set-leave-credits'
                }).then((res) => {
                    _this.closeDialog();
                }).catch(await function(e) {
                    _this.loading = false;
                    _this.hasDBError = true;
                    _this.errors.items.push({
                        id: leaveCredit.id,
                        msg: e.response.data.message.balance[0]
                    });
                });
            });
        }
    }
}
</script>