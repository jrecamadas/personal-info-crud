<template>
    <div>
        <page-header v-bind:title="title">
            <div class="dataTable_buttons float-right pt-3">
                <form-button class="btn btn-primary" :disabled="!isValid" @action="confirmOrSend">{{btnAction}}</form-button>
                <form-button class="btn btn-danger" @action="cancel">Cancel</form-button>
            </div>
        </page-header>
        <page-content>
            <loader v-show="isProcessing" />
            <div class="ks nav body wrapper">
                <div class="container-fluid">
                    <br />
                    <div class="row">
                        <div class="col-sm-4">
                            <multi-select :config="multiSelectConfig" :options="emailOptions" :selectedOptions="selectedEmails" id="client-feedback-email-recipients" label="Send To" helpText="List of people who will receive our email" v-on:change="onMultiSelectChange" required />
                            <div class="questionnaire-container">
                                <div class="questionnaire">
                                    <span class="questionnaire-label">Questionnaire: </span>
                                    <span class="questionnaire-value-group">
                                        <a href="#" @click="previewQuestionaire(questionnaire_id)" class="questionnaire-value">
                                            {{questionnaire_name}} 
                                            <i title="Preview Survey Questionnaire" class="fa ks-color-primary fa-info-circle"></i>
                                        </a> 
                                    </span>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <email-field :subject="emailSubject" :body="emailBody" v-on:change="onEmailFieldChange" />
                        </div>
                    </div>
                </div>
            </div>
        </page-content>
    </div>
</template>

