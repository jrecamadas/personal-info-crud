<template>
    <div>
        <page-header v-bind:title="(this.$route.params.surveyId == null && this.editSurvey.id == null) ? 'Add Survey' : 'Update Survey'">
            <div class="dataTable_buttons float-right pt-3">
                <form-button class="btn btn-primary" :disabled="!valid" @action="save">
                    <span v-if="!onEditProjectSurvey">Save</span>
                    <span v-else>Update</span>
                </form-button>
                <form-button class="btn btn-danger" @action="cancel">Cancel</form-button>
            </div>
        </page-header>
        <page-content>
            <loader v-show="isProcessing"/>
            <div class="ks nav body wrapper">
                <div class="container-fluid">
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row" id="startdate" v-if="projectSelected">
                                <div class="form-group col-md-12">
                                    <label>Start Date:</label>
                                    <br>
                                    <date-display
                                        :value="projectStartDate"
                                        displayType="datetime"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>
                                        Project Survey Name
                                        <span class="error">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-validate="'required'"
                                        v-model="surveyData.projectSurveyName"
                                        name="projectSurveyName"
                                    >
                                    <span
                                        v-show="errors.has('projectSurveyName')"
                                        class="help-block form-error"
                                    >
                                        {{
                                        replaceText(errors.first('projectSurveyName'), 'projectSurveyName', 'Project Survey Name') }}
                                    </span>
                                </div>
                                <div class="form-group col-md-12">
                                    <multi-select
                                        id="add-project-multiselect"
                                        placeholder="Select Projects"
                                        :options="projectOptions"
                                        :selectedOptions="selectedProject"
                                        :config="multiSelectProjectConfig"
                                        label="Project"
                                        helpText="List of client projects"
                                        v-on:change="onMultiProjectChange"
                                        required
                                    ></multi-select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <multi-select
                                        id="add-survey-multiselect"
                                        placeholder="Select emails"
                                        :options="emailOptions"
                                        :selectedOptions="selectedEmails"
                                        :config="multiSelectConfig"
                                        label="Send To"
                                        helpText="List of contacts who will recieve email"
                                        v-on:change="onMultiSelectChange"
                                        required
                                    ></multi-select>
                                    <span
                                        v-show="errors.has('recipientId')"
                                        class="help-block form-error"
                                    >{{ replaceText(errors.first('recipientId'), 'recipientId', 'Receipients') }}</span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>
                                        Recurring:
                                        <span class="error">*</span>
                                    </label>
                                    <select
                                        name="recurringType"
                                        class="form-control"
                                        v-validate="'required'"
                                        v-model="surveyData.recurringType"
                                    >
                                        <option value>Choose</option>
                                        <option
                                            :key="recurringType.value"
                                            :value="recurringType.value"
                                            v-for="recurringType in recurringTypes"
                                        >{{recurringType.name }}</option>
                                    </select>
                                    <span
                                        v-show="errors.has('recurringType')"
                                        class="help-block form-error"
                                    >
                                        {{
                                        replaceText(errors.first('recurringType'), 'recurringType', 'Recurring Type')
                                        }}
                                    </span>
                                    <div class="custom-control custom-checkbox" v-show="surveyData.recurringType != 0 && surveyData.recurringType != 5">
                                        <input v-model="surveyData.isConfirmation" type="checkbox" id="isConfirmation" name="isConfirmation" class="custom-control-input" />
                                        <label class="custom-control-label noselect" for="isConfirmation">
                                            Send confirmation email before sending to client
                                            <i @click="confirmDialog('Tips', tooltipHints, 'Close', false, sm)" class="fa ks-color-primary fa-info-circle" :title="tooltipHints"></i>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group col-md-12">
                                    <label>
                                        Survey Template:
                                        <span class="error">*</span>
                                    </label>
                                    <select
                                        name="questionnaireId"
                                        class="form-control"
                                        v-validate="'required'"
                                        v-model="surveyData.questionnaireId"
                                    >
                                        <option value>Choose</option>
                                        <option
                                            :key="questionnaire.id"
                                            :value="questionnaire.id"
                                            v-for="questionnaire in questionnaires"
                                        >
                                            {{
                                            questionnaire.name }}
                                        </option>
                                    </select>
                                    <span
                                        v-show="errors.has('questionnaireId')"
                                        class="help-block form-error"
                                    >
                                        {{
                                        replaceText(errors.first('questionnaireId'), 'questionnaireId', 'Survey Template') }}
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>
                                        Email Template:
                                        <span class="error">*</span>
                                    </label>
                                    <select
                                        name="id"
                                        class="form-control"
                                        v-validate="'required'"
                                        @change="selectTemplateEmail($event)"
                                        v-model="emailTemplateData.id"
                                    >
                                        <option value>Custom Email Template</option>
                                        <option
                                            :key="email.id"
                                            :value="email.id"
                                            v-for="email in emailTemplates"
                                        >
                                            {{
                                            email.templateName }}
                                        </option>
                                    </select>
                                    <span
                                        v-show="errors.has('emailName')"
                                        class="help-block form-error"
                                    >
                                        {{
                                        replaceText(errors.first('emailName'), 'emailName', 'Email Template ID') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <email-field
                                :subject="emailTemplateData.emailSubject"
                                :body="emailTemplateData.emailBody"
                                v-on:change="valueChange"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </page-content>
    </div>
</template>

<style>
.ck-editor__editable {
    min-height: 500px;
}

label {
    font-weight: bold;
}

.form-error {
    color: red;
}
.custom-control.custom-checkbox {
    margin-top: .7em;
}
.custom-control-label.noselect{
    margin-bottom: 3px!important;
}
div > label.custom-control-label::after{
    left: -23px !important;
}
label.custom-control-label {
    font-weight: normal !important;
}
</style>

<script>
import _ from "lodash";
import PageHeader from "@components/page-header.vue";
import PageContent from "@components/page-content.vue";
import Loader from "@components/loader.vue";

import FormButton from "@components/form/button.vue";
import FormText from "@components/form/text.vue";

import EmailField from "@components/client-feedback/email.vue";
import PromptComponent from "@components/client-feedback/prompt.vue";
import MultiSelect from "@components/form/multi-select.vue";

import DateDisplay from "@components/date-display.vue";

import StringHelperMixin from "@common/mixin/StringHelperMixin";
import DataTableMixin from "@common/mixin/DataTableMixin";
import AlertMixin from "@common/mixin/AlertMixin";

import { mapActions, mapGetters } from "vuex";

export default {
    data() {
        return {
            title: "",
            isProcessing: false,
            tooltipHints: 'If enabled, a confirmation email will be sent 5 days before the survey will be sent to the client. Else if disabled, the survey will be sent automatically to the client.',
            isUpdate: false,
            surveyData: {
                id: "",
                projectSurveyName: "",
                projectId: "",
                questionnaireId: "",
                emailTemplateId: "",
                clientId: "",
                recurringType: "",
                recipientId: [],
                isConfirmation: true,
            },
            recurringTypes: [
                {
                    name: "Monthly",
                    value: 1
                },
                {
                    name: "Quarterly",
                    value: 2
                },
                {
                    name: "Semi-Annually",
                    value: 3
                },
                {
                    name: "Annually",
                    value: 4
                },
                {
                    name: "Manually",
                    value: 5
                }
            ],
            multiSelectConfig: {
                taggable: false,
                trackBy: "recipientId",
                multiple: true,
                hideSelected: true,
                name: "name",
                label: "name"
            },
            multiSelectProjectConfig: {
                taggable: false,
                trackBy: "id",
                multiple: false,
                hideSelected: true,
                name: "name",
                label: "name"
            },
            selectedProject: [],
            projectOptions: [],
            selectedEmails: [],
            emailOptions: [],
            projects: [],
            emailTemplateData: {
                id: "",
                emailName: "",
                emailSubject: "",
                emailBody: ""
            },
            customEmailTemplate: false,
            onEditProjectSurvey: false,
            projectSelected: false,
            projectStartDate: "",
            userSelectEmailTemplate: false
        };
    },
    methods: {
        ...mapActions({
            saveEmailTemplate: "emailTemplates/saveEmailTemplate",
            getEmailTemplate: "emailTemplates/getEmailTemplate",
            getEmailTemplates: "emailTemplates/getEmailTemplates",
            saveSurvey: "surveys/saveSurvey",
            getQuestionnaires: "questionnaires/getQuestionnaires",
            clearCustomEmail: "emailTemplates/clearCustomEmail",
            getSurvey: "surveys/getSurvey",
            getClient: 'clients/getClient'
        }),
        onMultiProjectChange(selected) {
            this.selectedProject = selected;
            this.surveyData.projectId = selected.id;
        },
        onMultiSelectChange(selected) {
            this.selectedEmails = selected;

            let ids = [];

            for (let i = 0; i < this.selectedEmails.length; i++) {
                ids.push(this.selectedEmails[i].recipientId);
            }

            this.surveyData.recipientId = ids;
        },
        projectSelect(event) {
            const value = event.target.value;
            for (let i = 0; i < this.clientProjects.length; i++) {
                if (this.clientProjects[i].id == value) {
                    const start_date = this.clientProjects[i].start_date;
                    if (start_date == null) {
                        this.projectSelected = false;
                    } else {
                        this.projectSelected = true;
                        this.projectStartDate = start_date;
                    }
                }
            }
        },
        postSurvey(data) {
            if (data.recurringType == 5) data.isConfirmation = 0;
            data.isConfirmed = 0;
            this.saveSurvey(data).then(() => {
                this.$emit("success");
                this.isProcessing = false;
                if(data.reccuringType != 5 && data.isConfirmation == true && this.onEditProjectSurvey) {
                    const title = "Survey Updated!";
                    const msg = "You need to re-confirm this survey. ";
                    this.confirmDialog(title, msg, "Go to Confirm Survey", "OK").then(({ ok }) => {
                        if (ok) {
                            this.clearData();
                            window.location.href = "/project-surveys/" + data.id + "/send-survey/";
                        } else {
                            this.clearData();
                            this.cancel();
                        }
                    });
                } else {
                    this.clearData();
                    this.cancel();
                }
            });
        },
        clearData() {
            setTimeout(() => {
                this.emailTemplateData = {};
                this.surveyData = {};
                this.clearCustomEmail();
            }, 1000);
        },
        save() {
            if (this.customEmailTemplate && this.emailTemplateData.id.length == 0) {
                const title = "This will save as new email template";
                const customName = this.emailTemplateData.emailName;
                const msg = "Rename custom template name or you can use default name:"
                this.promptDialog(title, msg, "Save", "", {
                    value: customName, 
                    component: PromptComponent, 
                    invalidMessage: 'Name is required!'
                }).then( res => {
                    if(res.ok) {
                        this.isProcessing = true;
                        this.emailTemplateData.emailName = res.value;
                        this.saveEmailTemplate(this.emailTemplateData).then(res => {
                            this.surveyData.emailTemplateId = this.customTemplate.id;
                            this.postSurvey(this.surveyData);
                        });
                    }
                });
            } else {
                this.isProcessing = true;
                this.postSurvey(this.surveyData);
            }
        },
        cancel() {
            this.$router.push({name: 'client', params: {id: this.$route.params.id}, hash: '#nav-survey'});
        },
        isValueChanged(origValue = '', copyValue) {
            let isChanged = false;
            if (origValue.localeCompare(copyValue) != 0) {
                isChanged = true;
            }
            return isChanged;
        },
        generateCustomTemplateName() {
            this.emailTemplateData.id = "";
            this.emailTemplateData.emailName =
                "Custom_" + window.performance.now().toString().substring(0, 5)
        },
        valueChange(subject, body) {
            if (!this.onEditProjectSurvey) {
                let origSelectedSubject = this.selectedEmailTemplate.emailSubject;
                let origSelectedBody = this.selectedEmailTemplate.emailBody;
                if (
                    this.isValueChanged(origSelectedSubject, subject) ||
                    this.isValueChanged(origSelectedBody, body)
                ) {
                    this.customEmailTemplate = true;
                } else {
                    this.customEmailTemplate = false;
                }
            } else {
                let origSurveySubject = this.editSurvey.etemplate.data.emailSubject;
                let origSurveyBody = this.editSurvey.etemplate.data.emailBody;
                if (
                    this.isValueChanged(origSurveySubject, subject) ||
                    this.isValueChanged(origSurveyBody, body)
                ) {
                    if (this.userSelectEmailTemplate) {
                        this.customEmailTemplate = false;
                    } else {
                        this.customEmailTemplate = true;
                    }
                } else {
                    this.customEmailTemplate = false;
                }
            }

            if (this.customEmailTemplate) {
                if (this.userSelectEmailTemplate == false) {
                    this.generateCustomTemplateName();
                    this.surveyData.emailTemplateId = "";
                    this.emailTemplateData.emailBody = body;
                    this.emailTemplateData.emailSubject = subject;
                } else {
                    this.generateCustomTemplateName();
                    this.surveyData.emailTemplateId = "";
                    this.emailTemplateData.emailBody = body;
                    this.emailTemplateData.emailSubject = subject;
                }
            } else {
                if (this.selectedEmailTemplate != "undefined" && this.userSelectEmailTemplate) {
                    this.emailTemplateData.id = this.selectedEmailTemplate.id;
                    this.surveyData.emailTemplateId = this.selectedEmailTemplate.id;
                    this.emailTemplateData.emailName = this.selectedEmailTemplate.templateName;
                } else {
                    if(this.editSurvey.etemplate) {
                        this.emailTemplateData.id = this.editSurvey.etemplate.data.id;
                        this.surveyData.emailTemplateId = this.editSurvey.etemplate.data.id;
                        this.emailTemplateData.emailName = this.editSurvey.etemplate.data.templateName;
                    }
                }
            }
        },
        async selectTemplateEmail(event) {
            if (event.target.value === "" || event.target.value === "0") {
                this.customEmailTemplate = true;
                this.generateCustomTemplateName();
                return;
            }

            await this.getEmailTemplate({
                query: {
                    id: event.target.value
                }
            }).then(() => {
                this.$emit("success");
                setTimeout(() => {}, 150);
            });
            if (this.selectedEmailTemplate.id) {
                this.userSelectEmailTemplate = true;
                this.emailTemplateData.id = this.selectedEmailTemplate.id;
                this.surveyData.emailTemplateId = this.selectedEmailTemplate.id;
            }
            this.emailTemplateData.emailName = this.selectedEmailTemplate.templateName;
            this.emailTemplateData.emailSubject = this.selectedEmailTemplate.emailSubject;
            this.emailTemplateData.emailBody = this.selectedEmailTemplate.emailBody;

            this.customEmailTemplate = false;
        },
        replaceText(str, look, replace) {
            if (str != null && str != "") {
                return str.replace(look, replace);
            }
            return "";
        }
    },
    async created() {
        this.isProcessing = true;
        const payload = {
            query: this.getParams(),
        }

        payload.query.isActive = 1;

        await this.getQuestionnaires(payload);

        await this.getEmailTemplates(payload);

        await this.getClient(this.$route.params.id);

        _.each(this.client.contacts.data, data => {
            this.emailOptions.push({
                recipientId: data.id,
                name: data.name + " (" + data.email + ")"
            });
        });

        for (let i = 0; i < this.client.projects.data.length; i++) {
            let element = this.client.projects.data[i];
            this.projectOptions.push({
                id: element.id,
                name: element.project_name
            });
        }

        if (this.client.id) {
            this.surveyData.clientId = this.client.id;
        }

        const surveyId = this.$route.params.surveyId;

        if (surveyId || (this.editSurvey && this.editSurvey.id)) {
            await this.getSurvey({ query: { id: surveyId || this.editSurvey.id } }).catch(() => {
                this.$router.push({ name: "client", params: { id: this.$route.params.id } });
            });
            if (this.editSurvey) {
                this.onEditProjectSurvey = true;
                this.emailTemplateData.id = this.editSurvey.etemplate.data.id;
                this.emailTemplateData.emailName = this.editSurvey.etemplate.data.templateName;
                this.emailTemplateData.emailSubject = this.editSurvey.etemplate.data.emailSubject;
                this.emailTemplateData.emailBody = this.editSurvey.etemplate.data.emailBody;

                this.surveyData.id = this.editSurvey.id;
                this.surveyData.projectSurveyName = this.editSurvey.projectSurveyName;
                this.surveyData.emailTemplateId = this.editSurvey.etemplate.data.id;
                this.surveyData.projectId = this.editSurvey.project.data.id;
                this.surveyData.questionnaireId = this.editSurvey.questionnaire.data.id;
                this.surveyData.clientId = this.editSurvey.client.data.id;
                this.surveyData.recurringType = this.editSurvey.recurringType;
                this.surveyData.isConfirmation = this.editSurvey.isConfirmationNeeded == 1 ? true : false;

                if (this.editSurvey.project.data.id) {
                    this.selectedProject.push({
                        id: this.editSurvey.project.data.id,
                        name: this.editSurvey.project.data.project_name
                    });
                }

                for (let i = 0; i < this.editSurvey.recipients.data.length; i++) {
                    let rid = this.editSurvey.recipients.data[i].clientContactId;
                    for (let j = 0; j < this.client.contacts.data.length; j++) {
                        const e = this.client.contacts.data[j];
                        if (rid == e.id) {
                            this.selectedEmails.push({
                                recipientId: e.id,
                                name: e.name + " (" + e.email + ")"
                            });
                            this.surveyData.recipientId.push(e.id);
                            break;
                        }
                    }
                }
                this.customEmailTemplate = false;
            }
            
        }
        this.isProcessing = false;
    },
    computed: {
        ...mapGetters({
            client: "clients/client",
            emailTemplates: "emailTemplates/data",
            selectedEmailTemplate: "emailTemplates/email",
            questionnaires: "questionnaires/questionnaire",
            customTemplate: "emailTemplates/custom",
            clientProjects: "clientProjects/data",
            surveys: "surveys/data",
            editSurvey: "surveys/surveyData"
        }),
        valid: function() {
            let valid = true;

            _.each(this.validation, form => {
                let rules = form.rule.split("|");

                _.each(rules, rule => {
                    if (rule == "required") {
                        if (this.isEmpty(_.get(this.emailTemplateData, form.path))) {
                            valid = false;
                            return;
                        }
                    }
                });
                if (!valid) return;
            });

            valid = !this.emailTemplateData.emailName.length > 0 ? false : valid;
            valid = !this.emailTemplateData.emailSubject.length > 0 ? false : valid;
            valid = !this.emailTemplateData.emailBody.length > 0 ? false : valid;

            valid = !this.surveyData.projectSurveyName ? false : valid;
            valid = !this.surveyData.projectId ? false : valid;
            valid = !this.surveyData.questionnaireId ? false : valid;
            valid = !this.surveyData.clientId ? false : valid;
            valid = !this.surveyData.recurringType ? false : valid;
            valid = !this.surveyData.recipientId.length > 0 ? false : valid;

            return valid;
        }
    },
    components: {
        PageHeader,
        PageContent,
        MultiSelect,
        DateDisplay,
        Loader,
        FormButton,
        FormText,
        EmailField
    },
    mixins: [StringHelperMixin, DataTableMixin, AlertMixin]
};
</script>
