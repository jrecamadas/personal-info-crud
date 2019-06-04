<template>
    <div class="container" id="portfolio">
        <div class="row" v-if="employee">
            <div class="col-md-4 col-sm-12 left">
                <div class="profile-image-container">
                    <img v-if="photos" :src="employeeAsset.profile_photo"
                    class="img-fluid" :alt="employee.data.first_name + ' ' + getLastnameInitial(employee.data.last_name)">
                </div>
                <div class="profile-about-container">
                    <profile-title :title="'ABOUT ME'" :class="{marginBottom:summary}" v-if="employee.data.summary">
                        <template slot="icon">
                            <img src="/images/profile-icons/about-me.png" class="img-fluid" alt="About me">
                        </template>
                        <template slot="content">
                            <p class="summary" style="word-wrap: break-word;">{{employee.data.summary}}</p>
                        </template>
                    </profile-title>
                    <profile-title
                        v-if="languages"
                        :title="lang.language"
                        v-for="(lang, index) in employee.data.languages.data"
                        :key="index"
                    >
                    <template slot="icon">
                            <img src="/images/profile-icons/languages.png" class="img-fluid" alt="About me">
                    </template>
                    <template slot="content">
                        <label>Written</label>
                        <div
                            class="progress"
                            :style="'background-color: white'"
                        >
                            <div
                                :class="['progress-bar', 'progress-bar-profile-color']"
                                role="progressbar"
                                :style="{width: calculatePercentage(lang.proficiency.written)}"
                                :aria-valuenow="lang.proficiency.written"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div>
                        <progress-bar-number :limit = "10" :fontColor="'white'"></progress-bar-number>
                        <label>Spoken</label>
                        <div
                            class="progress"
                            :style="'background-color: white'"
                        >
                            <div
                                :class="['progress-bar', 'progress-bar-profile-color']"
                                role="progressbar"
                                :style="{width: calculatePercentage(lang.proficiency.spoken)}"
                                :aria-valuenow="lang.proficiency.spoken"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            ></div>
                        </div>
                        <progress-bar-number :limit = "10" :fontColor="'white'"></progress-bar-number>
                    </template>
                    </profile-title>

                    <!--SKILLS-->
                    <profile-title :title="'SKILLS'" :class="{marginBottom:skills}" v-if="skills">
                        <template slot="icon">
                            <img src="/images/profile-icons/skills.png" class="img-fluid" alt="About me">
                        </template>
                        <template slot="content">
                            <div v-if="skills" v-for="(skill, index) in employee.data.skills.data" :key="index">
                                <label>{{skill.name}}</label>
                                <div class="progress" :style="'background-color: white'" >
                                    <div
                                        :class="['progress-bar', 'progress-bar-profile-color']"
                                        role="progressbar"
                                        :style="{width: calculatePercentage(skill.proficiency)}"
                                        :aria-valuenow="skill.proficiency"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    ></div>
                                </div>
                                <progress-bar-number :limit = "10" :fontColor="'white'"></progress-bar-number>
                            </div>
                        </template>
                    </profile-title>
                    <!--END SKILLS-->
                    <!-- START OF SHIFT -->
                    <profile-title :title="'SHIFT'" v-if="shift" class="shift">
                        <template slot="icon">
                            <img src="/images/shift.png" class="img-fluid">
                        </template>
                        <template slot="content">
                            <div class="shift_time">
                                <p>
                                    {{ employee.data.shift.data.time.ph.start }} - {{
                                    employee.data.shift.data.time.ph.end }}, PHT
                                </p>
                                <p>
                                    {{ employee.data.shift.data.time.cst.start }} - {{
                                    employee.data.shift.data.time.cst.end }}, CST
                                </p>
                            </div>
                        </template>
                    </profile-title>
                    <!-- END OF SHIFT -->
                </div>
            </div>
            <div class="col-md-8 col-sm-12 right">
                <div class="header-container">
                    <h1 v-if="">{{employee.data.first_name}} {{getLastnameInitial(employee.data.last_name)}}</h1>
                    <h3 v-if="positions" >{{employee.data.positions.data.length ? position(employee.data.positions.data) : ''}}</h3>
                    <h5 v-if="locations">{{employee.data.location.data ? location(employee.data.location.data) : ''}}</h5>
                </div>
                <!-- <div class="body-container">
                    <p class="header">PORTFOLIO</p>
                    <ul :class="{description:!portfolios}">
                        <li v-if="portfolios" v-for="(portfolio, index) in employee.data.portfolios.data" :key="index">
                            <profile-info
                                :name="portfolio.name"
                                :startDate="formatDate(portfolio.start_date, 'MMM DD, YYYY')"
                                :endDate="formatDate(portfolio.end_date, 'MMM DD, YYYY')"
                                :description="portfolio.description"
                            ></profile-info>
                        </li>
                    </ul>
                </div> -->
                <div class="body-container">
                    <p class="header">EXPERIENCE</p>
                    <ul :class="{description:!workExperiences}">
                        <li v-if="workExperiences" v-for="(experience, index) in employee.data.workExperiences.data" :key="index">
                            <profile-info
                                :name="experience.company_name"
                                :startDate="formatDate(experience.start_date, 'MMM YYYY')"
                                :endDate="formatDate(experience.end_date, 'MMM YYYY')"
                                :description="experience.description"
                                :position="experience.job_title"
                            ></profile-info>
                        </li>
                    </ul>
                </div>
                <div class="body-container">
                    <p class="header">EDUCATION</p>
                    <ul :class="{description:!educations}">
                        <li v-if="educations" v-for="(education, index) in getEducationData(employee.data)" :key="index">
                            <profile-info
                                :name="education.school_university"
                                :startDate="''"
                                :endDate="education.is_present == 1 ? 'Present' : 'Year '+education.year_completed"
                                :description="education.course_degree"
                            ></profile-info>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
    $header-color: #58863e;
    $image-width: 50%;
    $title-font-size: 3rem;
    $header-font-size: 1.3rem;
    $font-size-normal:1rem;
    $bullet-size: 40px;
    $bullet-lineheight: 0.4444;
    $progress-bar-profile-color: #59863f;
    @mixin white-center() {
        text-align: center;
        color: white;
    }
    @mixin headers-style() {
        color: $header-color;
        font-size: 18px;
        border-bottom:5px solid $header-color;
    }
    @mixin padding-left-right($leftPadding, $rightPadding) {
        padding-left: $leftPadding;
        padding-right: $rightPadding;
    }
    body {
        &.ks-navbar-fixed {
            padding-top: 0px;
        }
        #portfolio {
            .left {
                background-image: linear-gradient(to bottom, $header-color, #2d421c);
                .profile-image-container {
                    img {
                        border-radius: 50%;
                        -webkit-box-shadow: 3px 5px 10px black;
                        box-shadow: 3px 5px 10px black;
                        width: $image-width;
                        display: block;
                        margin: 30px auto;
                    }
                }
                .profile-about-container {
                    @include padding-left-right(60px, 0);
                    color: white;
                    .header {
                        font-size: $header-font-size;
                        position: relative;
                        text-transform: uppercase;
                    }
                    .summary {
                        font-size: $font-size-normal;
                        word-wrap: break-word;
                    }
                    .shift{
                        .shift_time p{
                            margin-bottom: 9px;
                        }
                    }
                    .progress-bar-profile-color{
                        background-color: $progress-bar-profile-color;
                    }
                }
                label {
                    font-size: $font-size-normal;
                }
                .progress {
                    margin-bottom:5px;
                }
                .p-bar-num {
                    font-size: 14px;
                }
                .marginBottom {
                    margin-bottom:40px;
                }
            }
            .right {
                .header-container {
                    background-color: $header-color;
                    padding: 30px;
                    margin-top:30px;
                    margin-bottom: 15px;
                    h1 {
                        @include white-center;
                        font-size: $title-font-size;
                    }
                    h3 {
                        font-size: 1.5rem;
                        @include white-center;
                    }
                    h5 {
                        @include white-center;
                    }
                }
                .body-container {
                    ul {
                        padding: 0;
                        li {
                            list-style: none;
                            padding:2px;
                            &::before {
                                content: "\2022";
                                color: #58863e;
                                font-weight: bold;
                                display: inline-block;
                                width: 10px;
                                /* margin-left: -2em; */
                                font-size: $bullet-size;
                                position: absolute;
                                line-height: $bullet-lineheight;
                            }
                        }
                    }
                    .header {
                        @include headers-style();
                        padding-bottom:5px;
                        font-size: $header-font-size;
                    }
                    .description {
                        min-height:20px;
                        font-size:16px;
                        white-space: pre-line;
                    }
                }
            }
        }
    }
