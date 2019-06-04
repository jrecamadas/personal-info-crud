<template>
    <div>
        <div class="card">
            <div class="card-header">
                Variables
            </div>
            <div class="card-body">
                <p>
                    Below are variables you can use in the subject and body of the email. Don't forget to include the survey link in the email 
                    as this will be used to navigate for client's survey.
                </p>
                <div class="row">
                    <div class="col-sm-4">
                        <h5 class="card-title">
                            &#x2774;&#x2774;$surveyLink&#x2775;&#x2775;
                        </h5>
                        <p class="card-text">
                            The link to the survey
                        </p>
                        <br>
                        <h5 class="card-title">
                            &#x2774;&#x2774;$surveyMonth&#x2775;&#x2775;
                        </h5>
                        <p class="card-text">
                            The month the email is sent
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <h5 class="card-title">
                            &#x2774;&#x2774;$projectName&#x2775;&#x2775;
                        </h5>
                        <p class="card-text">
                            The name of the project
                        </p>
                        <br>
                        <h5 class="card-title">
                            &#x2774;&#x2774;$surveyDay&#x2775;&#x2775;
                        </h5>
                        <p class="card-text">
                            The day the email is sent
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <h5 class="card-title">
                            &#x2774;&#x2774;$contactName&#x2775;&#x2775;
                        </h5>
                        <p class="card-text">
                            The name of the recipient
                        </p>
                        <br>
                        <h5 class="card-title">
                            &#x2774;&#x2774;$surveyYear&#x2775;&#x2775;
                        </h5>
                        <p class="card-text">
                            The year the email is sent
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <form-text
            id="client-feedback-subject"
            label="Email Subject"
            placeholder="Email Subject"
            help-text="The subject of the email."
            :value="subject"
            required
            @change="onFormTextChange"
        />
        <div class="form-group">
            <label>
                Email Body
                <span class="text-danger">*</span>
            </label>
            <wysiwyg v-model="emailBody" />
            <small class="form-text text-muted">The body of the email.</small>
        </div>
    </div>
</template>

<style scoped>

.editor {
    height: 500px !important;
    width: 100% !important;
    border: 1px solid #dee0e1;
}

</style>

<script>
import _ from 'lodash';

import FormText from '@components/form/text.vue';

export default {
    components: {
        FormText,
    },
    props: {
        subject: {
            type: String,
            default: '',
        },
        body: {
            type: String,
            default: '<p>&nbsp;</p>',
        },
    },
    data() {
        return {
            emailBody: this.body,
        };
    },
    watch: {
        emailBody() {
            const f = _.debounce(() => {
                this.$emit('change', this.subject, this.emailBody);
            }, 500);
            f();
        },
        body(value) {
            this.emailBody = value;
        },
    },
    methods: {
        onFormTextChange(value) {
            this.$emit('change', value, this.body);
        },
    },
};
</script>
