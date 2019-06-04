<template>
    <div class="fs-accord">
        <div class="fs-field">
            <div class="card panel panel-default ks-information ks-light">
                <div class="card-header">
                    <h4 class="ks-text">Government</h4>
                    <a href="#" class="btn btn-outline-primary ks-light ks-no-text" @click="open = true">
                        <span v-if="employee.governmentIds && employee.governmentIds.data.length" class="la la-edit ks-icon"></span>
                        <span v-else class="la la-plus-square ks-icon"></span>
                    </a>
                </div>
                <div class="card-block">
                    <div class="row fs-info-wrapper" v-if="employee.governmentIds">
                        <div v-for="({name, id_number}, index) in employee.governmentIds.data" class="col-sm-12 col-md-6">
                            <div class="fs-info-flex flex-row">
                                <label>{{ name }}</label>
                                <span class="ks-text">{{ id_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN MODAL DIALOG -->
        <government-modal :openModal="open" @success="updateData" @close="open = false"></government-modal>
        <!-- END MODAL DIALOG -->
    </div>
</template>

<script>
import GovernmentModal from '@views/pages/employee/_modals/government.vue';
import _ from 'lodash';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            open: false
        }
    },
    components: {
        GovernmentModal
    },
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        })
    },
    methods: {
        openModal() {
            this.open = true;
        },
        updateData() {
            this.open = false;
            this.$emit('success');
        }
    }
}
</script>
