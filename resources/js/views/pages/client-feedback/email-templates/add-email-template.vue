<template>
    <div>
        <page-header v-bind:title="title">
            <div class="dataTable_buttons float-right pt-3">
                <form-button class="btn btn-primary" :disabled="!isValid" @action="save">
                    <span v-if="!isUpdate">Save</span>
                    <span v-else>Update</span>
                </form-button>
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
                            <form-text id="client-feedback-template-name" :error="duplicateTemplateName" errorString="Email Template Already Exist" :value="templateDetails.emailName" label="Template Name" placeholder="Template Name" helpText="The name that will be used to refer to this template." @change="onFormTextChange" required />
                        </div>
                        <div class="col-sm-8">
                            <email-field :subject="templateDetails.emailSubject" :body="templateDetails.emailBody" v-on:change="onEmailFieldChange" />
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
    import FormText from "@components/form/text.vue";

    import EmailField from "@components/client-feedback/email.vue";

    import CkEditorMixin from "@common/mixin/CkEditorMixin";

    import { mapActions, mapGetters } from 'vuex';

    export default {
        computed: {
            isValid() {
                return this.templateDetails.emailName.length > 0 &&
                       this.templateDetails.emailSubject.length > 0 &&
                       this.editorBodyValue(this.templateDetails.emailBody) &&
                       this.duplicateTemplateName != true;
            },
            ...mapGetters({
                emailTemplate: "emailTemplates/email",
                emailTemplates: "emailTemplates/emails",
            }),
        },
        data() {
            return {
                title: "Add Email Template",
                isProcessing: false,
                isUpdate: false,
                duplicateTemplateName: false,
                templateDetails: {
                    emailName: '',
                    emailSubject: '',
                    emailBody: '<p>&nbsp;</p>',
                },
            };
        },
        async created() {
            const emailId = this.$route.params.id;

            if (emailId) {
                this.isUpdate = true;
                this.title = "Update Email Template";

                await this.getEmailTemplate({
                    query: {
                        id: emailId,
                    }
                }).catch(() => {
                    this.$router.push({name: 'email_template'});
                });

                if (this.emailTemplate) {
                    this.templateDetails.emailName = this.emailTemplate.templateName;
                    this.templateDetails.emailSubject = this.emailTemplate.emailSubject || '';
                    this.templateDetails.emailBody = this.emailTemplate.emailBody || '';
                }
            }
        },
        methods: {
            ...mapActions({
                getEmailTemplate: "emailTemplates/getEmailTemplate",
                saveEmailTemplate: "emailTemplates/saveEmailTemplate",

            }),
            save() {
                if(this.isValid) {
                    const values = this.templateDetails;

                    if (this.isUpdate) {
                        values.id = this.$route.params.id;
                    }

                    this.isProcessing = true;
                    this.saveEmailTemplate(values).then(() => {
                        this.$emit('success');
                        this.$router.push({ name: 'email_template' });
                    }).catch(() => {
                        this.isProcessing = false;
                    });
                }
            },
            cancel() {
                this.$router.push({name: 'email_template'});
            },
            async onFormTextChange(value) {
                this.templateDetails.emailName = value;
                if (value !== "") {
                    await this.getEmailTemplate({query: {templateName: value}})
                }
                if (this.emailTemplates.length) {
                    this.duplicateTemplateName = true;
                } else {
                    this.duplicateTemplateName = false;
                }
            },
            onEmailFieldChange(subject, body) {
                this.templateDetails.emailSubject = subject;
                this.templateDetails.emailBody = body;
            },
        },
        components: {
            PageHeader,
            PageContent,
            FormButton,
            FormText,
            EmailField,
            Loader,
        },
        mixins: [CkEditorMixin]
    };

</script>
