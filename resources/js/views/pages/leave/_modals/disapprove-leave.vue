<template>
    <modal-dialog v-show="openModal" :title="'Disapprove Leave'" @close="closeModal" :options="option">
        <template slot="button">
            <save-button :loading="loading" @action="closeDialog" :disabled="!isValidForm">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-12">
                    <div class="row form-group">
                        <div class="col-12">
                            <label>Date: </label>
                            <span>{{ dateDisplay }}</span>
                        </div>
                        <div class="col-12">
                            <label>Status: </label>
                            <span>{{ statusDisplay }}</span>
                        </div>
                        <div class="col-12">
                            <label>Requester: </label>
                            <span>{{ employee.name }}</span>
                        </div>
                        <div class="col-12">
                            <label>Comment: </label>
                            <textarea
                                    class="form-control"
                                    v-model="comment"
                                    v-validate="'required'"
                                    name="comment"
                            ></textarea>
                            <span v-show="errors.has('comment')"
                                  class="help-block form-error"
                            >
                                {{  stringReplace(errors.first('comment'), 'comment', 'Comment') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
    label {
        font-weight: bold;
    }

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

    import {mapActions} from 'vuex';
    import _ from 'lodash';

    export default {
        props: {
            info: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                loading: false,
                option: {
                    width: '480px',
                    height: 'auto !important',
                    bottom: 'auto',
                    overflowY: 'auto',
                    maxHeight: '680px',
                },
                comment: '',
                statuses: {
                    approved: 0,
                    cancelled: 0,
                    disapproved: 0,
                    pending: 0,
                },
            };
        },
        components: {
            SaveButton,
            ModalDialog,
        },
        mixins: [
            ModalDialogMixin,
            StringHelperMixin,
        ],
        computed: {
            isValidForm() {
                return this.errors.items.length === 0 && this.comment.length > 0;
            },
            baseInfo() {
                return this.info[0];
            },
            employee() {
                return this.baseInfo.employee.data;
            },
            dateDisplay() {
                let startDate = '',
                    endDate = '';

                _.each(this.info, (leaveRequest) => {
                    let leaveRequestStartDate = this.$moment(leaveRequest.start_date, 'YYYY-MM-DD');
                    let leaveRequestEndDate = this.$moment(leaveRequest.end_date, 'YYYY-MM-DD');

                    if (startDate === '' || leaveRequestStartDate.diff(startDate, 'days') < 0) {
                        startDate = leaveRequestStartDate;
                    }
                    if (endDate === '' || leaveRequestEndDate.diff(endDate, 'days') > 0) {
                        endDate = leaveRequestEndDate;
                    }
                });

                return startDate.diff(endDate, 'days') !== 0 ?
                    `${startDate.format('MMM D, YYYY')} - ${endDate.format('MMM D, YYYY')}` : startDate.format(
                        'MMM D, YYYY');
            },
            statusDisplay() {
                if (this.info.length > 1) {
                    _.each(this.info, (request) => {
                        switch (request.status) {
                            case 'Approved':
                                this.statuses.approved++;
                                break;
                            case 'Cancelled':
                                this.statuses.cancelled++;
                                break;
                            case 'Disapproved':
                                this.statuses.disapproved++;
                                break;
                            case 'Pending':
                                this.statuses.pending++;
                                break;
                        }
                    });

                    return `${this.statuses.approved} Approved, ${this.statuses.cancelled} Cancelled, ${this.statuses.disapproved} Disapproved, ${this.statuses.pending} Pending, `;
                }
                else {
                    return this.baseInfo.status;
                }
            },
        },
        methods: {
            ...mapActions({
                saveEmployeeLeaveCredit: 'employeeLeaveCredits/saveEmployeeLeaveCredit',
            }),
            closeDialog() {
                this.$emit('success', {selectedRequests: this.info, comment: this.comment});
            },
        },
    };
</script>