<script>

    import PageHeader from "@components/page-header.vue";
    import PageContent from "@components/page-content.vue";
    import Loader from "@components/loader.vue";

    import FormButton from "@components/form/button.vue";
    import MultiSelect from '@components/form/multi-select.vue';

    import EmailField from "@components/client-feedback/email.vue";

    import AlertMixin from "@common/mixin/AlertMixin";

    import { mapActions, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                title: 'Send Survey',
                btnAction: 'Send',
                isProcessing: false,
                emailSubject: '',
                emailBody: '',
                emailOptions: [],
                selectedEmails: [],
                multiSelectConfig: {
                    label: 'name',
                    trackBy: 'clientContactId',
                    name: 'recipientId',
                    label: 'name',
                    taggable: false,
                    multiple: true,
                    hideSelected: true,
                },
                isConfirmPage: false,
                newCustomTemplate: false,
                emailTemplateData: {
                    emailName: '',
                    emailSubject: '',
                    emailBody: '',
                },
                surveyData: {
                    id: '',
                    projectSurveyName: '',
                    projectId: '',
                    questionnaireId: '',
                    emailTemplateId: '',
                    clientId: '',
                    isConfirmed: '',
                    isConfirmationNeeded: '',
                },
                questionnaire_name: null,
                questionnaire_id: null
            };
        },
        computed: {
            isValid() {
                return this.selectedEmails.length > 0 &&
                       this.emailSubject.length > 0 &&
                       this.emailBody.length > 0;
            },
            ...mapGetters({
                client: 'clients/client',
                survey: 'surveys/surveyData',
                customTemplate: "emailTemplates/custom",
            }),
        },
        async created() {
            await this.getSurvey({query: {id: this.$route.params.id}})

            if((this.survey.isConfirmationNeeded == 1 && this.survey.isConfirmed == 0) && this.survey.recurringType != 5) {
                this.btnAction = 'Confirm';
                this.title = 'Confirm Survey';
                this.isConfirmPage = true;
            }
            this.questionnaire_name = this.survey.questionnaire.data.name;
            this.questionnaire_id = this.survey.questionnaire.data.id;

            for(let i = 0; i < this.survey.recipients.data.length; i++) {
                let r = this.survey.recipients.data[i];

                for(let j = 0; j < this.survey.client.data.contacts.data.length; j++) {
                    let c = this.survey.client.data.contacts.data[j];

                    if(r.clientContactId == c.id) {
                        this.emailOptions.push({
                            clientContactId: c.id,
                            recipientId: r.id,
                            name: c.name + ' (' + c.email + ')',
                        });
                    }
                }
            }

            this.selectedEmails = this.emailOptions;
            this.emailSubject = this.survey.etemplate.data.emailSubject;
            this.emailBody = this.survey.etemplate.data.emailBody;
        },
        methods: {
            ...mapActions({
                getSurvey: 'surveys/getSurvey',
                sendManual: 'sendManual/sendManual',
                saveSurvey: 'surveys/saveSurvey',
                saveEmailTemplate: "emailTemplates/saveEmailTemplate",
            }),
            confirmOrSend() {
                const ids = [];

                for(let i = 0; i < this.selectedEmails.length; i++) {
                    ids.push(this.selectedEmails[i].recipientId);
                }

                if(this.isConfirmPage) {
                    this.save();
                    
                } else {
                    this.send();
                }
            },
            postSurvey(data) {
                this.saveSurvey(data).then(() => {
                    this.$emit("success");
                    setTimeout(() => {
                        this.emailTemplateData = {};
                        this.surveyData = {};
                    }, 1000);
                    this.cancel();
                });
            },
            save(recipientIds) {
                this.surveyData.id = this.survey.id;
                this.surveyData.projectSurveyName = this.survey.projectSurveyName;
                this.surveyData.projectId = this.survey.project.data.id;
                this.surveyData.questionnaireId = this.survey.questionnaire.data.id;
                this.surveyData.emailTemplateId = this.survey.etemplate.data.id;
                this.surveyData.clientId = this.survey.client.data.id;
                this.surveyData.isConfirmationNeeded = 1;
                this.surveyData.isConfirmed= 1;

                if (this.newCustomTemplate) {
                    this.emailTemplateData.emailName = "Custom_" + window.performance.now().toString().substring(0, 5);
                    const title = "This will save as new email template";
                    const msg = this.emailTemplateData.emailName;
                    this.alertDialog(title, msg, "Ok", "sm").then(({ ok }) => {
                        if (ok) {
                            this.isProcessing = true;
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
            send(recipientIds) {
                this.isProcessing = true;
                
                this.sendManual({
                    id: this.survey.id,
                    emailSubject: this.emailSubject,
                    emailBody: this.emailBody,
                    recipientId: recipientIds,
                }).then(() => {
                    this.$emit('success');
                    this.emailTemplateData = {};
                    this.cancel();
                });
            },
            cancel() {
                this.$router.push({name: 'client', params: {id: this.survey.client.data.id.toString()}, hash: '#nav-survey'})
            },
            onEmailFieldChange(subject, body) {
                if(this.isConfirmPage) {
                    if(this.isValueChanged(this.emailSubject, subject) || this.isValueChanged(this.emailBody, body)) {
                        this.newCustomTemplate = true;
                        this.emailTemplateData.emailSubject = subject;
                        this.emailTemplateData.emailBody = body;
                    } else {
                        this.newCustomTemplate = false;
                    }
                } else {
                    this.emailSubject = subject;
                    this.emailBody = body;
                }
            },
            onMultiSelectChange(selected) {
                this.selectedEmails = selected;
            },
            isValueChanged(origValue, copyValue) {
                let isChanged = false;
                if (origValue.localeCompare(copyValue) != 0) {
                    isChanged = true;
                }
                return isChanged;
            },
            previewQuestionaire(id) {
				window.open('/survey/preview/'+ id, '_blank');
			}
        },
        components: {
            PageHeader,
            PageContent,
            FormButton,
            EmailField,
            MultiSelect,
            Loader,
        },
        mixins: [AlertMixin]
    };

</script>

<style scoped>
    .questionnaire-container {
        background-color: #dedbdc;
        overflow: auto;
        padding: 16px;
        border-radius: 3px;
    }

    .questionnaire {
        position: relative;
    }

    .questionnaire-label {
        font-size: 13px;
    }

    .questionnaire-value {
        font-size: 13px;
        font-weight: bold;
        color: #25628F;
    }

    .questionnaire-value-group {
        padding: 5px;
        border-radius: 5px;
        position: relative;
        left: 5px;
        border: 1px solid #e53935;
    }
</style>
