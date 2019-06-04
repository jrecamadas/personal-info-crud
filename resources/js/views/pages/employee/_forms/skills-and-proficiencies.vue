<template>
    <div>
        <div id="skills-and-proficiencies">
            <div class="row">
                <div class="col-lg-6">
                    <h4>
                        <i class="la la-wrench"></i>
                        Skills
                    </h4>
                    <!-- BEGIN SKILLS -->
                    <vue-tags-input
                        v-model="skill"
                        v-if="skills"
                        :tags="data.skillsAndProficiencies.skills"
                        :autocomplete-items="filteredSkills"
                        :add-only-from-autocomplete="true"
                        @tags-changed="newSkill => data.skillsAndProficiencies.skills = newSkill"
                        placeholder="Enter Skill"
                    />
                    <div class="skills-and-proficiencies-wrapper">
                        <template v-show="data.skillsAndProficiencies.skills.length">
                            <h4>Proficiencies</h4>
                            <div v-for="(sp, i) in data.skillsAndProficiencies.skills" :key="'skill-' + sp.id" class="skills-and-proficiencies">
                               
                                    <div class="col-lg-6">
                                        <span>
                                            <i class="la la-wrench"></i>
                                            {{ sp.text }}
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <touch-spin :value="sp.proficiency" @change="data.skillsAndProficiencies.skills[i].proficiency = $event"></touch-spin>
                                    </div>
                            </div>
                        </template>
                        <span v-show="!data.skillsAndProficiencies.skills.length">None entered</span>
                    </div>
                    <!-- END SKILLS -->
                </div>
                <div class="col-lg-6">
                    <h4>
                        <i class="la la-language"></i>
                        Languages
                    </h4>
                    <!-- BEGIN LANGUAGES -->
                    <vue-tags-input
                        v-model="language"
                        v-if="languages"
                        :tags="data.skillsAndProficiencies.languages"
                        :add-only-from-autocomplete="true"
                        :autocomplete-items="filteredLanguages"
                        @tags-changed="newLanguage => data.skillsAndProficiencies.languages = newLanguage"
                        placeholder="Enter Language"
                    />
                    <div class="skills-and-proficiencies-wrapper">
                        <h4>Proficiencies</h4>
                        <template v-show="data.skillsAndProficiencies.languages.length">
                            <div v-for="(lang, i) in data.skillsAndProficiencies.languages" :key="'lang-' + lang.id" class="languages-proficiencies-wrapper">
                                
                                <div class="col-lg-6">
                                    <h5>
                                        <i class="la la-language"></i>
                                        {{ lang.text }}
                                    </h5>
                                </div>
                               
                                    <div class="language-proficiencies">
                                        <div class="col-lg-6">
                                            <span>Spoken</span>
                                        </div>
                                        <div class="col-lg-6">    
                                            <touch-spin :value="lang.proficiency.spoken" @change="data.skillsAndProficiencies.languages[i].proficiency.spoken = $event"></touch-spin>
                                        </div>
                                    </div>
                             
                                    <div class="language-proficiencies">
                                        <div class="col-lg-6">
                                            <span>Written</span>
                                        </div>
                                        <div class="col-lg-6">
                                            <touch-spin :value="lang.proficiency.written" @change="data.skillsAndProficiencies.languages[i].proficiency.written = $event"></touch-spin>
                                        </div>
                                    </div>
                             
                           </div>
                       </template>
                       <span v-show="!data.skillsAndProficiencies.languages.length">None entered</span>
                    </div>
                    <!-- END LANGUAGES -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <footer class="dialog-footer">
                    <button type="button" class="btn btn-danger" @click="$emit('close')">Cancel</button>
                    <save-button :loading="loading" class="btb btn-primary" @action="save">Save</save-button>
                </footer>
            </div>
        </div>

    </div>
</template>

<style lang="scss" scoped>
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

.language-proficiencies {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding-left: 20px;
}
</style>

<script>
import TouchSpin from '@components/touchspin.vue';
import VueTagsInput from '@johmun/vue-tags-input';
import ArrayHelperMixin from '@common/mixin/ArrayHelperMixin';
import { Skill } from '@common/model/Skill';
import { Language } from '@common/model/Language';
import { EmployeeLanguage } from '@common/model/EmployeeLanguage';
import { mapGetters, mapActions } from 'vuex';
import SaveButton from '@components/form/button.vue';

export default {
    created() {
        // load languages
        this.getLanguages({query: {take: 9999}, extra: {proficiency: {spoken: 5, written: 5}}});
        // load skills
        this.getSkills({query: {take: 9999}, extra: {proficiency: 5}});
    },
    data() {
        return {
             modal: {

            width: '800px',
            height: '400px'
        },
            skill: '',
            language: '',
            data: {
                info: {
                    employeeNo: '',
                    dateHired: '',
                    name: {
                        first: '',
                        middle: '',
                        last: '',
                        ext: '',
                        nick: ''
                    },
                    dateOfBirth: '',
                    gender: '',
                    address: {
                        present: {
                            houseNo: '',
                            street: '',
                            barangay: '',
                            townCity: '',
                            province: '',
                            zipCode: '',
                            isPresent: false
                        },
                        permanent: {
                            hoseNo: '',
                            street: '',
                            barangay: '',
                            townCity: '',
                            province: '',
                            zipCode: '',
                            isPermanent: false
                        },
                        sameAsPresent: false
                    },
                    contactNo: '',
                    civilStatus: 'Single'
                },
                shift: {
                    shiftId: 'UNASSIGNED',
                    startTime: null,
                    endTime: null
                },
                positions: [],
                skillsAndProficiencies: {
                    skills: [],
                    languages: []
                },
                education: []
            },
        }
    },
    computed: {
        ...mapGetters({
            skills: 'skills/formatted',
            languages: 'languages/formatted'
        }),
        filteredSkills: function() {
            return this.skills.filter(s => new RegExp(this.skill, 'i').test(s.text));
        },
        filteredLanguages: function() {
            return this.languages.filter(l => new RegExp(this.language, 'i').test(l.text));
        }
    },
    methods: {
        ...mapActions({
            getSkills: 'skills/getSkills',
            getLanguages: 'languages/getLanguages'
        }),
    },
    components: {
        TouchSpin,
        VueTagsInput,
        SaveButton,
    },
    mixins: [
        ArrayHelperMixin
    ],
    save(){

    }
}
</script>
