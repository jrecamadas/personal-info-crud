<template>
    <div class="row client-on-boarding-checklist">
        <div class="col-sm-12 col-md-12 px-0">
            <h3>Client On-board Checklist</h3>
            <div class="wizard-progress">
                <div class="step" :class="contractSigned">
                    Contract Signed
                    <div class="node contract_signed" @click="!client.contract_signed ? wizardStatus($event, 'contract_signed') : null" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>

                <div class="step" :class="initialDeposit">
                    Initial Deposit
                    <div class="node initial_deposit" @click="!client.initial_deposit ? wizardStatus($event, 'initial_deposit') : null" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>

                <div class="step" :class="startGuide">
                    Client Start Guide
                    <div class="node client_start_guide" @click="!client.start_guide ? wizardStatus($event, 'client_start_guide') : null" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>

                <div class="step" :class="introductoryCall">
                    Introductory Call
                    <div class="node introductory_call" @click="!client.introductory_call ? wizardStatus($event, 'introductory_call') : null" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>

                <div class="step" :class="teamEmailsSent">
                    Team Emails to Clients
                    <div class="node team_emails_sent" @click="!client.team_emails_sent ? wizardStatus($event, 'team_emails_sent') : null" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>

                <div class="step" :class="firstWeekCheckup">
                    First Week Checkup
                    <div class="node first_week_check_up" @click="!client.first_week_check_up ? wizardStatus($event, 'first_week_check_up') : null" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>
                <div class="step" :class="firstMonthCheckup">
                    First Month Checkup
                    <div class="node first_month_check_up" @click="!client.first_month_check_up ? wizardStatus($event, 'first_month_check_up') : null" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .client-on-boarding-checklist {
        margin: 40px 0!important;
    }
    .client-on-boarding-checklist h3 {
        margin-bottom: 30px;
    }
    .wizard-progress {
        display: table;
        width: 100%;
        table-layout: fixed;
        position: relative;
    }

    .wizard-progress > .in-progress > .node {
        cursor: pointer;
    }

    .wizard-progress .step {
        display: table-cell;
        text-align: center;
        vertical-align: top;
        overflow: visible;
        position: relative;
        font-size: 14px;
        color: #000;
        font-weight: bold;
    }
    .wizard-progress .step:not(:last-child):before {
        content: '';
        display: block;
        position: absolute;
        left: 52%;
        top: 31px;
        background-color: #dee0e1;
        height: 6px;
        width: 100%;
    }
    .wizard-progress .step .node {
        display: inline-block;
        border: 6px solid #dee0e1;
        background-color: #dee0e1;
        border-radius: 18px;
        height: 18px;
        width: 18px;
        position: absolute;
        top: 25px;
        left: 50%;
    }
    .wizard-progress .step.complete:before {
        background-color:#4fb164;
    }
    .wizard-progress .step.complete .node {
        border-color:#4fb164;
        background-color:#4fb164;
    }
    .wizard-progress .step.complete .node:before {
        font-family: FontAwesome;
        content: "\f00c";
        color: #fff;
        position: absolute;
        top: -7px;
        left: -4px;
    }
    /* .wizard-progress .step.in-progress:before {
        background: #dee0e1;
        background: -moz-linear-gradient(left, #07c 0%, #fff 100%);
        background: -webkit-linear-gradient(left, #07c 0%, #fff 100%);
        background: linear-gradient(to right,#4fb164 0%, #fff 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(     startColorstr='#dee0e1', endColorstr='#fff',GradientType=1 );
    } */
    .wizard-progress .step.in-progress .node {
        border-color: #4fb164;
    }

    /* Device = Desktop */
    @media (min-width: 1281px) and (max-width: 1980px) {
        .wizard-progress .step:not(:last-child):before {
            left: 55%;
            top: 45px;
        }

        .wizard-progress .step .node {
            top: 39px;
            left: 50%;
        }
    }

    /* Device = Laptops and Desktops */
    @media (min-width: 1025px) and (max-width: 1280px) {
        .wizard-progress .step:not(:last-child):before {
            left: 55%;
            top: 45px;
        }

        .wizard-progress .step .node {
            top: 39px;
            left: 50%;
        }
    }

    /* Device = Tablets, Ipads -> Portrait*/
    @media (min-width: 768px) and (max-width: 1024px) {
        .wizard-progress .step:not(:last-child):before {
            left: 58%;
            top: 45px;
        }

        .wizard-progress .step .node {
            top: 39px;
            left: 50%;
        }
    }

    /* Device = Tablets, Ipads -> Landscape */
    @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
        .wizard-progress .step:not(:last-child):before {
            left: 57%;
            top: 45px;
        }

        .wizard-progress .step .node {
            top: 39px;
            left: 50%;
        }
    }

    /* Device = Low Resolution Tablets, Mobiles -> Landscape */
    @media (min-width: 481px) and (max-width: 767px) {
        .wizard-progress .step:not(:last-child):before {
            left: 59%;
            top: 45px;
        }

        .wizard-progress .step .node {
            top: 39px;
            left: 50%;
        }
    }

    /* Device = Smartphone -> Portrait */
    @media (min-width: 320px) and (max-width: 480px) {
        .wizard-progress .step:not(:last-child):before {
            left: 50%;
            top: 45px;
        }

        .wizard-progress .step .node {
            top: 39px;
            left: 50%;
        }
    }
