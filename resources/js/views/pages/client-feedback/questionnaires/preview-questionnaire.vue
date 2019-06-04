<template>
    <div>
        <questionnaire-display v-if="isLoaded" :questions="processedQuestions" readonly />
    </div>
</template>

<script>

    import questionnaireDisplay from '@views/pages/client-feedback/questionnaires/questionnaire-display';

    import { mapActions, mapGetters } from 'vuex';

    export default {
        data() {
            return {
                isLoaded: false,
                processedQuestions: []
            };
        },
        computed: {
            ...mapGetters({
                questionnaire: 'questionnaires/questionnaire',
                questionCategories:'questionCategories/data',
                questions: 'questions/data',
                meta:'questionnaires/meta'
            })
        },
        async created() {
            await this.getQuestionnaire({
                query: {
                    id: this.$route.params.id
                }
            }).catch(() => {
                this.$router.go(-1);
            });
            await this.getQuestionCategories({
                query: {
                    questionnaireId: this.questionnaire.id
                }
            });

            this.questionCategories
                .sort((a, b) => a.displaySequence - b.displaySequence)
                .filter(value => value.isActive)
                .map(async function(category) {
                    const c = {
                        name: category.name,
                        items: [],
                        displaySequence: category.displaySequence,
                    };

                    await this.getQuestions({
                        query: {
                            categoryId: category.id
                        }
                    });

                    if (this.questions.length > 0) {
                        this.questions
                            .sort((a, b) => a.displaySequence - b.displaySequence)
                            .filter(value => value.isActive)
                            .map((q) => {
                                c.items.push({
                                    id: q.id,
                                    name: q.question,
                                    rating: 0
                                });
                            });
                    }
                    this.processedQuestions.push(c);
                    this.processedQuestions
                        .sort((a, b) => a.displaySequence - b.displaySequence);
                }.bind(this));
            this.isLoaded = true;
        },
        methods: {
            ...mapActions({
                getQuestionnaire: 'questionnaires/getQuestionnaires',
                getQuestionCategories: 'questionCategories/getCategories',
                getQuestions: 'questions/getQuestions'
            })
        },
        components: {
            questionnaireDisplay
        }
    };

</script>
