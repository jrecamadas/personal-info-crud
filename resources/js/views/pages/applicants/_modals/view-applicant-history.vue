<template>
    <modal-dialog v-show="openModal" :options="option" :title="modal_title" @close="closeModal">
        <template slot="body">
            <div class="row">
                <div class="row" v-model="events">
                    <div v-for="tracked in events.tracked_events" class="rowevent">
                        <span>Updated Applicant's status to <b>{{ tracked.status }}</b> on {{ formatDate(tracked.modifiedwhen,'MM/DD/YYYY hh:mm') }} by {{ tracked.modifiedby }}</span>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style type="text/css">
   section.modal-body{
       overflow-y: scroll;
       overflow-x: hidden!important;
   }
   .row{
       left: 0px!important;
       margin-left: 0%!important;
       padding-left: 20px!important;
   }
   .rowevent{
       padding-bottom: 10px;
   }
</style>

<script type="text/javascript">

import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DateMixin from '@common/mixin/DateMixin';
import { Employee } from '@common/model/Employee';
import { User } from '@common/model/User';
export default {
    props: {
        applicant: {
            type: String,
            required: false
        }
    },
    created() {
        this.getEmployeeStatus(this.applicant);
    },
    data() {
        let columns = [
            { label: 'Status', key: 'status',  width: '40%', sortable: false },
            { label: 'Updated By', key: 'updated_by', width: '30%', sortable: false },
            { label: 'Updated At', key: 'updated_at', width: '30%', sortable: false },
        ];
        return {
            option: {
                height: 'auto',
                width: '800px',
                bottom: 'auto'
            },
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            modal_title: '',
            loading: false,
            events: {
                tracked_events: []
            },
        }
    },
    methods: {
        getEmployeeStatus(aid) {
            let data = [];
            //this.setFilter(`applicant_id|${this.applicant}`);
            Employee.get({id:aid}).then((res) => {
                this.modal_title = res.data.name;
                res.data.employeeStatuses.data.forEach((emp) => {
                    User.get({id:emp.updated_by}).then((res) => {
                        data.push({
                            id: emp.status.id,
                            status: emp.status.name,
                            modifiedby: res.data.user_name,
                            modifiedwhen: emp.status.created_at,
                        });
                        // var found = updaters.some(function (el) {
                        //     return el.id === res.data.id;
                        // });
                        // if(!found)
                        // updaters.push({id:res.data.id,name:res.data.user_name});
                    });
                });
                this.events.tracked_events = data;
            });
        },
    },
    components: {
        ModalDialog,
    },
    mixins: [
        ModalDialogMixin,
        DateMixin
    ]
}
</script>