</style>

<script>
import { Client } from '@common/model/Client';
import { mapActions, mapGetters } from 'vuex';
import jQuery from 'jquery';

export default {
    data() {
        return {
            checklistStep: 0,
            tooltipText: '',
            step: 'start'
        }
    },
    methods: {
        ...mapActions({
            getClient: 'clients/getClient'
        }),
        wizardStatus($event, step) {
            let $ = jQuery;
            let self = this;

            // Make sure DOM is ready;
            // tooltip is triggered through jQuery.
            $(function() {
                if(step == 'contract_signed') {
                    if(!self.client.contract_signed) {
                        self.updateStatus({id: self.client.id, company: self.client.company, contract_signed: 1});
                        self.initTitle('initial_deposit');
                        $('.'+self.step)
                            .attr('title', '')
                            .attr('data-original-title', '');
                    } else {
                        self.updateStatus({id: self.client.id, company: self.client.company, contract_signed: 0});
                    }
                } else if(step == 'initial_deposit') {
                    if(self.client.contract_signed) {
                        if(!self.client.initial_deposit) {
                            self.updateStatus({id: self.client.id, company: self.client.company, initial_deposit: 1});
                            self.initTitle('client_start_guide');
                            $('.'+self.step).attr('data-original-title', '');
                        } else {
                            self.updateStatus({id: self.client.id, company: self.client.company, initial_deposit: 0});
                        }
                    } else {
                        $('.node').tooltip('hide');
                        self.tooltipText = 'Please check this first';
                        $('.'+self.step)
                            .attr('data-original-title', self.tooltipText)
                            .tooltip('show');

                        setTimeout(function() {
                            $('.'+self.step).tooltip('hide').attr('data-original-title','Click to check.');
                        }, 1000);
                    }
                } else if(step == 'client_start_guide') {
                    if(self.client.initial_deposit) {
                        if(!self.client.start_guide) {
                            self.updateStatus({id: self.client.id, company: self.client.company, start_guide: 1});
                            self.initTitle('introductory_call');
                            $('.'+self.step).attr('data-original-title', '');
                        } else {
                            self.updateStatus({id: self.client.id, company: self.client.company, start_guide: 0});
                        }
                    } else {
                        $('.node').tooltip('hide');
                        self.tooltipText = 'Please check this first';
                        $('.'+self.step)
                            .attr('data-original-title', self.tooltipText)
                            .removeProp('title')
                            .tooltip('show');

                        setTimeout(function() {
                            $('.'+self.step).tooltip('hide').attr('data-original-title','Click to check.');
                        }, 1000);
                    }
                } else if(step == 'introductory_call') {
                    if(self.client.start_guide) {
                        if(!self.client.introductory_call) {
                            self.updateStatus({id: self.client.id, company: self.client.company, introductory_call: 1});
                            self.initTitle('team_emails_sent');
                            $('.'+self.step).attr('data-original-title', '');
                        } else {
                            self.updateStatus({id: self.client.id, company: self.client.company, introductory_call: 0});
                        }
                    } else {
                        $('.node').tooltip('hide');
                        self.tooltipText = 'Please check this first';
                        $('.'+self.step)
                            .attr('data-original-title', self.tooltipText)
                            .removeProp('title')
                            .tooltip('show');

                        setTimeout(function() {
                            $('.'+self.step).tooltip('hide').attr('data-original-title','Click to check.');
                        }, 1000);
                    }
                } else if(step == 'team_emails_sent') {
                    if(self.client.introductory_call) {
                        if(!self.client.team_emails_sent) {
                            self.updateStatus({id: self.client.id, company: self.client.company, team_emails_sent: 1});
                            self.initTitle('first_week_check_up');
                            $('.'+self.step).attr('data-original-title', '');
                        } else {
                            self.updateStatus({id: self.client.id, company: self.client.company, team_emails_sent: 0});
                        }
                    } else {
                        $('.node').tooltip('hide');
                        self.tooltipText = 'Please check this first';
                        $('.'+self.step)
                            .attr('data-original-title', self.tooltipText)
                            .removeProp('title')
                            .tooltip('show');

                        setTimeout(function() {
                            $('.'+self.step).tooltip('hide').attr('data-original-title','Click to check.');
                        }, 1000);
                    }
                }  else if(step == 'first_week_check_up') {
                    if(self.client.team_emails_sent) {
                        if(!self.client.first_week_check_up) {
                            self.updateStatus({id: self.client.id, company: self.client.company, first_week_check_up: 1});
                            self.initTitle('first_month_check_up');
                            $('.'+self.step).attr('data-original-title', '');
                        } else {
                            self.updateStatus({id: self.client.id, company: self.client.company, first_week_check_up: 0});
                        }
                    } else {
                        $('.node').tooltip('hide');
                        self.tooltipText = 'Please check this first';
                        $('.'+self.step)
                            .attr('data-original-title', self.tooltipText)
                            .removeProp('title')
                            .tooltip('show');

                        setTimeout(function() {
                            $('.'+self.step).tooltip('hide').attr('data-original-title','Click to check.');
                        }, 1000);
                    }
                } else if(step == 'first_month_check_up') {
                    if(self.client.first_week_check_up) {
                        if(!self.client.first_month_check_up) {
                            self.updateStatus({id: self.client.id, company: self.client.company, first_month_check_up: 1});
                            $('.'+self.step).attr('data-original-title', '');
                        } else {
                            self.updateStatus({id: self.client.id, company: self.client.company, first_month_check_up: 0});
                        }
                    } else {
                        $('.node').tooltip('hide');
                        self.tooltipText = 'Please check this first';
                        $('.'+self.step)
                            .attr('data-original-title', self.tooltipText)
                            .removeProp('title')
                            .tooltip('show');

                        setTimeout(function() {
                            $('.'+self.step).tooltip('hide').attr('data-original-title','Click to check.');
                        }, 1000);
                    }
                }
            });
        },
        async updateStatus(data) {
            let client = new Client({id: data.id});
            client.save(data).then((res) => {
                this.getClient(this.$route.params.id);
            });
        },
        initTitle(step) {
            let $ = jQuery;
            $('.'+step).attr('data-original-title', 'Click to check.');
            // $('.contract_signed').attr('data-original-title', this.client.contract_signed ? '': 'Click to check.');
            // $('.initial_deposit').attr('data-original-title', this.client.initial_deposit ? '': 'Click to check.');
            // $('.client_start_guide').attr('data-original-title', this.client.start_guide ? '': 'Click to check.');
            // $('.introductory_call').attr('data-original-title', this.client.introductory_call ? '': 'Click to check.');
            // $('.team_emails_sent').attr('data-original-title', this.client.team_emails_sent ? '': 'Click to check.');
            // $('.first_week_check_up').attr('data-original-title', this.client.first_week_check_up ? '': 'Click to check.');
            // $('.first_month_check_up').attr('data-original-title', this.client.first_month_check_up ? '': 'Click to check.');
        }
    },
    computed: {
        ...mapGetters({
            client:'clients/client',
            meta:'clients/meta'
        }),
        contractSigned() {
            if(this.client.contract_signed) {
                this.step = 'initial_deposit';
                return 'complete';
            } else {
                this.step = 'contract_signed';
                return 'in-progress';
            }
        },
        initialDeposit() {
            if(this.client.contract_signed) {
                if(this.client.initial_deposit) {
                    this.step = 'client_start_guide';
                    return 'complete';
                } else {
                    this.step = 'initial_deposit';
                    return 'in-progress';
                }
            } else {
                return '';
            }
        },
        startGuide() {
            if(this.client.initial_deposit) {
                if(this.client.start_guide) {
                    this.step = 'introductory_call';
                    return 'complete';
                } else {
                    this.step = 'client_start_guide';
                    return 'in-progress';
                }
            } else {
                return '';
            }
        },
        introductoryCall() {
            if(this.client.start_guide) {
                if(this.client.introductory_call) {
                    this.step = 'team_emails_sent';
                    return 'complete';
                } else {
                    this.step = 'introductory_call';
                    return 'in-progress';
                }
            } else {
                return '';
            }
        },
        teamEmailsSent() {
            if(this.client.introductory_call) {
                if(this.client.team_emails_sent) {
                    this.step = 'first_week_check_up';
                    return 'complete';
                } else {
                    this.step = 'team_emails_sent';
                    return 'in-progress';
                }
            } else {
                return '';
            }
        },
        firstWeekCheckup() {
            if(this.client.team_emails_sent) {
                if(this.client.first_week_check_up) {
                    this.step = 'first_month_check_up';
                    return 'complete';
                } else {
                    this.step = 'first_week_check_up';
                    return 'in-progress';
                }
            } else {
                return '';
            }
        },
        firstMonthCheckup() {
            if(this.client.first_week_check_up) {
                if(this.client.first_month_check_up) {
                    this.step = 'end';
                    return 'complete';
                } else {
                    this.step = 'first_month_check_up';
                    return 'in-progress';
                }
            } else {
                return '';
            }
        }
    },
    async created() {
        let $ = jQuery;
        $(document).ready(function() {
            $('.node').tooltip();
        });

        // make client info available at created hook.
        //await this.getClient(this.$route.params.id);
        this.initTitle(this.step);
    }
}

var checkObjectHasVal = function(object) {
    // check that object is not undefined and has value.
    return (typeof object !== 'undefined') && object;
}
</script>
