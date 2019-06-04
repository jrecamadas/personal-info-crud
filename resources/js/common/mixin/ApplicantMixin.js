import $ from 'jquery';

export default {
    data() {
        return {
            ApplicantMixinData: {
                navItem: {
                    selected: 'basic',
                    style: 'border-bottom: 4px solid rgb(66, 165, 245)'
                },
                skills: {
                    style:  "scroll-behavior: smooth;\n" +
                            "overflow: hidden scroll;\n" +
                            "max-height: 375px!important;",
                },
                workExperience: {
                    style:  "scroll-behavior: smooth;\n" +
                            "overflow: hidden scroll;\n" +
                            "max-height: 150px!important;",
                },
                education: {
                    style:  "scroll-behavior: smooth;\n" +
                        "overflow: hidden scroll;\n" +
                        "max-height: 310px!important;",
                },
                progressbar: 0,
                indicator: {
                    address1: '',
                    address2: '',
                    city: '',
                    state: '',
                    zip: '',

                    paddress1: '',
                    paddress2: '',
                    pcity: '',
                    pstate: '',
                    pzip: '',
                }
            }
        };
    },
    methods: {
        setNavItemSelected(str) {
            this.ApplicantMixinData.navItem.selected = str;
        },
        getNavItemCSS(str) {
            return this.ApplicantMixinData.navItem.selected === str ? this.ApplicantMixinData.navItem.style : '';
        },
        getSkillsCanScroll(length){
            /** Mike 05/27/2019 Suppress scrollable feature as it has conflict with IE Edge.
             * When IE Edge is basing in Chromium, enable this back **/
            //return length >= 5 ? this.ApplicantMixinData.skills.style : 'overflow: hidden; height: auto!important;';

            return 'overflow: hidden; height: auto!important;';
        },
        getWorkExperienceCanScroll(length){
            return length >= 3 ? this.ApplicantMixinData.workExperience.style : 'overflow: hidden; height: auto!important;';
        },
        getEducationCanScroll(length){
            return length >= 5 ? this.ApplicantMixinData.education.style : 'overflow: hidden; height: auto!important;';
        },
        getEducationalAttainmentText(obj,id){
            let text = '';
            obj.every((obj) => {
                if(obj.id === parseInt(id)){
                    text = obj.text;
                    return false;
                } else { return true; }
            });
            return text;
        },

        hasValue(object, stack) {
            let has = false;
            _.each(stack, (key) => {
                if (!this.isEmpty(object[key])) {
                    has = true;
                    return;
                }
            });
            return has;
        },
        hasValueAll(object, stack) {
            let has = true;
            _.each(stack, (key) => {
                if (this.isEmpty(object[key])) {
                    has = false;
                    return;
                }
            });
            return has;
        },
        hasNoValueAll(object, stack) {
            let has = true;
            _.each(stack, (key) => {
                if (!this.isEmpty(object[key])) {
                    has = false;
                    return;
                }
            });
            return has;
        },
        hasIncompleteValues(object, stack) {
            let has = 0;
            let hasnt = 0;
            stack.forEach((key) => {
                if (this.isEmpty(object[key])) {
                    hasnt += 1;
                } else {
                    has += 1;
                }
            });
            return (has >= 1) && (hasnt >= 1);
        },

        /**
         * Test to see if the file ("filename.ex") is valid according to extensions (stack)
         * @param file - file name with/without extension eg. filename.ex
         * @param extensions - stack eg. ['.exe', '.doc', '.etc']
         * @return true if file's file extension is also in extensions
         */
        isValidCV(file, extensions){
            if(!file || file.indexOf('.') < 0){ return false; }
            return _.some(extensions, _.unary(_.partialRight(_.includes, file.split('.')[1])));
        },

        validateSkills(skills){
            let pass = true;
            skills.forEach((skill) => {
                pass = skill.proficiency            ? pass : false;
                pass = skill.years_of_experience    ? pass : false;
                pass = skill.no_of_projects_handled ? pass : false;
                pass = skill.project_roles          ? pass : false;
            });
            return pass;
        },
        isValidWorkExperiencePeriod(obj){
            const dateStart = moment(obj.start_date).unix();
            const dateEnd = moment(obj.end_date).unix();

            if (!isNaN(dateStart) && !isNaN(dateEnd)) {
                return dateStart < dateEnd;
            }
            return false;
        },

        //////////////////////////// WORK EXPERIENCE VALIDATION ////////////////////////////
        clearWorkExperienceFields(form){
            form.id = '';
            form.employee_id = '';
            form.job_title = '';
            form.company_name = '';
            form.description = '';
            form.reason_for_leaving = '';
            form.role = '';
            form.start_date = '';
            form.end_date = '';
        },
        clearEducationFields(form){
            form.id = '';
            form.employee_id = '';
            form.educational_attainment_id = '';
            form.course_degree = '';
            form.school_university = '';
            form.year_completed = '';
            form.is_present = '';
            form.order = '';
        },

        progress(val){
            this.ApplicantMixinData.progressbar = val;
        },

        /**
         * returns CSS class for error when the passed value is blank
         * @param v
         * @returns {string}
         */
        isRequired(variable, useStyle = false){
            if(useStyle){
                return variable ? 'non-error' : 'border: 1px solid red !important;border-width: 0.3mm!important;'; //:style
            } else {
                return variable ? 'non-error' : 'error'; //:class
            }
        },

        /******************************** Error Indicator Handling - Applicant Form ***********************************/
        checkRequired(variable, flag){
            if(variable){
                this.ApplicantMixinData.indicator[flag] = 1;
            }

            if(this.ApplicantMixinData.indicator[flag]){
                return variable ? 'background-color: #f3d4d4 !important;' : '';
            } else {
                return '';
            }
        },
        addIndicator(errorFlag, variable = '', checkVariable = false){
            if(!checkVariable){
                return this.errors.has(errorFlag) ? 'input-required' : '';
            } else {
                return !variable ? 'input-required' : '';
            }
        }
    }
}
