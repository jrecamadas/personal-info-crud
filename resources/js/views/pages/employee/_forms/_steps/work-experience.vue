<template>
    <div>
        <div class="fs-field">
            <div class="card panel panel-default ks-information ks-light">
                <div class="card-header">
                    <h4> Work Experience</h4>
                    <span class="ks-text">&nbsp;</span>
                    <a href="#" class="fs-button" @click="openForm({key: 'work-experience', name: 'Work Experience'})">
                     <span class="la la-plus ks-icon"></span>   
                    </a>
                </div>
            </div>
        </div>

            <!-- BEGIN MODAL DIALOG -->
        <modal-dialog v-show="isModalVisible" :title="form.name" @close="closeModal">
            
                <!-- BEGIN WORK EXPERIENCE DIALOG -->
            <work-experience-form v-if="form.key == 'work-experience'" :modal="modal" :info="employee" @success="success($event)" @close="closeModal"></work-experience-form>
                <!-- END WORK DETAIL DIALOG -->
        </modal-dialog>
            <!-- END MODAL DIALOG -->

    </div>
</template>

<script>
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import ModalDialog from '@components/modal-dialog.vue';

// modal form
import WorkExperienceForm from '@views/pages/employee/_forms/work-experience.vue';

export default {
    data() {
        return {
            form: {
                key: 'work-experience',
                name: 'Work Experience'
            }
        }
    },
    props: {
        info: {
            type: Object,
            required: true
        }
    },

    methods: {
        getEmployee() {
            return Employee.get({
                id: this.$route.params.id
            });
        },
        openForm(form) {
            this.form = form;
            this.openModal();
        },
        success(data) {
            this.employee = data;
            this.closeModal();
        }
    },
    components: {
        ModalDialog,
        WorkExperienceForm
    },
    mixins: [
        ModalDialogMixin
    ]
}
</script>
