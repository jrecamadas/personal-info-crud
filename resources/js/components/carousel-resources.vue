<template>
    <div class="carousel-component">
        <h3>{{ headerTitle }}</h3>
        <div class="carousel-outer-container">
            <div class="carousel-middle-container">
                <div class="carousel-inner-container">
                    <carousel 
                        :per-page="slidesPerPage"  
                        :mouse-drag="mouseDrag" 
                        :navigation-enabled="navigationEnabled" 
                        :center-mode="centerMode"
                        :pagination-active-color="paginationActiveColor"
                        :pagination-color="paginationColor"
                        :navigation-click-target-size="navigationClickTargetSize">
                        <slide v-for="(row, index) in rows" :key="index">
                            <div class="fs-user-photo align-self-center" :style="'background-image: url(\'' + photo(row) + '\')'"></div>
                            <div class="emp-info" :class=" showButton ? 'has-btn-component' : '' ">
                                <div class="emp-name">
                                    <router-link :to="{name: 'employee', params: {id: row.id}}">
                                        {{ row.first_name + ' '+ row.last_name }}
                                    </router-link>
                                </div>
                                <div>
                                    <span data-trigger="hover" data-toggle="popover" :data-popover-content="'#popover-skill-' + index">
                                        {{ position(row.positions ? row.positions.data : "") }}
                                    </span>
                                </div>
                                <div>
                                    <span :class="setEmployeeClass(row.id)" class="pcl">
                                        {{ row.profile_url }}
                                    </span>
                                    <a
                                        href="javascript:;"
                                        class="action-button"
                                        title="Copy Employee Profile Link"
                                        @click.prevent="copyToClipboard(setEmployeeClass(row.id))">
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
                                <popover-dialog :popoverId="'popover-skill-' + index">
                                    <template slot="header">Skills</template>
                                    <template slot="body">
                                        <div class="popover-skill-block">
                                            <div class="resource-details-content" v-if="row.skills && row.skills.data.length">
                                                <div v-for="(skill,index) in row.skills.data" :key="skill.id">
                                                    <div v-if="index < 5">
                                                        <div class="ks-controls resource-skill-placeholder">
                                                            <span class="resource-skill">
                                                                {{ skill.name}}
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
                            <div class="button-placement" v-if="showButton">
                                <label class="btn btn-primary" @click="onClick(row)">Assign to Project</label>
                            </div>
                        </slide>
                    </carousel>
                    <div v-if="rows.length == 0" class="no-resource">
                        No {{ headerTitle }}(s)
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
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
        border-radius: 10px;
        border: 1px solid #dee0e1;
        padding: 1rem 0;
    }
    .emp-info {
        padding: 8px 15px;
        text-align: center;
    }
    .emp-name {
        font-weight: bold;
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
</style>

<style>
/* All Below are Overriden CSS */
    .carousel-component .VueCarousel-dot-container, 
    .carousel-component .VueCarousel-dot-container > button {
        margin-top: 3px !important;
    }
    .carousel-component .VueCarousel-pagination {
        height: 40px;
    }
    .carousel-component .VueCarousel-navigation-button {
        font-size: 0px;
    }
    .carousel-component .VueCarousel-navigation-prev {
        background-image: url('/assets/img/smart-team-builder/carousel-prev.png');
    }
    .carousel-component .VueCarousel-navigation-next {
        background-image: url('/assets/img/smart-team-builder/carousel-next.png');
    }
</style>


<script>
// Library
import { Carousel, Slide } from 'vue-carousel';
import jQuery from 'jquery';

// Mixin
import EmployeeMixin from "@common/mixin/EmployeeMixin";

// Component
import PopoverDialog from '@components/popover-dialog.vue';

export default {
    components: {
        Carousel,
        Slide,
        PopoverDialog
    },
    mixins: [
        EmployeeMixin
    ],    
    props: {
        headerTitle: {
            type: String,
            default: "Property: headerTitle"
        },
        rows: {
            type: Array
        },
        showButton: {
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
            slidesPerPage: 4,
            mouseDrag: true,
            navigationEnabled: true,
            centerMode: true,
            paginationActiveColor: '#000000', 
            paginationColor: '#808080',
            navigationClickTargetSize: 30
        }
    },
    methods: {
        getDownloadLink(profileUniqueStr) {
            return profileUniqueStr ? profileUniqueStr + '/pdf' : '';
        },
        setEmployeeClass(employeeId) {
            return 'profileCardURL' + employeeId;
        }
    },
    watch: {
        rows: function(val) {
            let $ = jQuery;
            
            this.$nextTick( () => {
                $("[data-toggle='popover']").popover({
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