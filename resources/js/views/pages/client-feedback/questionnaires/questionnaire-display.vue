<template>
    <div class="client-feedback">
        <div class="row">
            <div class="col-sm-12">
                <p class="message" v-if="isResult">survey results</p>
                <p class="message" v-else>thank you</p>
            </div>

            <div class="save-for-later-container" v-if="!isResult">
                <notifications 
                    group="save-for-later" 
                    position="top center" 
                    width="250"
                />
            </div>
        </div>
        <br />
        <br />      
        
        <div class="row" v-if="isResult && (previousLink || nextLink)">
            <div class="col-sm-8 offset-sm-2 previous-next-btn">
                <button @click="goToLink(previousLink)" v-bind:class="previousLink == null ? 'hidden' : ''">&lt;&lt; PREVIOUS</button>
                <button @click="goToLink(nextLink)" v-bind:class="nextLink == null ? 'hidden' : ''">NEXT &gt;&gt;</button>
            </div>
        </div>  

        <div class="survey-result-summary-container" v-if="isResult">
            <table class="table table-stripe survey-result-summary">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center">Client Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Respondent Name:</td>
                        <td>{{ responder.name }}</td>
                    </tr>
                    <tr>
                        <td>Respondent Email:</td>
                        <td>{{ responder.email }}</td>
                    </tr>
                    <tr>
                        <td>Company:</td>
                        <td>{{ responder.company }}</td>
                    </tr>
                    <tr>
                        <td>Project:</td>
                        <td>{{ responder.project }}</td>
                    </tr>
                    <tr>
                        <td>Date Sent:</td>
                        <td>{{ responder.dateSent }}</td>
                    </tr>
                    <tr>
                        <td>Date Responded:</td>
                        <td>{{ responder.dateResponded }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else>
            <p class="instructions">We'd like you to ask for your feedback. Your inputs are very important for us to keep improving. <br/>
                This should take about 6 to 8 minutes to finish
            </p>
        </div>

        <div class="star-rating-legend-container">
            <div v-for="x in 5" :key="x" class="scale" style="display:inline-block;">
                <h5>
                    <span v-for="y in 5" :key="y">
                        <img v-if="x >= y" src="/images/active-star.png" class="message legend" />
                        <img v-else src="/images/inactive-star.png" class="message legend" />
                    </span>
                </h5>
                <span v-if="x == 1">Very dissatisfied</span>
                <span v-if="x == 2">Dissatisfied</span>
                <span v-if="x == 3">Satisfied</span>
                <span v-if="x == 4">Very Satisfied</span>
                <span v-if="x == 5">Outstanding</span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table feedback">
                            <template v-for="q in questions" >
                            <tr :key="q.name" v-if="q.items.length > 0">
                                <td class="category" colspan="2">{{q.name}}</td>
                            </tr>
                            <tr v-for="i in q.items" :key="i.id">
                                <td class="question">{{i.name}}</td>
                                <td class="rating">
                                    <span>
                                        <a v-for="n in i.rating" @click.prevent="updateRating(i, n)" href="#" :key="n+i.id">
                                            <img src="/images/active-star.png" class="btn-rating" width="35" height="35" alt="" />
                                        </a>
                                        <a v-for="n in 5 - i.rating" @click.prevent="updateRating(i, n + i.rating)" href="#" :key="n+i.rating+i.id">
                                            <img src="/images/inactive-star.png" class="btn-rating" width="35" height="35" alt="" />
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            </template>
                            <tr>
                                <td class="category" colspan="2">What could we have done better?</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea class="userRemarks" placeholder="Please type your comments here." :readonly="readonly" v-model="userRemarks"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div v-if="!readonly" class="row">
                    <div class="col-sm-12 text-center save-for-later-submit-btn">
                        <span>
                            <button class="save-for-later text-white" @click="saveOrSubmit('save', $event)">SAVE FOR LATER</button>
                        </span>
                        <button class="submit" @click="saveOrSubmit('submit')">SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="footer">
                    <img src="/images/footer-logo.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>

    .row {
        margin-right: 0 !important;
        margin-left: 0 !important;
    }
    .col-sm-12 {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }
    .scale {
        text-align: center;
        font-size: 15px;
        margin: 0 10px;
    }

    .rating {
       padding: 10px 10px 5px 10px!important;
    }

    .rating > span {
        display: inline-block;
        overflow: auto;
    }

    .rating > span > a {
        float:left;
        margin: 0 2px;
    }

    .star-rating-legend-container {
        max-width: 1000px;
        text-align: center;
        margin: 0 auto 20px auto;
    }

    .survey_reponse_info > table tr th:first-child {
        width: 30%;
        color: #007840;
    }

    .survey_reponse_info > table tr th:last-child {
        width: 70%;
    }

    table tr td:first-child {
        width: 70%;
    }

    table tr td:last-child {
        width: 30%;
    }

    .btn-rating.highlighted, .btn-rating.highlighted.selected {
      content: url("/images/active-star.png");
    }

    .instructions {
        text-align: center!important;
        font-size: 17px!important;
        margin-bottom: 50px;
    }

    .message.legend {
        width: 15px;
        height: 15px;
        display: inline-block; 
        margin-right:2px
    }

    .client-feedback p.message {
        padding: 10px;
    }

    .client-feedback button.submit {
        width: 157px;
        margin: auto;
        display: inline-block;
        padding: 6px;
    }

    .survey_reponse_info {
        font-size: initial;
        margin-bottom: 50px;
    }

    .survey_reponse_info p{
        font-size: 15px;
        font-weight: bold;
    }

    .survey_reponse_info p span{
        color: #007840;
    }

    .footer {
        padding: 20px;
    }

    .save-for-later-container {
        display: block;
        width: 100%;
        text-align: center;
    }

    .save-for-later-submit-btn {
        margin: -100px auto 146px auto;
    }

    .save-for-later {
        display: inline-block;
        padding: 6px;
        font-size: 25px;
        width: 235px;
        margin: 0 auto 0 auto;
        background-color: #e67918;
        border: none;
    }

    button[disabled] {
        background-color: #ffaa5e
    }

    .previous-next-btn {
        margin-bottom: 50px;
    }

    .previous-next-btn > button {
        border-style: none;
        background-color: #1c5f0f;
        color: #ffffff;
        font-size: 18px;
        width: 135px;
        padding: 5px;
    }

    .previous-next-btn > button:first-child {
        float: left;
    }

    .previous-next-btn > button:last-child {
        float: right;
    }

    .previous-next-btn > button.hidden {
        visibility: hidden;
    }

    a {
        cursor: default;
    }

    div.survey-result-summary-container {
        max-width: 760px;
        margin: 0 auto 70px auto;
        padding: 5px 50px;
    }

    table.survey-result-summary {
        display: block;
        max-width: 740px;
        border: 1px solid #c5c5c5;
        border-top-style: none;
    }

    .table-stripe thead tr {
        background-color: #007840;
    }

    .table-stripe thead tr th {
        font-size: 19px;
        color: #ffffff;
    }

    .table-stripe tbody tr:nth-child(even) td:first-child{
        background: #ffffff;
      
    }

   .table-stripe tbody tr:nth-child(odd) td:first-child{
        background: #f7f7f7;
    }

    .table-stripe tbody tr:nth-child(even) td:last-child{
        background: #e2e2e2;
      
    }

   .table-stripe tbody tr:nth-child(odd) td:last-child{
        background: #d4d4d4;
    }

    table.survey-result-summary tr th{
        min-width: 200px!important;
    }

    table.survey-result-summary tr td {
       width: 500px!important;
    }

   

    @media screen and (max-width: 910px){
        body {
            background-color:red;
        }
        .scale {
            display: block!important;
            margin-bottom: 15px!important;
        }
    }

    @media screen and (max-width: 1145px){
        .btn-rating {
            width: 30px;
            height: 30px;
        }
    }

    @media screen and (max-width: 1020px){
        .btn-rating {
            width: 25px;
            height: 25px;
        }
    }

    @media screen and (max-width: 900px){
        .btn-rating {
            width: 20px;
            height: 20px;
        }
    }

    @media screen and (max-width: 768px){
        .btn-rating {
            width: 18px;
            height: 18px;
        }

        table tr td:first-child {
            width: 47%;
        }

        table tr td:last-child {
            width: 53%;
        }
    }

    @media screen and (max-width: 654px){
        .save-for-later {
            margin: 0 auto 10px auto;
        }
        .client-feedback button.submit {
            width: 235px;
        }
    }
</style>

<script>
//  comment
    // stylesheets
    import Vue from 'vue';
    import Notifications from 'vue-notification'
    import '../../../../../sass/client-feedback/preview.scss';
    import 'jquery';

    Vue.use(Notifications);

    export default {
        props: {
            questions: {
                type: Array,
                default: []
            },
            responder: {
                type: Array,
                default: () => [],
            },
            remarks: {
                type: String,
                default: ''
            },
            readonly: {
                type: Boolean,
                default: false
            },
            isResult: {
                type: Boolean,
                default: false
            },
            previousLink: {
                type: String,
                default: ''
            },
            nextLink: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                saveAction: true,
                userRemarks: (this.readonly) ? (this.remarks != null) ? this.remarks : "No comment" : this.remarks,
            };
        },
        mounted(){
            $('.save-for-later').attr('disabled', 'disabled');
            if (!this.readonly){
                $('.btn-rating').mouseover(function() {
                    $(this).addClass('highlighted');
                    $(this).parent().prevAll().children().addClass('highlighted');
                    $(this).click(function() {
                        $(this).addClass('selected');
                        $(this).parent().prevAll().children().addClass('selected');
                        $(this).parent().nextAll().children().removeClass('selected');

                        $('.save-for-later').removeAttr('disabled');
                    })
                });

                $('.btn-rating').mouseout(function() {
                    $(this).removeClass('highlighted');
                    $(this).parent().prevAll().children().removeClass('highlighted');
                });

                $(".userRemarks").keyup(function() {
                    $('.save-for-later').removeAttr('disabled');
                });

                $('.btn-rating').css('cursor', 'pointer');
            }

            $('body').removeClass('ks-navbar-fixed');
        },

        methods: {
            updateRating(item, newRating) {
                this.$emit('updateRating', item, newRating);
            },
            async saveOrSubmit(action, event) {
                await this.$emit('saveOrSubmit', this.userRemarks, action);
                
                setTimeout(()=>{
                    if(action == 'save') {
                        this.$notify({
                            group: 'save-for-later',         
                            text: 'Survey response saved!'
                        });
                        event.target.disabled = true; 
                    }
                }, 1000)
            },
            goToLink(link) {
                window.location.href = '/survey/responses/'+ link;
            }
        }
    };
</script>
