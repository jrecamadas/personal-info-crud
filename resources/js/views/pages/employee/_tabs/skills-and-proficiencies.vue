<template>
    <div class="fs-accordion" :class="accordionClasses">
        <div class="fs-field">
            <div class="card panel panel-default ks-information ks-light">
                <div class="card-header" @click.stop="toggleAccordion">
                    <h4 class="ks-text">Skills and Proficiencies</h4>
                    <div v-if="canUpdate = $can('update', 'employee_skill')"> </div>
                    <Can I="update" a="employee_skill"> 
                        <a href="#skills-and-proficiencies" @click.stop="showModal" class="btn ks-light ks-no-text">
                            <span :class="['la', 'ks-icon', employeeSkills.length == 0 && employeeLanguages.length == 0 ? 'la-plus-square' : 'la-edit']"></span>
                        </a>
                    </Can>
                </div>
                <div class="card-block fs-accordion-content">
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="legends">
                                <span class="badge bg-success">8-10: Expert</span> 
                                <span class="badge advanced">6-7: Advanced</span> <span class="badge intermediate">3-5: Intermediate</span> 
                                <span class="badge beginning">1-2: Beginner</span>
                            </div>
                            
                        </div>
                        <Can I="update" a="employee_skill"> 
                            <div class="col-lg-4">
                                <div class="pull-right">
                                    <button v-if="showButton" class="btn-sm btn-success align-middle action-buttons" @click="update">
                                        <span v-if="isLoading" class="fa fa-spinner fa-spin"></span>
                                        <span v-else>Save</span>
                                    </button>
                                    <button v-if="showButton" class="btn-sm btn-danger align-middle action-buttons" @click="cancel">
                                        <span v-if="isCancelLoading" class="fa fa-spinner fa-spin"></span>
                                        <span v-else>Cancel</span>
                                    </button>
                                </div>
                            </div>
                        </Can>
                    </div>
                    <div class="row">
                        <div class="col-md-6" v-if="employeeSkills.length">
                            <h4>Skills</h4>
                            <div v-for="(skill, index) in employeeSkills" :key="index" :class="!canUpdate ? 'disabled' : ''">
                                <label>{{skill.name}}</label>
                                <span @click="onClick(index, isSkills)"  :class="!canUpdate ? 'disabled' : ''"> 
                                    <vue-slide-bar
                                        v-model="skill.proficiency"
                                        @input="onChange(index, isSkills)"
                                        :range="slider.range"
                                        :min="1"
                                        :max="10"
                                        :is-disabled="!canUpdate"
                                        :processStyle="slider.processStyle[index]"
                                        :lineHeight="slider.lineHeight"
                                        :showTooltip="false"
                                        class="slider-padding"
                                        >
                                    </vue-slide-bar>
                                </span>
                                
                            </div>
                        </div>

                        <div class="col-md-6" v-if="employeeLanguages.length">
                            <h4>Languages</h4>
                            <div v-for="(language, index) in employeeLanguages" :key="language.id" :class="!canUpdate ? 'disabled' : ''">
                                <div class="panel lang-panel panel-default">
                                    <div class="panel-heading">{{language.language}}</div>
                                    <div class="panel-body">
                                        <label>Spoken</label>
                                        <span @click="onClick(index, isSpoken)" :class="!canUpdate ? 'disabled' : ''">
                                            <vue-slide-bar
                                                v-model="language.proficiency.spoken"
                                                :range="slider.range"
                                                @input="onChange(index, isSpoken)"
                                                :min="1"
                                                :max="10"
                                                :is-disabled="!canUpdate"
                                                :lineHeight="slider.lineHeight"
                                                :processStyle="slider.processStyle.spoken[index]"
                                                :showTooltip="false"
                                                class="slider-padding"
                                                >
                                            </vue-slide-bar>
                                        </span>

                                        <label>Written</label>
                                        <span @click="onClick(index, isWritten)" :class="!canUpdate ? 'disabled' : ''">
                                            <vue-slide-bar
                                                v-model="language.proficiency.written"
                                                :range="slider.range"
                                                @input="onChange(index, isWritten)"
                                                :min="1"
                                                :max="10"
                                                :is-disabled="!canUpdate"
                                                :processStyle="slider.processStyle.written[index]"
                                                :lineHeight="slider.lineHeight"
                                                :showTooltip="false"
                                                class="slider-padding"
                                                >
                                            </vue-slide-bar>
                                        </span>
                                        <span>{{message}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BEGIN WORK EXPERIENCE DIALOG -->
        <skills-and-proficiencies-modal v-if="open" :openModal="open" @success="$emit('success')" @close="open = false">
        </skills-and-proficiencies-modal>
        <!-- END WORK DETAIL DIALOG -->
    </div>
</template>

<style type="text/css" scope>
.legends {
    color: white;
}
.progress {
    position: relative;
}
.advanced {
  background-color: #fcb24b !important; /*#ffa500 */
}
.intermediate {
  background-color: #fc721e !important; /*#ff4500 */
}
.beginning {
  background-color: #fc0d1b !important; /*#ff0000 */
}
.slider-padding {
    padding-top: 5px !important; 
    min-height: 75px !important; 
}
.action-buttons {
    color: white; 
    width: 70px;  
}
.disabled{
    cursor: not-allowed;
}
</style>

<script>
// Mixin
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import AccordionMixin from '@common/mixin/AccordionMixin';
import SkillsAndProficiencyMixin from '@common/mixin/SkillsAndProficiencyMixin';

// Modal
import SkillsAndProficienciesModal from '@views/pages/employee/_modals/skills-and-proficiencies.vue';

// Model
import { Employee  } from '@common/model/Employee';
import { EmployeeSkill } from '@common/model/EmployeeSkill';
import { EmployeeLanguage } from '@common/model/EmployeeLanguage';
import { Skill } from '@common/model/Skill';
import { Language } from '@common/model/Language';

import VueSlideBar from 'vue-slide-bar';

import _ from 'lodash';
import { mapActions, mapGetters } from 'vuex';

export default {
    data() {
        return {
            isSkills: 1,
            isSpoken: 2,
            isWritten: 3,
            isReset: false,
            open: false,
            counter: 0,
            resetCounter: 0,
            isLoading: false,
            isModalOpened: false,
            isCancelLoading: false,
            isOnPageLoad: false,
            canUpdate: '',
            progressBarBgColor: '#b5b5b6',
            showButton: false,
            include: [
                'positions',
                'interests',
                'governmentIds',
                'shift',
                'contactPerson',
                'address',
                'photo',
                'workExperiences',
                'skills',
                'languages',
                'educations',
                'portfolios',
                'department',
                'user',
                'spouse',
                'dependents',
                'contacts',
                'otherSkills',
                'otherDetails',
                'employeeStatuses'
            ],
            slider: {
                lineHeight: 10,
                range: [
                    { label: '1' },
                    { label: '2' },
                    { label: '3' },
                    { label: '4' },
                    { label: '5' },
                    { label: '6' },
                    { label: '7' },
                    { label: '8' },
                    { label: '9' },
                    { label: '10' }
                ],
                processStyle:{
                    spoken:{ backgroundColor: '#808080' },
                    written:{ backgroundColor: '#808080' },
                    backgroundColor: '#808080'
                }
            },
            beginner: '#fc0d1b',
            intermediate: '#fc721e',
            advanced: '#fcb24b',
            expert: '#50ae55',
            gray: '#808080',
            message: null,
        }
    },
    created: function() {
        this.isOnPageLoad = true;
    },
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        }),
        employeeSkills: function() {
            var empSkills = [];

            if(this.employee && !this.employee.skills) return empSkills;
            _.each(this.employee.skills.data, (skill, key) => {
                empSkills.push(skill);
            });
            return empSkills;
        },
        employeeLanguages: function() {
            var empLangs = [];

            if(this.employee && !this.employee.languages) return empLangs;
            _.each(this.employee.languages.data, (language,key) =>{
                empLangs.push(language)
            });
            return empLangs;
        },
        employeeId: function() {
            return this.employee.id;
        }

    },
    methods: {
        ...mapActions ({
            saveEmployeeSkill: 'employeeSkills/saveEmployeeSkill',
            getEmployee: 'employees/getEmployee'
        }),
        update() {       
            this.isLoading = true; 
            var promises = [];

            //update employee skills
            _.each(this.employeeSkills, (skill, key) => {
                var employeeSkill = new EmployeeSkill();
                employeeSkill = new EmployeeSkill({id: skill.id});
                promises.push(employeeSkill.save({
                    employee_id: this.employeeId,
                    proficiency: skill.proficiency,
                    skill_id: skill.skill_id,
                    years_of_experience: skill.years_of_experience,
                    no_of_projects_handled: skill.no_of_projects_handled,
                    project_roles: skill.project_roles
                }));
            });

            //update employee languages
            _.each(this.employeeLanguages, (lang, key) => {
                var employeeLanguage = new EmployeeLanguage();
                employeeLanguage = new EmployeeLanguage({id: lang.id});
                promises.push(employeeLanguage.save({
                    employee_id: this.employeeId,
                    language_id: lang.language_id,
                    written: lang.proficiency.written,
                    spoken: lang.proficiency.spoken
                }));
            });

            Promise.all(promises).then((res) => {
                this.getEmployee({
                    id: this.employeeId,
                    include: this.include.join(',')
                }).then(() => {
                    this.resetSliderColor();
                    this.showButton = false;
                    this.isLoading = false; 
 
                });
            });
        },
        showModal() {
            this.cancel();
            this.open = true;
        },
        onClick(index, data){
            this.isReset = false;
            this.isOnPageLoad = false;
            this.onChange(index, data)      
                
        },
        onChange(index, data) {
            // since on page load this method will execute automatically, had to create flag
            // to determine the real change event in the slider
   
            if(!this.isReset) {    
                if(this.employeeSkills.length + (this.employeeLanguages.length * 2) == this.counter) {
                    this.isOnPageLoad = false;
                } 
                if(this.isOnPageLoad || this.isModalOpened) {
                    this.counter++;
                    this.resetSliderColor();
                    this.isModalOpened = false;
                } 
                else if(!this.isOnPageLoad && !this.isModalOpened && this.canUpdate) { 
                    this.showButton = true;
                    switch(data) {
                        case this.isSkills:
                            this.slider.processStyle[index] = { backgroundColor : this.gray };
                            break;

                        case this.isSpoken:
                            this.slider.processStyle.spoken[index] = { backgroundColor : this.gray };
                            break;

                        case this.isWritten:
                            this.slider.processStyle.written[index] = { backgroundColor : this.gray };
                            break;
                    }
                }
            }
        },
        cancel() {
            this.isCancelLoading = true;
            this.getEmployee({
                id: this.employeeId,
                include: this.include.join(',')
            }).then(() => {
                this.resetSliderColor();
                this.showButton = false;
                this.isCancelLoading = false;
            });
        },
        resetSliderColor() {
            // reset employee skills colors in slider
            _.each(this.employeeSkills, (skill, key) => {
               this.slider.processStyle[key] = this.setColorInSlider(skill.proficiency);
            }); 

            // reset employee languages colors in slider
            _.each(this.employeeLanguages, (language, key) => {
                this.slider.processStyle.spoken[key] = this.setColorInSlider(language.proficiency.spoken);
                this.slider.processStyle.written[key] = this.setColorInSlider(language.proficiency.written);
            });
        },
        resetFlags() {
            this.isOnPageLoad = true;
            this.isModalOpened = false;
            this.showButton = false;
            this.resetSliderColor();
            this.isReset = true;
        },
        setColorInSlider(sliderModel) {
            return { 
                backgroundColor : (sliderModel >= 3 && sliderModel <= 5) ? this.intermediate :
                                (sliderModel >= 6 && sliderModel <= 7) ? this.advanced :
                                (sliderModel >= 8 && sliderModel <=10) ? this.expert : this.beginner
            };
        }
    },  
    watch: {
        open: function(newValue, old) {
            this.cancel();
            this.isModalOpened  = newValue;
        },
        employeeId: function(newValue, old) {
            this.resetFlags();
        },
    },
    components: {
        SkillsAndProficienciesModal,
        VueSlideBar
    },
    mixins: [
        ModalDialogMixin,
        SkillsAndProficiencyMixin,
        AccordionMixin
    ]
}
</script>
