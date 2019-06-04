<template>
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
                            <span>
                                <i class="la la-wrench"></i>
                                {{ sp.text }}
                            </span>
                            <touch-spin :value="sp.proficiency" @change="data.skillsAndProficiencies.skills[i].proficiency = $event"></touch-spin>
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
                            <h5>
                                <i class="la la-language"></i>
                                {{ lang.text }}
                            </h5>
                            <div class="language-proficiencies">
                                <span>Spoken</span>
                                <touch-spin :value="lang.proficiency.spoken" @change="data.skillsAndProficiencies.languages[i].proficiency.spoken = $event"></touch-spin>
                            </div>
                            <div class="language-proficiencies">
                                <span>Written</span>
                                <touch-spin :value="lang.proficiency.written" @change="data.skillsAndProficiencies.languages[i].proficiency.written = $event"></touch-spin>
                            </div>
                       </div>
                   </template>
                   <span v-show="!data.skillsAndProficiencies.languages.length">None entered</span>
                </div>
                <!-- END LANGUAGES -->
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
import { mapGetters } from 'vuex';

export default {
    props: {
        data: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            skill: '',
            language: '',
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
    components: {
        TouchSpin,
        VueTagsInput
    },
    mixins: [
        ArrayHelperMixin
    ]
}
</script>
