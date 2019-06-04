<template>
    <div id="education-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="head">
                    <span>Education</span>
                    <a href="#" class="btn btn-outline-primary ks-light ks-no-text" @click="openModal">
                        <span class="la la-plus ks-icon"></span>
                    </a>
                </h4>
            </div>
        </div>
        <!-- BEGIN LIST -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card fs-card" v-for="(e, i) in data.education" :key="i">
                    <div class="card-block fs-card-block">
                        <div class="image">
                            <img src="/assets/img/placeholders/placeholder.png" />
                        </div>
                        <div class="fs-card-info">
                            <h5 class="card-title">{{ e.schoolUniversity }}</h5>
                            <p class="card-text">{{ e.courseDegree }}</p>
                            <p class="card-text">{{ e.yearCompleted }}</p>
                        </div>
                    </div>
                    <div class="education-edit-button">
                        <a href="#" class="fs-button" @click="remove(i)">
                            <span class="la la-trash ks-icon"></span>
                        </a>
                        <a href="#" class="fs-button" @click="editEducation(i)">
                            <span class="la la-pencil ks-icon"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END LIST -->
        <!-- BEGIN MODAL -->
        <!--<modal-dialog v-show="isModalVisible" :title="modalTitle" :options="modal" @close="closeModal">-->
            <education-modal @close="closeModal" :form="form" :edit="index != -1" @success="saveEducation()"></education-modal>
        <!--</modal-dialog>-->
        <!-- END MODAL -->
    </div>
</template>

<style lang="scss" scoped>
.head {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.card + .card {
    margin-top: 0 !important;
}
</style>

<script>
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import ModalDialog from '@components/modal-dialog.vue';
import EducationModal from '@views/pages/employee/_modals/education.vue';
import _ from 'lodash';

export default {
    props: {
        data: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            modal: {
                width: '800px',
                height: '450px'
            },
            modalTitle: 'Add Education',
            form: {
                educationalAttainment: '',
                courseDegree: '',
                schoolUniversity: '',
                yearCompleted: ''
            },
            index: -1
        }
    },
    methods: {
        saveEducation() {
            let data = _.cloneDeep(this.form);

            if (this.index == -1) {
                // should update the list
                this.data.education.push(data);
            } else {
                this.data.education[this.index] = data;
                this.index = -1;
            }

            this.closeModal();
            this.clearForm();
        },
        editEducation(index) {
            this.index = index;
            this.form = _.cloneDeep(this.data.education[index]);
            this.openModal();
        },
        remove(index) {
            // remove from the list
            this.data.education.splice(index, 1);
        },
        clearForm() {
            for (let key of Object.keys(this.form)) {
                this.form[key] = '';
            }
        }
    },
    mixins: [
        ModalDialogMixin
    ],
    components: {
        ModalDialog,
        EducationModal
    }
}
</script>
