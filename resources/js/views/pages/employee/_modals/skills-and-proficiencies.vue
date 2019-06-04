<template>
    <modal-dialog v-show="openModal" :options="option" :title="'Skills and Proficiencies'" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :disabled="!valid" class="btn btn-primary" @action="save">Save</save-button>
        </template>

        <template slot="body">
            <div id="skills-and-proficiencies">
                <div class="s-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                    <ul class="nav ks-nav-tabs">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" data-toggle="tab" data-target="#skill" aria-expanded="true">
                                <i class="la la-wrench"></i> Skills
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="tab" data-target="#language" aria-expanded="false">
                                <i class="la la-language"></i> Languages
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="skill" role="tabpanel" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-12">
                                <!-- BEGIN SKILLS -->
                                    <vue-tags-input
                                            id="skillsSelection"
                                            v-model="skill"
                                            v-if="skills"
                                            :tags="data.skills"
                                            :autocomplete-items="filteredSkills"
                                            :autocomplete-always-open="displayAutoComplete"
                                            :add-only-from-autocomplete="true"
                                            @tags-changed="newSkill => data.skills = newSkill"
                                            @before-adding-tag="beforeAddingSkillTag"
                                            @before-deleting-tag="beforeDeletingSkillTag"
                                            placeholder="Enter Skill"
                                            @input="updateValue"
                                            @focus="soControlTag(skills,'data','skills', 'skillsSelection', tagOptionData,'skillsFlag',true)"
                                            @blur="soControlTag(skills,'data','skills', 'skillsSelection', tagOptionData,'skillsFlag',false)"
                                    />

                                    <vue-tags-input
                                            id="skillsOptions"
                                            v-model="tagOptionData.skillsField"
                                            v-show="tagOptionData.skillsFlag"
                                            :tags="soFilteredSkills(skills,'data','skills',data.skills)"
                                            :add-only-from-autocomplete="false"
                                            @select="blur()"
                                    />
                                <div class="skills-and-proficiencies-outer">
                                    <div class="skills-and-proficiencies-wrapper">
                                        <template v-show="data.skills.length">
                                            <h4>Proficiencies</h4>
                                            <div v-for="(sp, i) in data.skills" :key="'skill-' + sp.id" class="skills-and-proficiencies">
                                                <div class="col-sm-12 col-md-3">
                                                    <label>
                                                        <i class="la la-wrench"></i>
                                                        {{ sp.text }}
                                                    </label>
                                                    <touch-spin :value="sp.proficiency" @change="data.skills[i].proficiency = $event"></touch-spin>
                                                </div>
                                                <div class="ccol-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label>Years of Experience</label>
                                                        <div class="form-group"><!--Removed required Years of Experience as per request of Matt D.-->
                                                            <input
                                                                v-model="sp.years_of_experience"
                                                                v-mask="'##'"
                                                                placeholder="Years of Experience"
                                                                name="'years_of_experience'"
                                                                type="text"
                                                                class="form-control"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group"><!--Removed required Projects Handled as per request of Matt D.-->
                                                        <label>No. of Projects Handled</label>
                                                        <div class="form-group">
                                                            <input
                                                                v-model="sp.no_of_projects_handled"
                                                                v-mask="'####'"
                                                                placeholder="No. of Proj. Handled"
                                                                name="no_of_projects_handled"
                                                                type="text"
                                                                class="form-control"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group"><!--Removed required Project Role as per request of Matt D.-->
                                                        <label>Project Role</label>
                                                        <div class="form-group">
                                                            <input
                                                                v-model="sp.project_roles"
                                                                placeholder="Project Role"
                                                                name="project_roles"
                                                                type="text"
                                                                class="form-control"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <span v-show="!data.skills.length">None entered</span>
                                    </div>
                                </div>
                                <!-- END SKILLS -->
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="language" role="tabpanel" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- BEGIN LANGUAGES -->
                                    <vue-tags-input
                                            v-model="language"
                                            v-if="languages"
                                            :tags="data.languages"
                                            :add-only-from-autocomplete="true"
                                            :autocomplete-items="filteredLanguages"
                                            @tags-changed="newLanguage => data.languages = newLanguage"
                                            @before-adding-tag="beforeAddingLangTag"
                                            @before-deleting-tag="beforeDeletingLangTag"
                                            placeholder="Enter Language"
                                    />
                                    <div class="skills-and-proficiencies-outer">
                                    <div class="skills-and-proficiencies-wrapper">
                                        <h4>Proficiencies</h4>
                                        <template v-show="data.languages.length">
                                            <div v-for="(lang, i) in data.languages" :key="'lang-' + lang.id" class="languages-proficiencies-wrapper">
                                                <div class="col-lg-6">
                                                    <h5>
                                                        <i class="la la-language"></i>
                                                        {{ lang.language }}
                                                    </h5>
                                                </div>

                                                <div class="language-proficiencies">
                                                    <div class="col-lg-6">
                                                        <span>Spoken</span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <touch-spin :value="lang.proficiency.spoken" @change="data.languages[i].proficiency.spoken = $event"></touch-spin>
                                                    </div>
                                                </div>

                                                <div class="language-proficiencies">
                                                    <div class="col-lg-6">
                                                        <span>Written</span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <touch-spin :value="lang.proficiency.written" @change="data.languages[i].proficiency.written = $event"></touch-spin>
                                                    </div>
                                                </div>
                                        </div>
                                    </template>
                                    <span v-show="!data.languages.length">None entered</span>
                                    </div>
                                    </div>
                                    <!-- END LANGUAGES -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </modal-dialog>
