<template>
    <modal-dialog v-show="openModal" :options="option" :title="title" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!valid">{{modal_save}}</save-button>
        </template>
        <template slot="body">
            <div class="row" v-model="projectData">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('Project Name')}">
                                <label>Project Name<span class="error">*</span></label>
                                <input type="text" v-validate="'required'" ref="projectName" name="Project Name" class="form-control" v-model="projectData.project_name" />
                                <span v-show="errors.has('Project Name')" class="help-block form-error">{{ errors.first('Project Name') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project Description</label>
                                <input type="text" ref="projectDescription" name="project_description" class="form-control" v-model="projectData.project_description" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" rows="6" ref="projectNotes" name="notes" v-model="projectData.notes"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project URL</label>
                                <input type="text" ref="projectURL" name="project_url" class="form-control" v-model="projectData.project_url" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Project Requirements</label>
                                <input type="text" ref="projectRequirement" name="project_requirement" class="form-control" v-model="projectData.project_requirement" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Start Date</label>
                                <flat-pickr 
                                    v-model="projectData.start_date"
                                    :config="getConfig(true, false, startDateOptions)"
                                    placeholder="Select a date"
                                    name="start_date"
                                />
                             </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('status_id')}">
                                <label>Project Status<span class="error">*</span></label>
                                <select2 name="status_id"
                                         v-if="statuses.length"
                                         :options="statuses"
                                         :value="projectData.status_id"
                                         @select="projectData.status_id = $event">
                                    <!--<option value="0"> &#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45; </option>-->
                                </select2>
                                <span v-show="errors.has('status_id')" class="help-block form-error">{{ errors.first('status_id') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>System Requirements</label>
                                <input type="text" ref="systemRequirement" name="system_requirement" class="form-control" v-model="projectData.system_requirement" />
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>End Date</label>
                                <input v-if="disable" type="text" class="form-control" disabled placeholder="Select a date"/>
                                <flat-pickr v-else
                                    v-model="projectData.end_date"
                                    :config="getConfig(true, false, endDateOptions)"
                                    placeholder="Select a date"
                                    name="end_date"
                                />
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>
<style>
    .select2-results {
        max-height: 150px;
        overflow-y: auto;
    }
    .select2-container--default .select2-results>.select2-results__options {
        max-height: 150px;
    }
</style>
<script type="text/javascript">
import _ from 'lodash';

//Components
import GenerateButton from '@components/form/button.vue';
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';

//Mixins
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DatePickerMixin from '@common/mixin/DatePicker';
import AlertMixin from '@common/mixin/AlertMixin';

import Select2 from '@components/select2.vue';
import { mapActions, mapGetters } from 'vuex';

import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    props: {
		info: { type: Object, required: false}
    },
    data() {
        return {
            id: '',
            option: {
                width: '800px'
            },
            modal_save: 'Create',
            loading: false,
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },

            startDateOptions: {
                allowInput: true,
                // minDate: 'today',
                onClose: (selectedDates, dateStr, instance) => {
                    if(dateStr != "") {
                        this.endDateOptions.minDate = dateStr;
                        this.disable = false;
                    }
                }
            },
            endDateOptions: {
                minDate: 'today',
                allowInput: true
            },
            projectData: {
                id: '',
                client_id: '',
                project_name: '',
                project_description: '',
                project_url: '',
                project_requirement: '',
                system_requirement: '',
                color: '',
                start_date: '',
                end_date: '',
                status_id: '1',
                notes: ''
            },
            disable: true,
            status: {
                options: []
            },
            validation: [
                {path: 'project_name', name: 'project_name', rule: 'required', msg: {requred: 'Project Name is required'}}
            ],
            title: 'Add Project'
        }
    },
    async created () {
        await this.getProjectStatuses();
        this.id = this.info.project_id;
        if(this.id != "" && this.id > 0){
            this.projectData.status_id = this.info.status_id;
            await this.getProject(this.id);
            this.projectData = this.project_details;
            this.title = 'Update Project';
            this.modal_save = 'Update';
            this.disable = false;
        }else{
            this.projectData.client_id = this.info.client_id;
        }
    },
    methods : {
        ...mapActions({
            saveClientProject: 'clientProjects/saveProject',
            getProject: 'clientProjects/getProject',
            getProjectStatuses: 'clientProjects/getProjectStatuses'
        }),
        save() {
            this.loading = true;
            delete this.projectData.resources;
            this.saveClientProject(this.projectData).then(() => {
                setTimeout(() => {
                    this.closeDialog();
                    this.loading = false;
                    this.notifyDialog('success', 'Successfully saved!');
                },150);
            });
        },
        closeDialog(){
            this.disable = true;
            this.$emit("success");
        }

    },
    computed: {
        ...mapGetters({
            project_details: 'clientProjects/project',
            statuses: 'clientProjects/formatted'
        }),
        valid: function() {
            let valid = true;
            // check validation form validation set rule
            _.each(this.validation, (form) => {
                                // break validation rule
                let rules = form.rule.split('|');

                // validate accordingly
                _.each(rules, (rule) => {
                    if (rule == 'required') {
                        if (this.isEmpty(_.get(this.projectData, form.path))) {
                            valid = false;
                            return;
                        }
                    }
                });

                if (!valid) return;
            });
            return valid;
        }
    },
    components: {
        GenerateButton,
        SaveButton,
        ModalDialog,
        Select2,
        FlatPickr
    },
    mixins: [
        StringHelperMixin,
        ModalDialogMixin,
        DatePickerMixin,
        AlertMixin
    ]
}
</script>