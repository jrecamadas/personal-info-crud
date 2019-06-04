<template>
    <modal-dialog v-show="openModal" :options="option" :title="modal_title" @close="closeModal">
        <template slot="body">
            <div class="showStatusBody">
                <div class="row" v-model="events">
                    <div v-for="tracked in events.tracked_events" class="rowevent">
                        <span class="normaltext">
                            Updated Applicant's status to
                            <span class="statustext">{{ tracked.status }}</span>
                            on
                            <span class="datetext">{{ formatDate(tracked.modifiedwhen,'MM/DD/YYYY h:mm:ss A') }}</span>
                            by
                            <span class="modifiertext">{{ tracked.modifiedby }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style type="text/css">
    .statustext{
        font-weight: bold;
    }
    .datetext{
        font-weight: bold;
        color: #007c9b;
    }
    .modifiertext{
        font-weight: bold;
        color: #0b2e13;
        font-size: 11pt;
    }
    .showStatusBody#modalDescription div.row.show-status-list{
        left: 0px!important;
        margin-left: 0%!important;
        padding-left: 25px!important;
    }
    .rowevent{
        padding-bottom: 10px;
    }
    .modal-body > .showStatusBody > .row{
        margin-left: 0px!important;
    }
</style>

<script type="text/javascript">
//Components
import ModalDialog from '@components/modal-dialog.vue';

//Mixins
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DateMixin from '@common/mixin/DateMixin';

//Models
import { EmployeeStatus } from '@common/model/EmployeeStatus';
import { User } from '@common/model/User';
import { mapGetters, mapActions } from 'vuex';
import jQuery from 'jquery'

export default {
    props: {
        applicant: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            option: {
                height: 'auto',
                width: '800px',
                bottom: 'auto'            
            },
            modal_title: 'Application Status Changes: ',
            loading: false,
            open: false,
            events: {
                tracked_events: []
            },
            updaters: [],
            include: [
                'employeeStatuses'
            ]
        }
    },
    computed: {
        ...mapGetters({
            employee: 'employees/single',
            statuses: 'empStatuses/data'
        }),
    },
    async created (){
        // Overrides button text and color in the modal
        let $ = jQuery;
        $(document).ready(function(){
            $("header.modal-header > span > button.btn").text("Close");
            $("header.modal-header > span > button.btn").attr('class','btn btn-primary');
        });

        // Load specific applicant
        await this.getEmployee({id: this.applicant, include: this.include.join(',')});

        this.modal_title += '('+this.employee.first_name+' '+this.employee.middle_name+' '+this.employee.last_name+')';
        this.employee.employeeStatuses.data.forEach((obj)=>{
            this.events.tracked_events.push({
                id: obj.id,
                status: obj.status.name,
                modifiedby: obj.updated_by,
                modifiedwhen: obj.updated_at.date+" "+obj.updated_at.timezone
            });
        });
    },
    methods: {
        ...mapActions({
            getEmployee: 'employees/getEmployee',
            getEmployeeStatuses: 'empStatuses/getEmployeeStatuses'
        }),
        closeDialog(){
            this.loading = false;
            this.open = false;
            this.$emit("success");
        },
        getUpdater(id){
            let user = '...';
            this.updaters.forEach((res)=>{
                if(parseInt(res.id)==parseInt(id)){
                    user = res.username;
                }
            });
            return user;
        }
    },
    components: {
        ModalDialog
    },
    mixins: [
        EmployeeMixin,
        StringHelperMixin,
        ModalDialogMixin,
        DateMixin
    ]
}
</script>
