<template>
    <div class="fs-leave-request-list">
        <div class="row fs-leave-request-headers">
            <div
                class="col"
                v-for="(column, index) in columns"
                :key="index"
                :class="column.klass">
                <div class="list-header">{{ column.label }}</div>
            </div>
        </div>
        <div class="row fs-leave-request-content">
            <div class="col col-sm-12" v-for="(leaveRequest, key, index) in requests" :key="key">
                <leave-request-for-approval-detail
                    v-if="isApproverList"
                    @success="fsReset"
                    :info="leaveRequest"
                    :columns="columns"
                    :class="{ even: index % 2 === 0, odd: index % 2 !== 0 }">
                </leave-request-for-approval-detail>
                <leave-request-list-detail
                    v-if="isRequestList"
                    @success="fsReset"
                    :info="leaveRequest"
                    :columns="columns"
                    :class="{ even: index % 2 === 0, odd: index % 2 !== 0 }">
                </leave-request-list-detail>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .fs-leave-request-list {
        position: relative;
        .fs-leave-request-headers {
            padding: 1rem 0;
            margin: auto;
            .list-header {
                font-weight: bold;
                font-size: 13px;
            }
        }
        .fs-leave-request-content {
            .col {
                padding: 0;
            }
        }
    }
</style>

<script>
    // components
    import LeaveRequestForApprovalDetail from '@views/pages/leave/_tabs/leave-request-for-approval-detail.vue';
    import LeaveRequestListDetail from '@views/pages/leave/_tabs/leave-request-list-detail.vue';

    // mixins
    import AlertMixin from '@common/mixin/AlertMixin';

    import {mapActions, mapGetters} from 'vuex';
    import _ from 'lodash';

    export default {
        components: {
            LeaveRequestForApprovalDetail,
            LeaveRequestListDetail
        },
        mixins: [  AlertMixin ],
        props: {
            columns: {
                type: Array,
                required: true,
            },
            requests: {
                type: Object,
                required: true
            },
            fsReset: {
                type: Function,
                required: true
            },
            tableDynamics: {
                type: Object,
                default: {
                    hasActions: false,
                    isApprover: false
                }
            }
        },
        computed: {
            isApproverList() {
                return this.tableDynamics.hasActions && this.tableDynamics.isApprover
            },
            isRequestList() {
                return this.tableDynamics.hasActions && !this.tableDynamics.isApprover
            },
            isHistory() {
                return !this.tableDynamics.hasActions && !this.tableDynamics.isApprover
            }
        },
    }
</script>