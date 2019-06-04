/** Author: Mike 01/25/2019
 *
 * When you need this, you are going to:
 *
 * 1. Add this to the import part of the vue page where the targeted vue-tag-input is located:
 *
 *    import SkillsOptionMixin from '@common/mixin/SkillsOptionMixin';
 *
 * 2. Add id on the (main) vue-tag-input of the skill field (assuming the id is 'skillsSelection')
 * 3. Add additional attributes to the main vue-tag-input skill field like below
 *
 *      @focus="soControlTag(skills,'skillsData','skills', 'skillsSelection', tagOptionData,'skillsFlag',true)"
 *      @blur="soControlTag(skills,'skillsData','skills', 'skillsSelection', tagOptionData,'skillsFlag',false)"
 *
 * 3. Add additional vue tag like below (after the main vue-tag-input code block)
 *
 *  <vue-tags-input
 *      id="skillsOptions"
 *      v-model="tagOptionData.skillsField"
 *      v-show="tagOptionData.skillsFlag"
 *      :tags="soFilteredSkills(skills,'skillsData','skills',skillsData.skills)"
 *      :add-only-from-autocomplete="false"
 *      @select="blur()"
 *  />
 *
 * 4. Update the function being called in @before-adding-tag and @before-deleting-tag to also call below
 *
 *    this.soGainFocus("input#skillsSelection");
 *
 *    Preferrably the last. This needs to gain focus back after removing or adding new element, so the
 *    selection options will not be hidden eventually
 *
 * That's it!
 *
 *
 * This has been tested on single vue-tag-input implementation per vue page. If there will be multiple
 * vue-tag-input components, you may add additional tagOptionsData variables to accommodate their individual
 * flags. The only possible conflicts when using this with multiple vue-tag-input components are their flag
 * variables only, so you need to accommodate each of them. Ideally, to make it easy to work with multiple
 * vue-tag-input, duplicate this file and update the dependency (variables and its parent variable)
 *
 */

import EDBMixin from '@common/mixin/EDBMixin';
import jQuery from 'jquery';

export default {
    data() {
        return {
            tagOptionData: {
                objectTarget: '',

                /**
                 *  This is dedicated 2 variables for skills, if there are other vue-tag-input, create your
                 *  own pair of variables here and implement it the same way in public applicant form
                 */
                skillsFlag: false,
                skillsField: ''
            }
        };
    },
    methods: {
        soControlTag(source, varParent, varChild, vueTagId, obj, node, bool){
            let vm = this;
            this.tagOptionData.objectTarget = "input#".concat(vueTagId);

            setTimeout(function(){ vm.soRegisterTriggers(source, varParent, varChild); }, 20);
            setTimeout(function(){
                if(!bool){
                    /** It will not close until the skill selection text field blurs **/
                    if($(vm.tagOptionData.objectTarget).is(":focus")){
                        obj[node] = true;
                    } else {
                        obj[node] = bool;
                    }
                } else {
                    obj[node] = bool;
                }
            },300);
        },
        soFilteredSkills(source, varParent, varChild, selected){
            let excluded = [];
            let remaining = [];
            let vm = this;

            setTimeout(function(){ vm.soRegisterTriggers(source, varParent, varChild); }, 20);
            selected.forEach(obj => { excluded.push(obj.text); });
            source.forEach(obj => {
                if(!this.edbInArray(obj.text, excluded)){
                    remaining.push(obj);
                }
            });
            return remaining;
        },
        soRegisterTriggers(source, varParent, varChild){
            let $ = jQuery;
            let vm = this;
            $("div#skillsOptions > div > ul > li.new-tag-input-wrapper").remove();
            $("div#skillsOptions > div > ul > li").each(function(){
                $(this).css("cursor","pointer");
                $(this).find("div.actions").remove();
                $(this).attr("title","Click to add skill");
                $(this).find("div.content > div.tag-center > span").click(function(){
                    vm.soInsertClicked(source, varParent, varChild, $(this)[0].innerHTML);
                });
            });
        },
        soInsertClicked(source, varParent, varChild, selected){
            let vm = this;
            let $ = jQuery;
            let alreadyExists = false;

            this[varParent][varChild].every((obj) => {
                if(obj.text == selected){
                    alreadyExists = true;
                    return false;
                } else { return true; }
            });

            if(!alreadyExists){
                $(vm.tagOptionData.objectTarget).focus();
                source.every((obj) => {
                    if(obj.text == selected){
                        vm[varParent][varChild].push(obj);
                    } else { return true; }
                });
            }
        },
        soGainFocus(target){
            let $ = jQuery;
            $(target).focus();
        }
    },
    mixins: [
        EDBMixin
    ]
}
