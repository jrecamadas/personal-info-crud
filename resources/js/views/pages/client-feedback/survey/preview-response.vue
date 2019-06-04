<template>
    <div>
        <questionnaire-display v-if="isLoaded" :questions="processedQuestions" :responder="responder" :remarks="remarks" :previousLink="previousLink" :nextLink="nextLink" readonly isResult />
    </div>
</template>

<script>

import questionnaireDisplay from '@views/pages/client-feedback/questionnaires/questionnaire-display';

import { mapActions, mapGetters } from 'vuex';

export default {
    data() {
        return {
            isLoaded: false,
            processedQuestions: [],
            responder: [],
            remarks: '',
            previousLink: '',
            nextLink: ''
        };
    },
    computed: {
        ...mapGetters({
            surveys: 'surveySent/data',
            questions: 'surveyResponses/data',
        }),
        survey() {
            if (this.surveys.length > 0) {
                return this.surveys[0];
            } else {
                return null;
            }
        }
    },
    async created() {
        await this.getSurveySent({
            query: {
                surveyLink: this.$route.params.link,
            }
        });
        
        // TODO: redirect to 404 page
        if (this.survey == null) {
            return this.router.go(-1);
        }

        this.remarks = this.survey.remarks;
        
        this.previousLink = this.survey.previousSurveyLink;
        this.nextLink = this.survey.nextSurveyLink;

        await this.getSurveyResponses({
            query: {
                surveySentId: this.survey.id,
            }
        });

        let result = [];

        this.questions.map((entry) => {
            const c = result[entry.questionCategorySequence] || {
                name: entry.questionCategory,
                items: [],
            };

            c.items[entry.questionSequence] = {
                id: entry.id,
                name: entry.question,
                rating: entry.response
            };

            c.items = c.items.filter((e) => e != null).sort();

            result[entry.questionCategorySequence] = c;
        });

        this.processedQuestions = result.filter((e) => e != null).sort();

        let responderDetail = [];
        let projectSurveyDetails = this.survey.survey.data;
        let format = 'MMMM DD, YYYY hh:mm:ss A';

        responderDetail.name = this.survey.contactName;
        responderDetail.email = this.survey.contactEmail;
        responderDetail.company = projectSurveyDetails.client.data.company;
        responderDetail.project = projectSurveyDetails.project.data.project_name;
        responderDetail.dateSent = moment(this.survey.dateSent.date).format(format);
        responderDetail.dateResponded = moment(this.survey.dateReplied.date).format(format);
        
        this.responder = responderDetail;

        this.isLoaded = true;
    },
    methods: {
        ...mapActions({
            getSurveySent: 'surveySent/getSurveySent',
            getSurveyResponses: 'surveyResponses/getSurveyResponses',
        })
    },
    components: {
        questionnaireDisplay

    }

};

</script>