</style>
<script>
import { EmployeeProfile } from '@common/model/EmployeeProfile';
import ProfileInfo from '@components/profile-info.vue';
import ProfileTitle from '@components/profile-title.vue';
import ProgressBarNumber from '@components/progress-bar-number.vue'
import SkillsAndProficiencyMixin from '@common/mixin/SkillsAndProficiencyMixin';
import DateMixin from '@common/mixin/DateMixin';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import EmployeeEducationMixin from '@common/mixin/EmployeeEducationMixin';
import LoaderMixin from '@common/mixin/LoaderMixin';
import _ from 'lodash';

export default {
    data() {
        return {
            employeeAsset: {
                profile_photo: ''
            },
            employee: {
                data : {
                    educations: [],
                    first_name:'',
                    last_name:'',
                    gender:'',
                    positions: [],
                    portfolios: [],
                    workExperiences:[],
                    skills: [],
                    languages: [],
                    photo: [],
                    summary: '',
                    shift: {
                        data: {
                            shift:'',
                            time: {
                                cst:{
                                    end:'',
                                    start:'',
                                },
                                ph:{
                                    end:'',
                                    start:'',
                                }
                            }
                        }
                    },
                    location: ''
                }
            },
            include: [
                'positions',
                'photo',
                'workExperiences',
                'skills',
                'languages',
                'educations',
                'portfolios',
                'department',
                'user',
                'shift',
                'location'
            ]
        }
    },
    async created() {
        const username = this.$route.params.username;

        await EmployeeProfile.get({username: username,include: this.include.join(',')}).then((res) => {
            this.employee = res;
            console.log(this.employee,"__EMPLOYEE__");
            if (this.employee.data.skills.data.length) {
                this.employee.data.skills.data = this.employee.data.skills.data.splice(0, 10);
            }
            this.employeeAsset.profile_photo = this.photo(res.data);
        });
    },
    computed: {
        educations() {
            return this.employee.data.educations.data && this.employee.data.educations.data.length ? true : false;
        },
        photos() {
            return this.employee.data.photo.data ? true : false;
        },
        positions() {
            return this.employee.data.positions.data && this.employee.data.positions.data.length ? true : false;
        },
        portfolios() {
            return this.employee.data.portfolios.data && this.employee.data.portfolios.data.length ? true : false;
        },
        skills() {
            return this.employee.data.skills.data && this.employee.data.skills.data.length ? true : false;
        },
        languages() {
            return this.employee.data.languages.data && this.employee.data.languages.data.length ? true : false;
        },
        workExperiences() {
            return this.employee.data.workExperiences.data && this.employee.data.workExperiences.data.length ? true : false;
        },
        summary(value) {
            return this.employee.data.summary != '' ? true : false;
        },
        shift() {
            return this.employee.data.shift && this.employee.data.shift ? true : false;
        },
        locations() {
            return this.employee.data.location && this.employee.data.location.data ? true : false;
        }
    },
    methods: {
        getLastnameInitial(fullname) {
            return typeof fullname[0] !== 'undefined'
                ? fullname[0]+'.'
                : fullname;
        }
    },
    mounted() {
        this.hideLoader();
    },
    components: {
        ProfileInfo,
        ProfileTitle,
        ProgressBarNumber
    },
    mixins: [
        SkillsAndProficiencyMixin,
        DateMixin,
        EmployeeMixin,
        EmployeeEducationMixin,
        LoaderMixin
    ]
}
</script>