</template>

<style type="text/css">
div.fs-accordion div.modal-backdrop > div[role='dialog']{
    overflow: initial!important;
}
</style>

<style lang="scss" scoped>
#skills-and-proficiencies{
    .nav-link.active{
        font-weight: 600!important;
        border-bottom:4px solid rgb(66, 165, 245);
    }
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
    margin-bottom: 1em;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.language-proficiencies {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding-left: 20px;
}
</style>
<style type="text/css">
    #skills-and-proficiencies .modal {
        bottom:auto;
    }
    .skills .autocomplete {
        overflow-y: scroll;
        height: 200%;
    }
</style>

<script>
import TouchSpin from '@components/touchspin.vue';
import VueTagsInput from '@johmun/vue-tags-input';
import ArrayHelperMixin from '@common/mixin/ArrayHelperMixin';
import SkillsOptionMixin from '@common/mixin/SkillsOptionMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import { mask } from 'vue-the-mask';
import { Skill } from '@common/model/Skill';
import { Language } from '@common/model/Language';
import { EmployeeLanguage } from '@common/model/EmployeeLanguage';
import { EmployeeSkill } from '@common/model/EmployeeSkill';
import SkillsAndProficiencyMixin from '@common/mixin/SkillsAndProficiencyMixin';
import { mapGetters, mapActions } from 'vuex';
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import _ from 'lodash';

