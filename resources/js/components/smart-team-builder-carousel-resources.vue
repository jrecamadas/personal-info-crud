<template>
    <div class="carousel-component">
        <h3 class="header-title">
            <span>{{ headerTitle }}</span>
            <span class="add-resource" @click="$emit('action')">
                <i class="add-icon"></i>
                Add
            </span>
        </h3>
        <div class="carousel-outer-container">
            <div v-if="loading" class="loader"></div>
            <div v-else class="carousel-middle-container">
                <div class="carousel-inner-container">
                    <carousel 
                        :per-page-custom="slidesPerPageCustom"  
                        :mouse-drag="mouseDrag" 
                        :navigation-enabled="navigationEnabled" 
                        :center-mode="centerMode"
                        :pagination-enabled="paginationEnabled"
                        :navigation-click-target-size="navigationClickTargetSize">
                        <slide v-for="(row, index) in resources" :key="index">
                            <div class="slide-wrapper">
                                <div class="fs-user-photo-container">
                                    <span class="la la-times-circle remove" @click="removeResource(row.id, row.employee.first_name + ' ' + row.employee.last_name)"></span>
                                    <div class="fs-user-photo align-self-center" :style="'background-image: url(\'' + photo(row.employee) + '\')'"></div>
                                </div>
                                <div class="emp-info" :class=" showButton ? 'has-btn-component' : '' ">
                                    <div class="emp-name">
                                        Name: <br/>
                                        <div class="three-ellipsis">
                                            <a :href="row.profile_url" target="_blank">
                                                {{ row.employee.last_name }}, {{ row.employee.first_name }} {{ row.employee.middle_name }}
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        Position: <br/>
                                        <div class="three-ellipsis">
                                            <span class="fs-position" data-trigger="hover" data-toggle="popover" :data-popover-content="'#popover-' + headerTitle.replace(/\s/g, '') + index">
                                                {{ row.positions ? row.positions : 'Unassigned' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="carousel-icons">
                                        <input :class="setEmployeeClass(row.id)" class="pcl" :value="row.profile_url"/>
                                        <a href="#" class="action-button" title="Copy Employee Profile Link" @click.prevent="copyToClipBoardInput(setEmployeeClass(row.id))">
                                            <i class="la la-copy copy-url-to-clipboard"></i>
                                        </a>
                                        <a
                                            :href="getDownloadLink(row.profile_url)"
                                            target="_blank"
                                            class="action-button"
                                            title="Download PDF">
                                            <i class="la la-file-pdf-o"></i>
                                        </a>
                                    </div>
                                    <popover-dialog :popoverId="'popover-' + headerTitle.replace(/\s/g, '') + index">
                                        <template slot="header">Skills</template>
                                        <template slot="body">
                                            <div class="popover-skill-block">
                                                <div class="resource-details-content" v-if="row.skills && row.skills.length">
                                                    <div v-for="(skill,index) in row.skills" :key="skill.id">
                                                        <div v-if="index < 5">
                                                            <div class="ks-controls resource-skill-placeholder">
                                                                <span class="resource-skill">
                                                                    {{ skill.skill.name}}
                                                                </span>
                                                                <span class="resource-level" style="float: right;">
                                                                    {{ skill.proficiency }}/10
                                                                </span>
                                                            </div>
                                                            <div class="ks-info">
                                                                <div class="progress ks-progress ks-progress-xs">
                                                                    <div class="progress-bar bg-info"
                                                                        role="progressbar"
                                                                        :style="'width: ' + (skill.proficiency * 10) + '%'"
                                                                        v-bind:aria-valuenow="skill.proficiency"
                                                                        aria-valuemin="0"
                                                                        aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="popover-no-skill">
                                                    No Skills to display
                                                </div>
                                            </div>
                                        </template>
                                    </popover-dialog>
                                </div>
                            </div>
                        </slide>
                    </carousel>
                    <div v-if="resources.length == 0" class="no-resource">
                        No Selected Resource(s)
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    input.pcl {
        position: absolute;
        z-index: -10000;
        opacity: 0;
    }
    .button-placement {
        display: flex;
        justify-content: center;
    }
    .carousel-inner-container {
        margin: auto;
    }
    .carousel-middle-container {
        margin: 0 80px;
    }
    .carousel-outer-container {
        // border-radius: 10px;
        // border: 1px solid #dee0e1;
        padding: 1rem 0;
    }
    .emp-info {
        padding: 10px 15px;
        text-align: left;
        height: 160px;
        position: relative;
    }
    .emp-name {
        color: black;
        a{
            font-weight: bold;
            color: black;
        }
    }

    h4 {
        margin: 10px 10px 15px 0px;
    }
    .no-resource {
        text-align: center;
        margin-bottom: 20px;
    }
    .popover-skill-block {
        padding: 5px 10px;
        width: 190px;
        font-family: Montserrat, sans-serif;
        color: #444;
        font-size: 8pt;
    }
    .popover-heading {
        font-family: Montserrat, sans-serif;
	}
    .popover-no-skill {
        font-size: 12px;
        text-align: center;
    }
    span.pcl {
        position: absolute;
        left: -1000px;
        top: -1000px;
    }
    .header-title {
        padding: 20px 0 5px;
        border-bottom: 5px solid #007840;
    }

    .header-title span:first-child {
        padding: 7px 20px 10px;
        position: relative;
        background: #007840;
        color: white;
    }

    .header-title span:first-child:after {
        content: "";
        position: absolute;
        top: 0;
        left: 100%;
        width: 0;
        height: 0;
        border-bottom: 46px solid #007840;
        border-right: 80px solid transparent;
    }
    .fs-user-photo-container {
        background-color: #DEDBDC;
        padding: 10px 0;
        position: relative;

        .remove {
            background: black;
            color: white;
            border-radius: 100px;
            border-width: 1px;
            font-size: 23px;
            position: absolute;
            top: -10px;
            right: -10px;
            cursor: pointer;
        }
        .fs-user-photo {
            height: 120px!important;
            width: 110px;
            box-sizing: border-box;
            background-color: #c1c1c1;
            height: 100%;
            background-size: cover;
            background-position: center;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border: 2px solid #fff;
            margin: 0 auto;
        }
    }
    .fs-position {
        font-weight: bold;
    }
    .add-resource {
        position: relative;
        float: right;
        font-size: 17px !important;
        padding-top: 7px;
        color: #007840;
        cursor: pointer;

        .add-icon {
            background-image: url(/assets/img/smart-team-builder/add.png);
            background-size: 22px;
            width: 22px;
            height: 22px;
            position: absolute;
            top: 6px;
            left: -26px;
        }
    }
    .three-ellipsis {
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical; 
		overflow: hidden; 
		//height: 40px;
	}
    .loader {
        margin: 45px auto 35px auto;
        z-index: 0;
    }
    .fs-user-photo-container {
        background: url("../../../public/assets/img/thumbs/profile/banner-cover_thumbnail.png") no-repeat;
        background-size: cover;
    }
    .carousel-icons {
        position: absolute; 
        bottom: 4px;
    }
</style>

<style>
/* All Below are Overriden CSS */
    .carousel-component .VueCarousel-dot-container, 
    .carousel-component .VueCarousel-dot-container > button {
        margin-top: 3px !important;
    }
    .carousel-component .VueCarousel-inner {
        justify-content: flex-start;
    }
    .carousel-component .VueCarousel-pagination {
        height: 40px;
    }
    .carousel-component .VueCarousel-navigation-button {
        font-size: 0;
    }
    .carousel-component .VueCarousel-navigation-prev {
        background-image: url('/assets/img/smart-team-builder/carousel-prev.png');
    }
    .carousel-component .VueCarousel-navigation-next {
        background-image: url('/assets/img/smart-team-builder/carousel-next.png');
    }
    .carousel-component .VueCarousel-slide .slide-wrapper{
        margin: 10px 15px;
        box-shadow: 3px 5px 15px rgba(0,0,0,0.16);
    }
</style>


<script>
// Library
import { Carousel, Slide } from 'vue-carousel';
import jQuery from 'jquery';

// Mixin
import EmployeeMixin from "@common/mixin/EmployeeMixin";
import AlertMixin from '@common/mixin/AlertMixin';

// Component
import PopoverDialog from '@components/popover-dialog.vue';

import $ from 'jquery';
import { mapActions, mapGetters } from 'vuex';
export default {
    components: {
        Carousel,
        Slide,
        PopoverDialog
    },
    mixins: [
        EmployeeMixin,
        AlertMixin
    ],    
    props: {
        headerTitle: {
            type: String,
            default: "Property: headerTitle"
        },
        rows: {
            type: Array,
            required: true
        },
        showButton: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        },
        onClick: Function
    },
    data() {
        /* 
        * Please Check Vue Carousel Configurations
        * https://github.com/SSENSE/vue-carousel#configuration
        */ 
        return {
            slidesPerPageCustom: [[320,1] , [540,2] , [768,3] , [1100, 4], [1300,5], [1540, 6]],
            mouseDrag: true,
            navigationEnabled: true,
            centerMode: true,
            paginationEnabled: false,
            navigationClickTargetSize: 30,
            navigationNextLabel: 'Next',
            navigationPrevLabel: 'Previous',
            adjustableHeight: true,
            resources: []
        }
    },
    methods: {
        ...mapActions({
            deleteClientPreferredTeam: 'smartTeamBuilder/deleteSmartTeamBuilder'
        }),

        getDownloadLink(profileUniqueStr) {
            return profileUniqueStr ? profileUniqueStr + '/pdf' : '';
        },
        setEmployeeClass(employeeId) {
            return 'profileCardURL' + employeeId;
        },
        removeResource(id, employeeName) {
            const title = 'Are you sure you want to delete this record?';
            const msg = `${employeeName}`;
            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                .then(({ok}) => {
                    if(ok) {
                        this.deleteClientPreferredTeam(id).then((res)=> {
                            $('.fs-position').popover('dispose');
                            this.$emit('close');
                        });
                    }
                });
        }
    },
    watch: {
        rows: function(val) {
            this.resources = this.rows;

            Vue.nextTick()
                .then(function () {
                    // DOM updated
                    $('.fs-position').popover({
                        html : true,
                        sanitize: false,
                        content: function() {
                            var content = $(this).attr('data-popover-content');
                            return $(content).children('.popover-body').html();
                        },
                        title: function() {
                            var title = $(this).attr('data-popover-content');
                            return $(title).children('.popover-heading').html();
                        }
                    });

                    let maxHeight = 0;
                    $(".has-btn-component").each(function(){
                        if ($(this).height() > maxHeight) {
                            maxHeight = $(this).height();
                        }
                    });
                    $(".has-btn-component").height(maxHeight);
                });
        }
    }
}
</script>