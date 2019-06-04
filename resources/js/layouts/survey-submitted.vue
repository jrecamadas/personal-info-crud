<template>
    <div class="s-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light main-page">
        <div class="header-form bg-info">
            <div>
                <!--<span>FULLSCALE</span>-->
            </div>
        </div>

        <div class="main-form">
            <div>
                <img src="/images/fs-logo.png" />
            </div>
            <div class="form-title">
                <span>
                    Thank you for your feedback. This confirms that we've received your information.
                </span>
            </div>

        </div>
    </div>
</template>

<style type="text/css">
    body{
        padding-top: 0px!important;
    }
    div.modal-backdrop > div.modal{
        overflow: visible!important;
    }
</style>
<style lang="scss" scoped>
    .applicant-agreement{
        padding-left: 40px;
    }
    .submit-button-container{
        width: 1000px;
        position: relative;
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-right: 15px;
        margin-bottom: 50px;
        height: 200px;
        button{
            float: right;
            margin-top: 35px!important;
        }
    }
    .card-header{
        h4{
            position: relative;
            margin-top: 7px!important;
        }
    }
    .form-title{
        margin-top: 90px!important;
        margin-bottom: 25px!important;
        position: relative;
        left: 2px;
        span{
            font-size: 17pt;
            font-weight: 700;
            color: #444;
            position: relative;
        }
    }
    .main-form{
        width: 1000px!important;
        position: relative;
        margin-left: 50%!important;
        left: -500px!important;
        top: 60px;
        img{
            position: relative;
            margin-left: 50%!important;
            width: 320px;
            left: -160px!important;
            padding-top: 40px!important;
        }
    }
    .form-header{
        height: 200px!important;
        max-width: 100%!important;
        width: 100%!important;
    }
    div.header-form{
        height: 60px!important;
        max-width: 100%!important;
        width: 100%!important;
        position: fixed!important;
        top: 0px;
        left: 0px;
        z-index: 1;
        box-shadow: 0 4px 4px -1px #999999;
        -moz-box-shadow: 0 4px 4px -1px #999999;
        -webkit-box-shadow: 0 4px 4px -1px #999999;
        div{
            width: 1000px;
            position: relative;
            margin-left: 50%;
            left: -500px!important;
            span{
                width: 223px!important;
                position: relative;
                top: 12px!important;
                left: -7px!important;
                z-index: 1;
                color: #FFFFFF;

                font-size: 18px;
                text-transform: uppercase;
                font-weight: 700;
                line-height: 29px;
            }
        }
    }
    .main-page{
        top: 0px;
        left: 0px!important;
        position: relative;
    }
    .loading-indicator-container{
        position: absolute!important;
        left: 320px;
        top: 0px!important;
        /*float: left!important;
        display: inline!important;
        left: 210px!important;
        margin-top: 6px;*/
    }
    .loading-indicator{
        position: relative;
        z-index: 2!important;
    }
    .abroad{
        margin-top: 5px!important;
    }
    .custom-shift {
        display: flex;
        flex-direction: row;
        margin-top: 10px;
    }
    .custom-shift .time-selection:first-child {
        margin-right: 10px;
    }
    tr > td.weVal > label{
        position: relative;
        top: 5px;
        cursor: pointer;
        color: #585858;
    }
    .education-actions{
        font-size: 20px!important;
        padding-left: 23px!important;
        :hover{
            color: #ab2424;
        }
    }
    .work-experience-actions{
        font-size: 20px!important;
        padding-left: 23px!important;
        :hover{
            color: #ab2424;
        }
    }
    .work-experience-buttons-placeholder{
        margin-left: 0px!important;
    }
    .stacktable{
        margin-left: 15px!important;
        margin-right: 15px!important;
        margin-top: 15px!important;
        thead.thead-default tr th{
            background-color: #50ae55!important;
            color: #ffffff!important;
        }
    }
    .proficiency-width{
        max-width: 150px!important;
    }
    .flex-sm-column-reverse{
        margin-left: 5px!important;
        margin-right: 5px!important;
    }
    .skill-item{
        top: 7px!important;
        position: relative;
    }
    .custom-control-label.noselect{
        margin-bottom: 3px!important;
    }
    div > label.custom-control-label::after{
        left: -23px !important;
    }
    .nav-link.active{
        font-weight: 600!important;
    }
    .skills-and-proficiencies > .col-lg-6 > span{
        top: 5px!important;
        position: relative;
    }
    .skills-and-proficiencies-wrapper {
        display: flex;
        flex-direction: column;
        margin-top: 20px;
        h5 {
            padding-top: 10px;
        }
    }
    .skills-and-proficiencies {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .address-wrapper {
        margin: 6px 0;
        &.flex {
            display: flex;
            flex-direction: row;
            font-size: 12px;
            input:first-child {
                margin-right: 5px;
            }
            &.link {
                cursor: pointer;
            }
        }
    }
    .this-icon{
        font-size: 20px!important;
    }
    .skills-box{
        border: 1px solid #eeeeee;
    }
    .content-row{
        width: auto;
        /*padding-right: 15px;
        padding-top: 15px!important;*/
        margin-bottom: 10px!important;
    }
    .content-placeholder{
        overflow-y: scroll;
        overflow-x: hidden;
        height: 570px!important;
    }
    .content-header-text{
        font-size: 10pt;
        font-weight: 400;
    }
    .content-header{
        padding-top: 15px!important;
    }
    .bottom-border{
        border-bottom: 1px solid #eeeeee;
    }
    .margin-top{
        margin-top: 15px;
    }
    .margin-bottom-zero{
        margin-bottom: 0px!important;
    }
    .padding-bottom{
        padding-bottom: 25px;
    }
</style>

<script type="text/javascript">

    import { SurveySubmittedNotification } from '@common/model/client-feedback/SurveySubmittedNotification';

    import { mapGetters } from 'vuex';

    export default {
        computed : {
            ...mapGetters({
                organizationShortName: 'appSettings/getShortNameText',
            }),
        },

        async created() {
            const responder = this.$route.params && this.$route.params.responder ? this.$route.params.responder.data : null;

            if(responder) {
                const responderData = {
                    id: responder.id,
                    name: responder.contactName,
                    link: responder.surveyLink,                
                }                
                SurveySubmittedNotification.get(responderData);
            }
        }
    }
</script>