export default {
    directives: {
        mask
    },
    created() {
        // load languages
        this.getLanguages({query: {take: 9999}, extra: {proficiency: {spoken: 5, written: 5}}});
        // load skills
        this.getSkills({query: {take: 9999}, extra: {proficiency: 5}});
        //set udpate and default skill
        _.each(this.employee.skills.data, (s)=>{
            this.data.skills.push({
                id: s.skill_id,
                text: s.name,
                proficiency: s.proficiency,
                years_of_experience: s.years_of_experience,
                no_of_projects_handled: s.no_of_projects_handled,
                project_roles: s.project_roles
            });
        });
        _.each(this.employee.languages.data, (l)=>{
            this.data.languages.push({
                id: l.language_id,
                text: l.language,
                proficiency: {
                    written: l.proficiency.written,
                    spoken: l.proficiency.spoken
                }
            });
        });
    },
    data() {
        return {
            option: {
                width: '800px'
            },
            skill: '',
            language: '',
            loading: false,
            skillsTags: [],
            languageTags: [],
            data: {
                skills: [],
                languages: []
            },
            deleted: {
                skills: [],
                languages: []
            },
            displayAutoComplete: false
        }
    },
    computed: {
        ...mapGetters({
            skills: 'skills/formatted',
            languages: 'languages/formatted',
            employee: 'employees/single'
        }),
        filteredSkills: function() {
            return this.skills.filter(s => new RegExp(this.skill, 'i').test(s.text));
        },
        filteredLanguages: function() {
            return this.languages.filter(l => new RegExp(this.language, 'i').test(l.text));
        },
        valid: function() { //Pass the Skill validation to the Save button
            let valid = true;

            if(!this.validateSkills(this.data.skills)){ valid = false; }

            return valid;
        },
    },
    methods: {
        ...mapActions({
            getSkills: 'skills/getSkills',
            getLanguages: 'languages/getLanguages'
        }),
        updateValue(value) {
            if(value) {
                this.displayAutoComplete = true;
            }
            else {
                this.displayAutoComplete = false;
            }
        },
        beforeDeletingSkillTag(obj) {
            if(obj.tag){
                const skill = this.employee.skills.data.filter(skill => skill.skill_id == obj.tag.id);
                if(skill.length) {
                    this.deleted.skills.push({
                        id: skill[0].skill_id,
                        text: skill[0].name,
                        proficiency: skill[0].proficiency,
                        years_of_experience: skill[0].years_of_experience,
                        no_of_projects_handled: skill[0].no_of_projects_handled,
                        project_roles: skill[0].project_roles
                    });
                }
            }
            obj.deleteTag();
            this.soGainFocus("input#skillsSelection");
        },
        beforeDeletingLangTag(obj) {
            if(obj.tag){
                const lang = this.employee.languages.data.filter(lang => lang.language_id == obj.tag.id);
                if(lang.length) {
                    this.deleted.languages.push({
                        id: lang[0].language_id,
                        text: lang[0].language,
                        proficiency: {
                            written: lang[0].proficiency.written,
                            spoken: lang[0].proficiency.spoken
                        }
                    });
                }
            }
            obj.deleteTag();
        },
        beforeAddingLangTag(obj) {
            const deletedLang = this.deleted.languages.filter(lang => lang.id == obj.tag.id);
            if(deletedLang.length) {
                this.data.languages.push(deletedLang[0]);
            }
            obj.addTag();
        },
        beforeAddingSkillTag(obj) {
            const deletedSkill = this.deleted.skills.filter(skill => skill.id == obj.tag.id);
            if(deletedSkill.length) {
                this.data.skills.push(deletedSkill[0]);
            }
            obj.addTag();
            this.soGainFocus("input#skillsSelection");
        },
        validateSkills(skills){ //Check if there are missing fields in the Skill
            let pass = true;
            skills.forEach((skill) => { //Removed required Years of Exerience, No. of Projects Handled, and Project Roles as request of Matt D.
                pass = skill.proficiency              ? pass : false;
                //pass = skill.years_of_experience      ? pass : false;
                //pass = skill.no_of_projects_handled   ? pass : false;
                //pass = skill.project_roles            ? pass : false;
            });
            return pass;
        },
        save() {
            this.loading = true;
            var promises = [];
            const employeeId = this.$route.params.id;
            //save /update employee skills
            _.each(this.data.skills, (skill, key) => {
                var employeeSkill = new EmployeeSkill();
                const empSkill = this.employee.skills.data.filter((es) => es.skill_id == skill.id);
                //update if empSkill not empty else create
                if(empSkill.length) {
                    employeeSkill = new EmployeeSkill({id: empSkill[0].id});
                }
                promises.push(employeeSkill.save({
                    employee_id: employeeId,
                    proficiency: skill.proficiency,
                    skill_id: skill.id,
                    years_of_experience: skill.years_of_experience,
                    no_of_projects_handled: skill.no_of_projects_handled,
                    project_roles: skill.project_roles
                }));
            });
            //delete employee skills
            _.each(this.employee.skills.data, (skill, key) => {
                const empSkill = this.data.skills.filter((es) => es.id == skill.skill_id);
                if(!empSkill.length) {
                    const employeeSkill = new EmployeeSkill({id: skill.id});
                    promises.push(employeeSkill.delete());
                }
            });
            //save / update employee languages
            _.each(this.data.languages, (lang, key) => {
                var employeeLanguage = new EmployeeLanguage();
                const empLang = this.employee.languages.data.filter((el)=>el.language_id == lang.id);
                //update
                if(empLang.length) {
                    employeeLanguage = new EmployeeLanguage({id: empLang[0].id});
                }
                promises.push(employeeLanguage.save({
                    employee_id: employeeId,
                    language_id: lang.id,
                    written: lang.proficiency.written,
                    spoken: lang.proficiency.spoken
                }));
            });
            //delete employee langs
            _.each(this.employee.languages.data, (lang, key) => {
                const empLang = this.data.languages.filter(l=>l.id == lang.language_id);
                if(!empLang.length) {
                    const employeeLanguage = new EmployeeLanguage({id: lang.id});
                    promises.push(employeeLanguage.delete());
                }
            });
            Promise.all(promises).then((res) => {
                this.$emit('success');
                this.loading = false;
                this.closeModal();
                this.notifyDialog('success', 'Successfully saved!');
            });
        },
    },
    components: {
        TouchSpin,
        VueTagsInput,
        SaveButton,
        ModalDialog
    },
    mixins: [
        ArrayHelperMixin,
        ModalDialogMixin,
        SkillsAndProficiencyMixin,
        SkillsOptionMixin,
        AlertMixin
    ]
}
</script>
