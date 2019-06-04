<template>
    <div class="s-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light main-page">
        <div class="header-form bg-info">
            <div class="comp-logo-container">
                <img :src="fullScaleLogo" :alt="organizationShortNameAllCaps" class="comp-logo">
            </div>
        </div>
        <div class="main-form" v-if="!loadingData">
            <div class="form-title">
                <span>A Few Quick Questions</span>
            </div>
            <!----------------- ACCORDION -------------------->
            <div
                class="fs-accordion"
                :class="controlTabs.general"
                v-for="(question, index) in allQuestions"
                :key="index"
                v-show="questionShowOrHide(question.id)">
                <div class="fs-field">
                    <div class="card panel panel-default ks-information ks-light">
                        <div class="card-header">{{ question.description }}</div>
                        <div class="card-block fs-accordion-content">
                            <div class="fs-questionair-choices fs-multiple-group" v-if="question.group_choices">
                                <div class="row">
                                    <div
                                        class="col col-sm-12 mt-3"
                                        v-for="(group, i) in groupQuestionAnswers(question)"
                                        :key="i">
                                        <h5 class="mb-0">{{ group.group_name }}</h5><hr/>
                                        <div :style="setColumns(group.choices)">
                                            <div
                                                v-for="(choices, indx) in group.choices"
                                                :key="indx"
                                                class="custom-control custom-checkbox input-response">
                                                <input
                                                    :id="'c' + index + '-' + indx + '-' + choices.id"
                                                    type="checkbox"
                                                    class="custom-control-input"
                                                    :true-value="choices"
                                                    v-model="formResponse[ question.id + formDelimeter + index + formDelimeter + choices.id ]">
                                                <label
                                                    class="custom-control-label"
                                                    :for="'c' + index + '-' + indx + '-' + choices.id">
                                                    {{ choices.description }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fs-quiestionari-choices fs-single-group" v-else :style="setColumns(question.questionChoices.data)">
                                <div v-if="question.type == 'short_text'">
                                    <input
                                        type="text"
                                        :placeholder="rightPlaceholder(question.form_label)"
                                        v-model="formResponse[ question.id + formDelimeter + index ]">
                                </div>
                                <div
                                    v-else
                                    v-for="(choices, c_index) in question.questionChoices.data"
                                    :key="c_index">
                                    <div
                                        v-if="question.type == 'single_response'"
                                        class="custom-control custom-radio input-response">
                                        <input
                                            :id="'c' + index + '-' + c_index"
                                            :name="'radio' + index"
                                            type="radio"
                                            class="custom-control-input"
                                            v-bind:value="choices"
                                            v-model="formResponse[ question.id + formDelimeter + index ]"
                                            @change="controlQuestion(question.id, choices.display_sequence)">
                                        <label
                                            class="custom-control-label"
                                            :for="'c' + index + '-' + c_index">
                                            {{ choices.description }}
                                        </label>
                                    </div>
                                    <div
                                        v-if="question.type == 'multiple_response'"
                                        class="custom-control custom-checkbox input-response">
                                        <input
                                            :id="'c' + index + '-' + c_index"
                                            type="checkbox"
                                            class="custom-control-input"
                                            :true-value="choices"
                                            v-model="formResponse[ question.id + formDelimeter + index + formDelimeter + choices.id ]">
                                        <label
                                            class="custom-control-label"
                                            :for="'c' + index + '-' + c_index">
                                            {{ choices.description }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------- END ACCORDION ------------------>
            <div class="submit-button-container">
                <submit-button :loading="loadingBtn" @action="save">Submit</submit-button>
            </div>
        </div>
    </div>
</template>

<style type="text/css">
    body {
        padding-top: 0px !important;
    }
    .position-el {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .current-position {
        display: flex;
        flex-direction: row;
    }
    .position {
        width: 252px;
    }
</style>

<style lang="scss" scoped>
    .submit-button-container {
        text-align: center;
        padding: 3rem 0;
        button {
            width: 10rem;
            height: 3rem;
            font-size: 1.095rem;
            background: #007840;
        }
    }
    .submit-button {
        position: absolute;
        margin-left: 50% !important;
        left: -45px !important;
    }
    .input-response {
        padding-bottom: 5px !important;
    }
    .card-header {
        padding: 15px 15px 15px 15px !important;
        background-color: #eeeeee !important;
        cursor: auto!important;
        h4 {
            position: relative;
            margin-top: 7px !important;
        }
    }
    .main-form .card .card-header {
        background-color: #eeeeee !important;
    }
    .main-form .card .fs-accordion-content {
        background-color: #ffffff !important;
    }
    .main-form input[type="text"] {
        height: 30px;
        border: 1px solid #dddddd;
        width: 260px;
        padding-left: 7px;
    }
    .main-form input[type="text"]::placeholder {
        color: #cccccc;
        font-style: italic;
    }
    .form-title {
        font-family: Arial;
        margin-top: 40px !important;
        margin-bottom: 25px !important;
        span {
            font-size: 26pt;
            font-weight: 700;
            color: #aaa;
            margin-left: 50% !important;
            left: -151px !important;
            position: relative;
        }
    }
    .main-form {
        width: 1000px !important;
        position: relative;
        margin-left: 50% !important;
        left: -500px !important;
        top: 60px;
    }
    .form-header {
        height: 200px !important;
        max-width: 100% !important;
        width: 100% !important;
    }
    div.header-form {
        height: 60px !important;
        max-width: 100% !important;
        width: 100% !important;
        position: fixed !important;
        top: 0px;
        left: 0px;
        z-index: 1;
        box-shadow: 0 4px 4px -1px #999999;
        -moz-box-shadow: 0 4px 4px -1px #999999;
        -webkit-box-shadow: 0 4px 4px -1px #999999;
        div,
        .comp-logo-container {
            width: 1000px;
            position: relative;
            margin: 0 auto;
            span {
                width: 223px !important;
                position: relative;
                top: 12px !important;
                left: -7px !important;
                z-index: 1;
                color: #ffffff;

                font-size: 18px;
                text-transform: uppercase;
                font-weight: 700;
                line-height: 29px;
            }
            .comp-logo {
                width: 108px;
            }
        }
    }
    .main-page {
        top: 0px;
        left: 0px !important;
        position: relative;
    }
    .loading-indicator-container {
        position: absolute !important;
        left: 320px;
        top: 0px !important;
    }
    .loading-indicator {
        position: relative;
    }
    .stacktable {
        margin-left: 15px !important;
        margin-right: 15px !important;
        margin-top: 15px !important;
        thead.thead-default tr th {
            background-color: #50ae55 !important;
            color: #ffffff !important;
        }
    }
    .proficiency-width {
        max-width: 150px !important;
    }
    .flex-sm-column-reverse {
        margin-left: 5px !important;
        margin-right: 5px !important;
    }
    .custom-control-label {
        cursor: pointer;
    }
    div > label.custom-control-label::after {
        left: -23px !important;
    }
    .nav-link.active {
        font-weight: 600 !important;
    }
    .this-icon {
        font-size: 20px !important;
    }
    .content-row {
        width: auto;
        /*padding-right: 15px;
                    padding-top: 15px!important;*/
        margin-bottom: 10px !important;
    }
    .content-placeholder {
        overflow-y: scroll;
        overflow-x: hidden;
        height: 570px !important;
    }
    .content-header-text {
        font-size: 10pt;
        font-weight: 400;
    }
    .content-header {
        padding-top: 15px !important;
    }
    .bottom-border {
        border-bottom: 1px solid #eeeeee;
    }
    .margin-top {
        margin-top: 15px;
    }
    .margin-bottom-zero {
        margin-bottom: 0px !important;
    }
    .padding-bottom {
        padding-bottom: 25px;
    }
    .custom-control.custom-checkbox {
        margin-top: 0.7em;
    }
</style>

<script type="text/javascript">
    //Components
    import OAuth from "@common/oauth/OAuth";
    import SubmitButton from '@components/form/button.vue';

    //Mixins
    import LoaderMixin from "@common/mixin/LoaderMixin";

    //Models
    import { User } from "@common/model/User";

    import { mapGetters, mapActions } from "vuex";
    import _ from "lodash";
    import jQuery from "jquery";

    export default {
        directives: {},
        components: {
            OAuth,
            SubmitButton,
        },
        mixins: [
            LoaderMixin,
        ],
        data() {
            return {
                qHide: {
                    controlShow: false
                },
                controlTabs: {
                    general: "is-primary",
                    opened: "is-primary",
                    closed: "is-closed is-dark"
                },
                loadingData: true,
                loadingBtn: false,
                formDelimeter: '_',
                formResponse: {}
            };
        },
        computed: {
            ...mapGetters({
                organizationShortNameAllCaps: "appSettings/getShortNameTextAllCaps",
                fullScaleLogo: "appSettings/getFullScaleLogo",
                allQuestions: "allQuestions/data"
            })
        },
        mounted() {
            this.hideLoader();
        },
        async created() {
            await this.generateToken(true);
            await this.getAllQuestions({
                query: {
                    take: 100
                }
            });
            this.loadingData = false;
            await this.generateToken(false);
        },
        methods: {
            ...mapActions({
                setAuth: "auth/setAuthData",
                getAllQuestions: "allQuestions/getAllQuestions",
                saveResponses: "allQuestionResponses/saveResponses",
                setAuth: "auth/setAuthData"
            }),
            controlQuestion(qid, sequence) {
                if (qid == 11){
                    if (sequence == 1){
                        this.qHide.controlShow = true;
                    } else if (sequence == 2) {
                        this.qHide.controlShow = false;
                    }
                }
            },
            questionShowOrHide(qId) {
                let qIds = [12, 13]; // this is the ids included in hidding questions

                return qIds.includes(qId) ? this.qHide.controlShow : true;
            },
            controlTab(tab, toggle = true, opened = true) {
                if (toggle) {
                    this.controlTabs[tab] =
                        this.controlTabs[tab] === this.controlTabs.opened
                            ? this.controlTabs.closed
                            : this.controlTabs.opened;
                } else {
                    this.controlTabs[tab] = opened
                        ? this.controlTabs.opened
                        : this.controlTabs.closed;
                }
            },
            rightPlaceholder(form_label) {
                let placeholder = 'Enter here';

                if (form_label == 'company_name') {
                    placeholder = 'example: My Company LLC';
                } else if (form_label == 'business_address') {
                    placeholder = 'Street Name, City, State, Zip Code';
                } else if (form_label == 'business_phone') {
                    placeholder = 'Enter phone/mobile number';
                } else if (form_label == 'primary_contact') {
                    placeholder = 'Enter name';
                } else if (form_label == 'email_address_primary_contact') {
                    placeholder = 'Enter email address';
                }

                return placeholder;
            },
            closeDialog() {
                this.loadingBtn = false;
                this.$router.push("/thankyou");
            },
            setResponses() {
                let self = this;
                let results = [];

                _.each(self.formResponse, function(response, key) {// `choice` can be an object or string or false
                    let [qId, qIdx, cId]   = key.split(self.formDelimeter);
                    let question           = self.allQuestions[qIdx];
                    let qCategory          = question.questionCategory.data;

                    if (_.isEmpty(response)) {
                        return;
                    }

                    results.push({
                        "all_question_category_id":         qCategory.id,
                        "all_question_category_name":       qCategory.name,
                        "all_question_id":                  question.id,
                        "all_question_description":         question.description,
                        "all_question_type":                question.type,
                        "all_question_form_label":          question.form_label,
                        "all_question_choice_id":           (typeof response === 'object') ? response.id : null, // `response` is object of choices if not input text response type
                        "all_question_choice_description":  (typeof response === 'object') ? response.description : null,
                        "response":                         (typeof response === 'object') ? null : response,
                    });
                });

                return results;
            },
            async save() {
                let self = this;
                let responses = this.setResponses();

                this.loadingBtn = true;
                await this.generateToken(true);
                await this.saveResponses(responses).then(res => {
                    self.closeDialog();
                }).catch(e => {
                    self.loadingBtn = false;
                });
                await this.generateToken(false);
            },
            async generateToken(flag) {
                let self = this;
                if (flag) {
                    await OAuth.tokenize().then(response => {
                        self.loading = false;
                        if (response == true) {
                            self.invalid = false;
                            User.me(true).then(res => {
                                // redirect to dashboard
                                self.setAuth(res);
                            });
                        } else {
                            this.$router.push("/login");
                        }
                    });
                } else {
                    await OAuth.logout().then(() => {
                        let $ = jQuery;
                        $(document).ready(function() {
                            setTimeout(function() {
                                localStorage.removeItem("vuex");
                                localStorage.removeItem("auth_token");
                            }, 300);
                        });
                    });
                }
            },
            setColumns(rows) {
                let count = rows.length;
                let klass = '';

                if (count > 10 && count < 30) {
                    klass = 'columns: 2;';
                } else if (count > 30) {
                    klass = 'columns: 3;';
                } else {
                    klass = '';
                }

                return klass;
            },
            groupQuestionAnswers(question) {
                let list        = [];
                let groups      = [];
                let results     = [];
                let groupName   = "";
                let others      = "Others";
                let choices     = question.questionChoices.data;

                if (question.group_choices) {
                    choices.forEach(value => {
                        groupName = value.group[0];
                        if (!_.isUndefined(groupName)) {
                            if (_.indexOf(groups, groupName) < 0) {
                                groups.push(groupName);
                            }
                        }

                        groups.sort();
                        groups = groups.filter((name) => { return name != others });
                        groups.push(others);
                    });

                    groups.forEach(group => {
                        list = _.filter(choices, (choice) => { return choice.group[0] === group });
                        results.push({ group_name: group, choices: _.sortBy(list, 'description') });
                    });
                }

                return results;
            }
        }
    };
</script>
