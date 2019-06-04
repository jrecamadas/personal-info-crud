<template>
<div>
    <loader v-show="isProcessing" />
    <questionnaire-display v-if="isLoaded" :questions="processedQuestions" :remarks="remarks" v-on:updateRating="onUpdateRating" v-on:saveOrSubmit="saveOrSubmit" />
</div>
</template>


<style lang="scss" scoped>
    .loading-indicator-container{
        width: 200px;
        margin: auto;
    }
    .loading-indicator{
        position: relative;
        font-size: 100px;
    }
</style>
<script>
import questionnaireDisplay from '@views/pages/client-feedback/questionnaires/questionnaire-display';

// components
import { ClientSurvey } from '@common/model/client-feedback/ClientSurvey';
import { ClientResponse } from '@common/model/client-feedback/ClientResponse';
import { User } from '@common/model/User';
import Loader from "@components/loader.vue";
import OAuth from '@common/oauth/OAuth';


export default {
    data() {
        return {
            isLoaded: false,
            isProcessing: false,
            processedQuestions: [],
            link: '',
            surveySentId: '',
            surveyExpired: '',
            remarks: ''
        }
    },
    async created() {
        // init
        this.link = this.$route.params.surveyLink;
        await this.generateToken(true);
        await ClientSurvey.get({
                    surveyLink: this.link,
                    include: 'response'
            }).then((res) => {
                this.surveyExpired = (res.data.isExpired) ? true : false;
                this.surveySentId = res.data.id;
                this.survey = res.data.response.data;
                this.remarks = res.data.remarks;
            });

        if (this.survey == null) {
            return this.router.go(-1);
        }

        if (this.surveyExpired) {
            this.$router.push('/surveysubmitted');
        }
        else {
            this.isProcessing = true;
            let result = [];

            this.survey.map((entry) => {
                const c = result[entry.questionCategorySequence] || {
                    name: entry.questionCategory,
                    items: [],
                };

                c.items[entry.questionSequence] = {
                    id: entry.id,
                    name: entry.question,
                    rating: entry.response || 0
                };

                c.items = c.items.filter((e) => e != null).sort();

                result[entry.questionCategorySequence] = c;

            });

            this.processedQuestions = result.filter((e) => e != null).sort();

            this.isLoaded = true;
            this.isProcessing = false;
        }
        await this.generateToken(false);
        
    },
    components: {
        questionnaireDisplay,
        Loader
    },
    methods: {
        onUpdateRating(item, newRating) {
            this.processedQuestions.map((category, key) => {
                category.items.map((question, key) => {
                    if(question.id === item.id) {
                        question.rating = newRating;
                        category[key] = question;
                    }
                });
                this.processedQuestions[key] = category;
            });
        },
        async saveOrSubmit(remarks, action) {
            this.isProcessing = true;

            await this.generateToken(true);
            await this.processedQuestions.forEach(category => {
                category.items.forEach(question => {
                    const responseData = {
                        response: question.rating
                    };
                    const clientResponse = new ClientResponse({id: question.id});
                    clientResponse.save(responseData);
                });
            });

            const remarkData = {
                isExpired: (action == 'save' ? 0 : 1),
                remarks: remarks
            };
            const clientRemark = new ClientSurvey({id: this.surveySentId});
            clientRemark.save(remarkData).then((res) => {
                if (action == 'submit') {
                    this.$router.push({
                        name: 'surveysubmitted',
                        path: '/surveysubmitted',
                        params: {
                            responder: res
                        }
                    });
                }
            });

            this.isProcessing = false;
            await this.generateToken(false);
        },
        async generateToken(flag){
                let self = this;
                if (flag) {
                    await OAuth.tokenizeSurvey(this.link).then(response => {
                        self.loading = false;
                        if (response == true) {
                            self.invalid = false;
                        } else {
                            this.$router.push('/login');
                        }
                    });
                } else {
                    await OAuth.logout().then(() => {
                        let $ = jQuery;
                        $(document).ready(function(){
                            setTimeout(function(){
                                localStorage.removeItem('vuex');
                                localStorage.removeItem('auth_token');
                            },300);
                        });
                    });
                }
            },
    }
}
</script>
