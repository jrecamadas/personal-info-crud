<template>
    <modal-dialog v-show="openModal" :options="option" :title="modal_title" @close="closeModal">
        <template slot="button">
            <!-- <div class="loading-indicator-container"><i v-show="loading_data" class="fa fa-spinner fa-spin loading-indicator"></i></div> -->
            <save-button :loading="loading_data" :options="button" @action="save" :disabled="!valid">{{ modal_save }}</save-button>
        </template>
        <template slot="body">
            <div class="s-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                <ul class="nav ks-nav-tabs">
                    <li class="nav-item" :style="getNavItemCSS('basic')">
                        <a href="javascript:;" class="nav-link active" data-toggle="tab" data-target="#basic" aria-expanded="true" @click="setNavItemSelected('basic')">
                            General
                        </a>
                    </li>
                    <li class="nav-item" :style="getNavItemCSS('address')">
                        <a href="javascript:;" class="nav-link" data-toggle="tab" data-target="#address" aria-expanded="false" @click="setNavItemSelected('address')">
                            Address
                        </a>
                    </li>
                    <li class="nav-item" :style="getNavItemCSS('skills')">
                        <a href="javascript:;" class="nav-link" data-toggle="tab" data-target="#skills" aria-expanded="false" @click="setNavItemSelected('skills')">
                            Skills
                        </a>
                    </li>
                    <li class="nav-item" :style="getNavItemCSS('experience')">
                        <a href="javascript:;" class="nav-link" data-toggle="tab" data-target="#experience" aria-expanded="false" @click="setNavItemSelected('experience')">
                            Work Experience
                        </a>
                    </li>
                    <li class="nav-item" :style="getNavItemCSS('education')">
                        <a href="javascript:;" class="nav-link" data-toggle="tab" data-target="#education" aria-expanded="false" @click="setNavItemSelected('education')">
                            Education
                        </a>
                    </li>
                    <li class="nav-item" :style="getNavItemCSS('otherDetails')">
                        <a href="javascript:;" class="nav-link" data-toggle="tab" data-target="#otherDetails" aria-expanded="false" @click="setNavItemSelected('otherDetails')">
                            Other Details
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- -------------------------- BASIC --------------------------- -->
                    <div class="tab-pane active" id="basic" role="tabpanel" aria-expanded="false">
                        <div class="row content-row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" :class="{ 'has-error': errors.has('first_name') }">
                                            <label>First Name<span class="error">*</span></label>
                                            <input type="text" v-validate="'required'" ref="firstName" name="first_name" class="form-control" v-model="employeeData.firstName"/>
                                            <span v-show="errors.has('first_name')" class="help-block form-error">{{ this.stringReplace(errors.first('first_name'),'first_name','First Name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" name="middle_name" class="form-control" v-model="employeeData.middleName"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" :class="{ 'has-error': errors.has('last_name') }">
                                            <label>Last Name<span class="error">*</span></label>
                                            <input type="text" v-validate="'required'" name="last_name" class="form-control" v-model="employeeData.lastName"/>
                                            <span v-show="errors.has('last_name')" class="help-block form-error">{{ this.stringReplace(errors.first('last_name'),'last_name','Last Name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" :class="{ 'has-error': errors.has('contact_no') }">
                                            <label>Contact No<span class="error">*</span></label>
                                            <input type="tel" name="contact_no" class="form-control"
                                                v-model="employeeData.contactNo"
                                                v-validate="'required|numeric'"
                                                v-mask="'############'"
                                                @keypress="checkContactNumber"/>
                                            <span v-show="errors.has('contact_no')" class="help-block form-error">{{ this.stringReplace(errors.first('contact_no'),'contact_no','Contact No') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" :class="{'has-error': errors.has('email')}">
                                            <label>Email Address:<span class="error">*</span></label>
                                            <input type="text" v-validate="'required|email'" name="email" class="form-control" v-model="employeeData.email"/>
                                            <span v-show="errors.has('email')" class="help-block form-error">{{ this.stringReplace(errors.first('email'),'email','Email Address') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Applicant Status:<span class="error">*</span></label> 
                                            <div class="current-status">
                                                <div class="status-level">
                                                    <div class="status-el">
                                                        <select2
                                                            v-if="statusData.options && statusData.options.length"
                                                            :value="statusData.selected"
                                                            :options="statusData.options"
                                                            :style="'width: 100%;height: 36px!important;'"
                                                            @select="statusData.selected = $event">
                                                            <option value="0">&nbsp;&nbsp;------------</option>
                                                        </select2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group" :class="{'has-error': errors.has('contact_no')}">
                                            <label>Job Position Applying for:<span class="error">*</span></label>
                                            <div class="current-position">
                                                <div class="position-level">
                                                    <div class="position-el">
                                                        <select2
                                                            v-if="positionLevels.length"
                                                            :value="formData.level"
                                                            :options="positionLevels"
                                                            :style="'width: 110px;height: 36px!important;'"
                                                            @select="formData.level = $event">
                                                            <option value="0">&nbsp;&nbsp;---------</option>
                                                        </select2>
                                                    </div>
                                                </div>
                                                <div class="position">
                                                    <vue-tags-input
                                                        v-if="positions.length"
                                                        v-model="formData.position"
                                                        :tags="formData.positions"
                                                        :add-only-from-autocomplete="true"
                                                        :autocomplete-items="filteredPositions"
                                                        :max-tags=1
                                                        @tags-changed="newPosition => formData.positions = newPosition"
                                                        @before-adding-tag="addPosition"
                                                        :placeholder="formData.positions.length>0?'':'Select Position'"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>CV/Resume File:<span class="error">*</span></label>
                                            <a :href="applicant_cv_path" target="_blank" v-if="fileUpload.medium==null && applicant_cv_path!=''">Uploaded CV</a>
                                            <span v-if="fileUpload.medium!=null && invalidFileType==false" class="ks-text file-selected-indicator">New File Selected</span>
                                            <span v-if="fileUpload.medium!=null && invalidFileType==true" class="ks-text file-selected-indicator">Only .doc, .docx, &amp; .pdf files are allowed.</span>
                                            <div class="col-sm-10">
                                                <label class="btn btn-primary ks-btn-file">
                                                    <span class="la la-cloud-upload ks-icon"></span>
                                                    <span class="ks-text">Choose file</span>
                                                    <input type="file" name="applicantResume" ref="files" id="applicantResume" @change="handleFileUpload($event)" :accept="filter_fileTypes.join(', ')">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ------------------------- ADDRESS -------------------------- -->
                    <div class="tab-pane" id="address" role="tabpanel" aria-expanded="false">
                        <div class="row content-row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a class="address-wrapper flex link">
                                        <span class="la la-map-marker this-icon"></span>
                                        <label class="content-header-text">Current Address</label>
                                    </a>
                                    <div>
                                        <div class="address-wrapper">
                                            <input v-model="addressData.address.line_1" type="text" name="line_1" placeholder="Address Line 1" class="form-control"/>
                                        </div>
                                        <div class="address-wrapper">
                                            <input v-model="addressData.address.line_2" type="text" name="line_2" placeholder="Address Line 2" class="form-control"/>
                                        </div>
                                        <div class="address-wrapper flex">
                                            <input v-model="addressData.address.city" type="text" name="city" placeholder="City" class="form-control"/>
                                            <input v-model="addressData.address.state_province" type="text" name="state_province" placeholder="State / Province" class="form-control"/>
                                        </div>
                                        <div class="address-wrapper flex">
                                            <input v-model="addressData.address.postal_zip_code" type="text" name="zip_code" placeholder="Postal / Zip Code" class="form-control"/>
                                            <select2
                                                :if="countriesReady"
                                                :options="countries"
                                                :value="addressData.address.country_id"
                                                @select="addressData.address.country_id = $event"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row content-row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a class="address-wrapper flex link">
                                        <span class="la la-map-marker this-icon"></span>
                                        <label class="content-header-text">Permanent Address</label>
                                    </a>
                                    <div class="custom-control custom-checkbox">
                                        <input v-model="addressData.sameAsPresent" type="checkbox" id="is_present" name="is_present" class="custom-control-input"/>
                                        <label class="custom-control-label noselect" for="is_present">Same as the Present Address</label>
                                    </div>
                                    <div id="control-permanent-address">
                                        <div>
                                            <div class="address-wrapper">
                                                <input type="text" name="line_1" placeholder="Address Line 1" class="form-control"
                                                    v-model="addressData.paddress.line_1"
                                                    :disabled="isAddressEditable()"/>
                                            </div>
                                            <div class="address-wrapper">
                                                <input type="text" name="line_2" placeholder="Address Line 2" class="form-control"
                                                    v-model="addressData.paddress.line_2"
                                                    :disabled="isAddressEditable()"/>
                                            </div>
                                            <div class="address-wrapper flex">
                                                <input type="text" name="city" placeholder="City" class="form-control"
                                                    v-model="addressData.paddress.city"
                                                    :disabled="isAddressEditable()"/>
                                                <input type="text" name="state_province" placeholder="State / Province" class="form-control"
                                                    v-model="addressData.paddress.state_province"
                                                    :disabled="isAddressEditable()"/>
                                            </div>
                                            <div class="address-wrapper flex">
                                                <input type="text" name="postal_zip_code" placeholder="Postal / Zip Code" class="form-control"
                                                    v-model="addressData.paddress.postal_zip_code"
                                                    :disabled="isAddressEditable()"/>
                                                <select2
                                                    :disabled="isAddressEditable()"
                                                    :if="countriesReady"
                                                    :options="countries"
                                                    :value="addressData.paddress.country_id"
                                                    @select="addressData.paddress.country_id = parseInt($event)"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- -------------------------- SKILLS -------------------------- -->
                    <div class="tab-pane" id="skills" role="tabpanel" aria-expanded="false">
                        <div class="row content-row">
                            <div class="col-sm-12 padding-bottom">
                                <a class="flex link">
                                    <span class="la la-wrench this-icon"></span>
                                    <label class="content-header-text">Skills</label>
                                </a>
                                <!-- BEGIN SKILLS -->
                                <vue-tags-input
                                    id="skillsSelection"
                                    v-model="skill"
                                    v-if="skills"
                                    :tags="skillsData.skills"
                                    :autocomplete-items="filteredSkills"
                                    :add-only-from-autocomplete="true"
                                    @tags-changed="newSkill => skillsData.skills = newSkill"
                                    @before-adding-tag="beforeAddingSkillTag"
                                    @before-deleting-tag="beforeDeletingSkillTag"
                                    placeholder="Enter Skill"
                                    @focus="soControlTag(skills,'skillsData','skills', 'skillsSelection', tagOptionData,'skillsFlag',true)"
                                    @blur="soControlTag(skills,'skillsData','skills', 'skillsSelection', tagOptionData,'skillsFlag',false)"/>
                                <vue-tags-input
                                    id="skillsOptions"
                                    v-model="tagOptionData.skillsField"
                                    v-show="tagOptionData.skillsFlag"
                                    :tags="soFilteredSkills(skills,'skillsData','skills',skillsData.skills)"
                                    :add-only-from-autocomplete="false"
                                    @select="blur()"/>
                                <div class="skills-and-proficiencies-wrapper">
                                    <div v-show="skillsData.skills.length">
                                        <h4 class="content-header-text">Proficiencies</h4>
                                        <div v-for="(skill, i) in skillsData.skills" :key="'skill-' + skill.id" class="skills-and-proficiencies">
                                            <div class="col-sm-3">
                                                <span class="skill-item"><i class="la la-wrench"></i>{{ skill.text }}</span>
                                            </div>
                                            <div class="col-sm-3 proficiency-width">
                                                <div class="form-group">
                                                    <touch-spin :value="skill.proficiency" @change="skillsData.skills[i].proficiency = $event"></touch-spin>
                                                </div>
                                            </div>
                                            <div class="flex-sm-column-reverse">
                                                <div class="form-group" :class="skill.years_of_experience ? '' : 'has-danger'">
                                                    <input v-model="skill.years_of_experience" v-mask="'##'" placeholder="Years of Experience" name="years_of_experience" type="tel" class="form-control" title="Years of Experience"/>
                                                </div>
                                            </div>
                                            <div class="flex-sm-column-reverse">
                                                <div class="form-group" :class="skill.no_of_projects_handled ? '' : 'has-danger'">
                                                    <input v-model="skill.no_of_projects_handled" v-mask="'####'" placeholder="# Projects Handled" name="no_of_projects_handled" type="tel" class="form-control" title="Projects Handled"/>
                                                </div>
                                            </div>
                                            <div class="flex-sm-column-reverse">
                                                <div class="form-group" :class="skill.project_roles ? '' : 'has-danger'">
                                                    <input v-model="skill.project_roles" placeholder="Project Role" name="project_roles" type="text" class="form-control" title="Project Roles"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span v-show="!skillsData.skills.length">No skills entered</span>
                                </div>
                                <!-- END SKILLS -->
                            </div>
                        </div>
                        <div class="row content-row">
                            <div class="col-sm-6 padding-bottom">
                                <div>
                                    <a class="flex link">
                                        <span class="la la-wrench this-icon"></span>
                                        <label class="content-header-text">Other Skills</label>
                                    </a>
                                    <textarea v-model="skillsData.otherSkills.description" class="form-control" name="other_skills" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ---------------------- WORK EXPERIENCE --------------------- -->
                    <div class="tab-pane" id="experience" role="tabpanel" aria-expanded="false">
                        <div class="row content-row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Company Name:</label>
                                            <input type="text" name="company_id" class="form-control" v-model="workExperienceData.form.company_name"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Job Title:</label>
                                            <input type="text" name="job-title_id" class="form-control" v-model="workExperienceData.form.job_title"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Start Date:</label>
                                            <flat-pickr
                                                name="start_date"
                                                placeholder="Select a date"
                                                v-model="workExperienceData.form.start_date"
                                                :config="getConfig(true, false, { allowInput: true, onClose: function(selectedDates, dateStr, instance){ controlEnteredDate(instance,workExperienceData.form,'start_date') }})"
                                                v-validate="'date_format:YYYY-MM-DD|before:end_date'"/>
                                            <span v-show="errors.has('start_date')" class="help-block form-error">{{ errors.first('start_date') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>End Date:</label>
                                            <flat-pickr
                                                name="end_date"
                                                ref="end_date"
                                                placeholder="Select a date"
                                                v-model="workExperienceData.form.end_date"
                                                :config="getConfig(true, false, { allowInput: true, onClose: function(selectedDates, dateStr, instance){ controlEnteredDate(instance,workExperienceData.form,'end_date') }})"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Description:</label>
                                            <textarea class="form-control" name="reason Leaving" v-model="workExperienceData.form.description" rows="5" column="5" id="description" placeholder="Type here.."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Reason for Leaving:</label>
                                            <textarea class="form-control" name="reason Leaving" v-model="workExperienceData.form.reason_for_leaving" rows="6" column="5" id="reason_for_leaving" placeholder="Type here.."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row work-experience-buttons-placeholder">
                                    <add-button :options="buttons.add_more" :disabled="isInvalidWorkExperience" @action="addWorkExperienceValue">
                                        {{ workExperienceData.form.id ? 'Update Record' : 'Add More' }}
                                    </add-button>
                                    &nbsp;&nbsp;
                                    <clear-button :options="button" @action="clearWorkExperienceFields(workExperienceData.form)" :disabled="hasNoValueAll(workExperienceData.form, workExperienceData.fields)">
                                        Clear
                                    </clear-button>
                                </div>
                            </div>
                        </div>
                        <div class="row content-row" v-if="workExperienceData.registered.length">
                            <table class="table text-light stacktable">
                                <thead class="thead-default">
                                    <tr>
                                        <!--<th width="1">#</th>-->
                                        <th>Company</th>
                                        <th>Job Title</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(work, index) in workExperienceData.registered" :key="index">
                                        <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.company_name }}</label></td>
                                        <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.job_title }}</label></td>
                                        <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.start_date }}</label></td>
                                        <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.end_date }}</label></td>
                                        <td class="work-experience-actions">
                                            <a href="javascript:;" @click="editWorkExperienceValue(index)" title="Edit Added Work Experience" class="action-button work-experience-action-button"><i class="la la-file-text-o"></i></a>
                                            <a href="javascript:;" @click="removeWorkExperienceValue(index)" title="Delete Work Experience" class="action-button work-experience-action-button"><i class="la la-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- ------------------------- EDUCATION ------------------------ -->
                    <div class="tab-pane" id="education" role="tabpanel" aria-expanded="false">
                        <div class="row content-row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Course/Degree:</label>
                                            <input type="text" name="course_degree" class="form-control" v-model="educationData.form.course_degree"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>School/University:</label>
                                            <input type="text" name="school_university" class="form-control" v-model="educationData.form.school_university"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Educational Attainment:</label>
                                            <select2
                                                v-if="attainments.length && educationData.attainmentOptions.length"
                                                :options="educationData.attainmentOptions"
                                                :value="educationData.form.educational_attainment_id"
                                                @select="educationData.form.educational_attainment_id = $event">
                                            </select2>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Year Completed:</label>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" name="year_completed" id="year_completed" placeholder="yyyy"
                                                           maxlength="4"
                                                           :disabled="educationData.form.is_present === 1 || educationData.form.is_present === true"
                                                           v-model="educationData.form.year_completed"
                                                           v-mask="'####'">
                                                    <span v-show="errors.has('year_completed')" class="help-block form-error">{{ replaceText(errors.first('year_completed'),'year_completed','Year Completed') }}</span>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="education_is_present" id="education_is_present"
                                                            v-model="educationData.form.is_present"
                                                            @click="controlYearCompleted"
                                                            :checked="educationData.form.is_present === 1">
                                                        <label for="education_is_present" class="custom-control-label">Currently Schooling</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row work-experience-buttons-placeholder">
                                    <add-button
                                        :options="buttons.add_more"
                                        @action="addEducationValue"
                                        :disabled="!isEducationFormComplete">
                                            {{ educationData.form.id ? 'Update Record' : 'Add More' }}
                                    </add-button>
                                    &nbsp;
                                    <clear-button
                                        :options="button"
                                        @action="clearEducationFields(educationData.form)"
                                        :disabled="hasNoValueAll(educationData.form, educationData.fields) && hasNoValueAll(educationData.form, ['year_completed', 'is_present'])">
                                        Clear
                                    </clear-button>
                                </div>
                            </div>
                        </div>
                        <div class="row content-row" v-if="educationData.registered.length">
                            <table class="table text-light stacktable">
                                <thead class="thead-default">
                                    <tr>
                                        <!--<th width="1">#</th>-->
                                        <th>Attained</th>
                                        <th>Course/Degree</th>
                                        <th>School/University</th>
                                        <th>Completed</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(education, index) in educationData.registered" :key="index">
                                        <td @click="editEducationValue(index)" class="weVal"><label>{{ getEducationalAttainmentText(educationData.attainmentOptions,education.educational_attainment_id) }}</label></td>
                                        <td @click="editEducationValue(index)" class="weVal"><label>{{ education.course_degree }}</label></td>
                                        <td @click="editEducationValue(index)" class="weVal"><label>{{ education.school_university }}</label></td>
                                        <td @click="editEducationValue(index)" class="weVal"><label>{{ education.is_present ? 'Ongoing' : education.year_completed }}</label></td>
                                        <td class="education-actions">
                                            <a href="javascript:void(0)" @click="editEducationValue(index)" title="Edit this record" class="action-button"><i class="la la-file-text-o"></i></a>
                                            <a href="javascript:void(0)" @click="removeEducationValue(index)" title="Delete this record" class="action-button"><i class="la la-trash"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- ----------------------- OTHER DETAILS ---------------------- -->
                    <div class="tab-pane" id="otherDetails" role="tabpanel" aria-expanded="false">
                        <div class="row content-row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Other Positions of Interest:</label>
                                            <input type="text" name="job_position_applied" class="form-control" v-model="otherDetailsData.job_position_applied" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Availability to Start:</label>
                                            <flat-pickr
                                                name="start_date_availability"
                                                placeholder="Select a date"
                                                v-model="otherDetailsData.start_date_availability"
                                                :config="getConfig(true, false, {allowInput: true, minDate: 'today', onClose: function(selectedDates, dateStr, instance){ controlEnteredDate(instance,otherDetailsData,'start_date_availability'); }})"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Preferred Shift</label>
                                            <select2
                                                v-if="shiftsData.options.length"
                                                :options="shiftsData.options"
                                                :value="shiftsData.value"
                                                @select="shiftsData.value = $event">
                                                <option value="CUSTOM_TIME">Custom Time</option>
                                            </select2>
                                            <div class="custom-shift" v-show="shiftsData.value == 'CUSTOM_TIME'">
                                                <div class="time-selection col-sm-6">
                                                    <div class="form-group" :class="shiftsData.start_time ? '' : 'has-danger'">
                                                        <label>Start Time</label>
                                                        <flat-pickr
                                                            name="start_time"
                                                            placeholder="Select a time"
                                                            v-model="shiftsData.start_time"
                                                            :config="getConfig(false)"/>
                                                    </div>
                                                </div>
                                                <div class="time-selection col-sm-6">
                                                    <div class="form-group" :class="shiftsData.start_time ? '' : 'has-danger'">
                                                        <label>End Time</label>
                                                        <flat-pickr
                                                            name="end_time"
                                                            placeholder="Select a time"
                                                            v-model="shiftsData.end_time"
                                                            :config="getConfig(false)"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Current Salary</label>
                                            <input :placeholder="'Enter Current Salary'" v-mask="'######'" type="text" name="current_salary" class="form-control" v-model="otherDetailsData.current_salary"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Expected Salary</label>
                                            <input :placeholder="'Enter Expected Salary'" v-mask="'######'" type="text" name="expected_salary" class="form-control" v-model="otherDetailsData.expected_salary"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row abroad">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input v-model="otherDetailsData.plan_work_abroad" type="checkbox" id="plan_work_abroad" name="plan_work_abroad" class="custom-control-input"/>
                                                <label class="custom-control-label noselect" for="plan_work_abroad">Plan to work abroad?</label>
                                            </div>
                                        </div>
                                        <div class="form-group" v-show="otherDetailsData.plan_work_abroad" :class="otherDetailsData.plan_work_abroad_when ? '' : 'has-danger'">
                                            <label>When do you plan to work Abroad?</label>
                                            <input type="text" name="plan_work_abroad_when" class="form-control" v-model="otherDetailsData.plan_work_abroad_when" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Interviewer:</label>
                                            <vue-tags-input
                                                placeholder="Enter Interviewer"
                                                v-model="interviewers"
                                                v-if="employeeNames && employeeNames.length"
                                                :tags="otherDetailsData.interviewersArray"
                                                :autocomplete-items="filteredInterviewers"
                                                :add-only-from-autocomplete="true"
                                                @tags-changed="newInput => otherDetailsData.interviewersArray = newInput"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group referrer">
                                            <label>Referred By: <span class="error">*</span></label>
                                            <vue-tags-input
                                                v-model="referrer"
                                                v-if="employeeNames && employeeNames.length"
                                                :max-tags=1
                                                :tags="otherDetailsData.referrerArray"
                                                :autocomplete-items="filteredReferrer"
                                                :add-only-from-autocomplete="true"
                                                :placeholder="otherDetailsData.referrerArray && otherDetailsData.referrerArray > 0 ? '' : 'Enter Referrer'"
                                                @tags-changed="newInput => otherDetailsData.referrerArray = newInput"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Remarks/Notes: </label>
                                            <textarea class="form-control" name="notes" rows="5" v-model="otherDetailsData.notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Recommendations: </label>
                                            <textarea class="form-control" name="recommendations" rows="6" v-model="otherDetailsData.recommendations"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-show="otherDetailsData.referral_type_id">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Applicant learned about FULL SCALE through: <span class="error">*</span></label>
                                            <!--<select2
                                                    v-if="referralTypesArray.length"
                                                    :options="referralTypesArray"
                                                    :value="otherDetailsData.referral_type_id"
                                                    @select="selectSource"
                                                    :disabled="true">
                                            </select2>-->
                                            <input type="text" v-show="!referralInput" name="referral_type" class="form-control" :value="getReferralValue()" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-show="otherDetailsData.referral_details">
                                    <div class="col-sm-12">
                                        <div class="form-group referrer">
                                            <label>{{ referralTypesSourceLabel }}: <span class="error">*</span></label>
                                            <!--<vue-tags-input
                                                    :max-tags=1
                                                    v-model="referrer"
                                                    v-show="referralInput"
                                                    v-if="employeeNames && employeeNames.length"
                                                    :tags="otherDetailsData.referrerArray"
                                                    :autocomplete-items="filteredReferrer"
                                                    :add-only-from-autocomplete="true"
                                                    @tags-changed="newInput => otherDetailsData.referrerArray = newInput"
                                                    :placeholder="otherDetailsData.referrerArray && otherDetailsData.referrerArray > 0 ? '' : 'Enter Referrer'"/>-->
                                            <input type="text" name="referral_details" class="form-control" :value="otherDetailsData.referral_details" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style type="text/css" src="../_assets/create-applicant.css"></style>
<style lang="scss" src="../_assets/create-applicant.scss" scoped></style>
<style scoped>
    .custom-control.custom-checkbox {
        margin-top: .7em;
    }
    .form-error {
        color: #f00;
    }
    textarea {
        resize: none;
    }
</style>

<script type="text/javascript">
//Components
import GenerateButton from '@components/form/button.vue';
import SaveButton from '@components/form/button.vue';
import ClearButton from '@components/form/button.vue';
import AddButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import Select2 from '@components/select2.vue';
import TouchSpin from '@components/touchspin.vue';
import VueTagsInput from '@johmun/vue-tags-input';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import { mask } from 'vue-the-mask';
//Mixins
import AssetMixin from '@common/mixin/AssetMixin';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DateMixin from '@common/mixin/DateMixin';
import ApplicantMixin from '@common/mixin/ApplicantMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import DatePickerMixin from '@common/mixin/DatePicker';
import SkillsOptionMixin from '@common/mixin/SkillsOptionMixin';

//Models
import { Employee } from '@common/model/Employee';
import { EmployeeJobPosition } from '@common/model/EmployeeJobPosition';
import { EmployeeStatus } from '@common/model/EmployeeStatus';
import { JobPosition } from '@common/model/JobPosition';
import { Asset } from '@common/model/Asset';
import { User } from '@common/model/User';
import { mapGetters, mapActions } from 'vuex';
import _ from 'lodash';
import { Validator } from 'vee-validate';

const dictionary = {
    en: {
        attributes: {
            start_date: "start date",
            end_date: "end date"
        }
    }
};

Validator.localize(dictionary);

export default {
    components: {
        GenerateButton,
        SaveButton,
        ClearButton,
        AddButton,
        ModalDialog,
        Select2,
        VueTagsInput,
        TouchSpin,
        FlatPickr
    },
    mixins: [
        AssetMixin,
        EmployeeMixin,
        StringHelperMixin,
        ModalDialogMixin,
        DateMixin,
        ApplicantMixin,
        AlertMixin,
        DatePickerMixin,
        SkillsOptionMixin
    ],
    directives: {
        mask
    },
    props: {
        applicant: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            option: {
                height: 'auto',
                width: '880px',
                bottom: 'auto'
            },
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            buttons: {
                add_more: {
                    class: 'btn btn-success',
                    type: 'button'
                }
            },
            loading_data: false,
            skill: '',
            referrer: '',
            interviewers: '',
            employeeNames: [], // This only contain array of (First name, middle name, last name) as text:
            shiftsData: {
                id: '',
                employee_id: '',
                shift_id: '',
                start_time: '12:00:00',
                end_time: '12:00:00',
                options: [],
                value: 1
            },
            deleted: {
                skills: []
            },
            addressData: {
                address: {
                    id: '',
                    employee_id: '',
                    country_id: 175,
                    line_1: '',
                    line_2: '',
                    city: '',
                    state_province: '',
                    postal_zip_code: '',
                    is_present: 1,
                    is_permanent: 0
                },
                paddress: {
                    id: '',
                    employee_id: '',
                    country_id: 175,
                    line_1: '',
                    line_2: '',
                    city: '',
                    state_province: '',
                    postal_zip_code: '',
                    is_present: 0,
                    is_permanent: 1
                },
                tempAddress: null,
                fields: ['id','employee_id','country_id','line_1','line_2','city','state_province','postal_zip_code','is_present','is_permanent'],
                sameAsPresent: false
            },
            skillsData: {
                skills: [],
                otherSkills: {
                    id: '',
                    employee_id: '',
                    description: ''
                }
            },
            employeeData: {
                employeeId: '',
                firstName: '',
                lastName: '',
                middleName: '',
                contactNo: '',
                email: ''
            },
            formData: {
                level: '',
                position: '',
                positions: [],
                employeeId: '',
                dateHired: '',
                startTime: '',
                endTime: ''
            },
            statusData: {
                selected: '0',
                options: [],
                values: []
            },
            workExperienceData: {
                form: {
                    id: '',
                    employee_id: '',
                    job_title:'',
                    company_name: '',
                    description: '',
                    reason_for_leaving: '',
                    order: '',
                    start_date: '',
                    end_date: '',
                },
                registered: [],
                fields: ['job_title','company_name','description','reason_for_leaving','start_date','end_date']
            },
            educationData: {
                form: {
                    id: '',
                    employee_id: '',
                    educational_attainment_id:'',
                    course_degree: '',
                    school_university: '',
                    year_completed: '',
                    is_present: '',
                    order: ''
                },
                registered: [],
                fields: ['educational_attainment_id','course_degree','school_university'],
                attainmentOptions: [],
            },
            otherDetailsData: {
                id: '',
                employee_id: '',
                job_position_applied: '',
                referred_by_employee_id: '',
                start_date_availability: '',
                current_salary: '',
                expected_salary: '',
                plan_work_abroad: '',
                plan_work_abroad_when: ' ',
                recommendations: '',
                interviewer: '',
                notes: '',
                referral_type_id: '',
                referral_details: '',
                referrerArray: [],
                interviewersArray: []
            },
            referralTypesArray: [],
            displayReferralTypesSource: false,
            referral: 1,
            socialMedia: 2,
            jobPortal: 3,
            referralTypesSourceLabel: 'Source',
            referralInput: false,
            modal_title: 'Add New Applicant',
            modal_save: 'Create Applicant',
            manualInput : false,
            validation: [
                { path: 'firstName', name: 'first_name', rule: 'required', msg: { required: 'First Name is required' } },
                { path: 'lastName', name: 'last_name', rule: 'required', msg: { required: 'Last Name is required' } },
            ],
            positions: [],
            level: '0',
            applicant_position_id: '',
            applicant_status_id: '',
            applicant_cv_path: '',
            applicant_cv_id: '', //Store the current CV id on load, and use this to delete if there's new CV coming
            applicant_hired_id: '',
            exclude_stats: ['ASSIGNED', 'AVAILABLE'],
            files:[],
            fileUpload: {
                folder: 'resume',
                assetable_id: '1',
                type: 2,
                assetable_type: 'employees',
                name:'Test.pdf',
                medium: null,
                medium_type: 'file',
                old_id: '',
                old_cv: ''
            },
            dialog_close_delay: 0,
            invalidFileType: false,
            fileTypes:['PDF', 'DOCX', 'DOC'],
            filter_fileTypes: ['.doc', '.DOC', '.docx', '.DOCX', '.pdf', '.PDF', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            email_regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            number_regex: /^[0\D]*|\D*/g,
            include: [
                'positions',
                'employeeStatuses',
                'contacts',
                'photo',
                'address',
                'skills',
                'otherSkills',
                'workExperiences',
                'educations',
                'otherDetails',
                'shift'
            ]
        }
    },
    computed: {
        ...mapGetters({
            years: 'years/formatted',
            skills: 'skills/formatted',
            shifts: 'workShifts/formatted',
            positionLevels: 'positionLevels/formatted',
            positionLevelDefault: 'positionLevels/defaultVal',
            statuses: 'statuses/data',
            loggedInUser: 'auth/data',
            employee: 'employees/single',
            employees: 'employees/data',
            countries: 'countries/formatted',
            countriesReady: 'countries/ready',
            countryDefault: 'countries/defaultVal',
            attainments: 'educationalAttainments/active',
            referralTypes: 'referralTypes/data',
        }),
        filteredPositions: function() {
            return this.positions.filter(i => new RegExp(this.formData.position, 'i').test(i.text));
        },
        filteredSkills: function() {
            return this.skills.filter(s => new RegExp(this.skill, 'i').test(s.text));
        },
        filteredReferrer: function() {
            return this.employeeNames.filter(s => new RegExp(this.referrer, 'i').test(s.text));
        },
        filteredInterviewers: function() {
            return this.employeeNames.filter(s => new RegExp(this.interviewers, 'i').test(s.text));
        },
        valid: function() { //Same with employee-list with modifications
            let valid = true;
            _.each(this.validation, (form) => {
                let rules = form.rule.split('|');
                _.each(rules, (rule) => {
                    if (rule == 'required') {
                        if (this.isEmpty(_.get(this.employeeData, form.path))) {
                            valid = false;
                            return;
                        }
                    }
                });

                if (!valid) return;
            });

            if(this.formData.positions.length <= 0){ valid = false; }
            if(this.statusData.selected <= 0){ valid = false; }
            if(!this.checkSelectedFile()){ valid = false; }
            if(this.applicant_cv_path == '' && this.fileUpload.medium == null){ valid = false; }
            if(this.employeeData.email == '' || !this.email_regex.test(this.employeeData.email)){ valid = false; }
            if(!this.number_regex.test(this.employeeData.contact_no)){ valid = false; }
            if(!this.validateSkills(this.skillsData.skills)){ valid = false; }
            if(this.hasIncompleteValues(this.workExperienceData.form,this.workExperienceData.fields)){ valid = false; }
            /** If there are changes here under education, please update isEducationFormComplete function as necessary **/
            if(this.hasIncompleteValues(this.educationData.form,this.educationData.fields)){ valid = false; }
            if(this.hasNoValueAll(this.educationData.form,this.educationData.fields) && !this.hasNoValueAll(this.educationData.form,['year_completed', 'is_present'])){ valid = false; }
            //if(this.isEmpty(this.educationData.form.year_completed) && this.isEmpty(this.educationData.form.is_present)){ valid = false; }
            //if(this.isEmpty(this.educationData.form.year_completed) && !this.educationData.form.is_present){ valid = false; }
            let yearRef = /\d{4}/;
            if(this.educationData.form.year_completed && !yearRef.test(this.educationData.form.year_completed)){ valid = false; }
            if(this.shiftsData.value === "CUSTOM_TIME" && (!this.shiftsData.start_time || !this.shiftsData.end_time)){ valid = false; }
            if(this.otherDetailsData.plan_work_abroad && !this.otherDetailsData.plan_work_abroad_when){ valid = false; }
            /** We don't validate what the applicant has entered in public applicant form */
            /*if(this.otherDetailsData.referral_type_id == ''){ valid = false; }
            if([this.socialMedia,this.jobPortal].includes(this.otherDetailsData.referral_type_id) && this.otherDetailsData.referral_details == ''){ valid = false; }
            if(this.otherDetailsData.referral_type_id == this.referral && this.otherDetailsData.referrerArray && !this.otherDetailsData.referrerArray.length) { valid = false; }*/
            // Check if Work Experience tab has error.
            if(Object.keys(this.fields).some(key => this.fields["start_date"].invalid)){ valid = false; }

            return valid;
        },
        isEducationFormComplete: function(){
            /** If there are changes here, please update the valid function too **/
            let complete = true;
            if(this.hasIncompleteValues(this.educationData.form,this.educationData.fields) || this.hasNoValueAll(this.educationData.form,['year_completed', 'is_present'])){ complete = false; }
            if(this.hasNoValueAll(this.educationData.form,this.educationData.fields) && !this.hasNoValueAll(this.educationData.form,['year_completed', 'is_present'])){ complete = false; }
            if(!this.educationData.form.year_completed && !this.educationData.form.is_present){ complete = false; }
            if(this.educationData.form.year_completed && this.educationData.form.year_completed.length !== 4){ complete = false; }
            
            return complete;
        },
        isInvalidWorkExperience() {
            return (!this.hasValueAll(this.workExperienceData.form, this.workExperienceData.fields) || Object.keys(this.fields).some(key => this.fields["start_date"].invalid));
        }
    },
    async created () {
        this.loading_data = true;
        if(this.applicant!=''){
            this.modal_title = "Update Applicant";
            this.modal_save = "Update";
        }

        this.getSkills({query: {take: 9999}, extra: {proficiency: 5}});
        await this.getYears({min: 2000, max: new Date().getFullYear()});
        await this.getActiveEducationalAttainments({query: {orderBy: 'level|asc'},extra: {}});
        await this.getReferralTypes({query: {take: 9999}});
        this.loadLevelAndPositions();
        await this.getStatuses({query: {take:9999, for:'applicant'}});
        this.statuses.forEach((obj)=>{
            if(obj.name.toUpperCase() !== "HIRED" || (obj.name.toUpperCase() === "HIRED" && this.applicant)){
                if(this.exclude_stats.indexOf(obj.description.toUpperCase())<0){
                    this.statusData.options.push({id:obj.id,text:obj.description});
                }
                if(obj.name.toUpperCase() === "HIRED"){
                    this.applicant_hired_id = obj.id;
                }
            }
        });

        await this.getCountries({query: {take: 9999}});
        await this.loadEducationalAttainmentOptions();
        await this.loadReferralTypesOptions();
        this.addressData.address.country_id = this.countryDefault[0];
        this.addressData.paddress.country_id = this.countryDefault[0];
        await this.getEmployees({query: {take: 999999, include: 'positions'}});
        await this.loadShifts();
        await this.employees.forEach((obj) => {
            this.employeeNames.push({ id: obj.id, text: (obj.first_name + ' ' + obj.middle_name + ' ' + obj.last_name) });
        });

        if(this.applicant!=''){
            await this.getApplicant({id: this.applicant, include: this.include.join(',')});
            await this.loadApplicantData();
            await this.loadAddresses();
            await this.loadSkills();
            await this.loadWorkExperiences();
            await this.loadEducation();
            await this.loadApplicantOtherDetails();
        }

        this.loading_data = false;
    },
    methods : {
        ...mapActions({
            getYears: 'years/getYears',
            getSkills: 'skills/getSkills',
            getShifts: 'workShifts/getWorkShifts',
            getStatuses: 'statuses/getStatuses',
            getApplicant: 'employees/getEmployee',
            getEmployees: 'employees/getEmployees',
            getCountries: 'countries/getCountries',
            getActiveEducationalAttainments: 'educationalAttainments/getActiveEducationalAttainments',
            resetCountries: 'countries/resetCountries',
            saveAddress: 'address/saveAddress',
            deleteAddress: 'address/deleteAddress',
            deleteApplicantSkill: 'employeeSkills/deleteEmployeeSkill',
            deleteWorkExperience: 'workExperience/deleteWorkExperience',
            deleteEducation: 'educations/deleteEducation',
            saveApplicantSkill: 'employeeSkills/saveEmployeeSkill',
            saveOtherSkills: 'empOtherSkills/saveEmployeeOtherSkill',
            saveWorkExperience: 'workExperience/saveWorkExperience',
            saveEducation: 'educations/saveEducation',
            saveEmployeeShift: 'employeeWorkShifts/saveEmployeeWorkShift',
            saveOtherDetail: 'employeeOtherDetails/saveEmployeeOtherDetail',
            saveContact: 'contact/saveContact',
            getReferralTypes: 'referralTypes/getReferralTypes'
        }),
        getReferralValue() {
            if(this.referralTypesArray && this.otherDetailsData.referral_type_id){
                let temp = this.referralTypesArray.filter(obj => obj.id == this.otherDetailsData.referral_type_id)[0];
                if(temp) { return temp.text; }
            }

            return '';
        },
        async save() {
            this.loading_data = true;
            const data = {
                first_name: this.employeeData.firstName,
                last_name: this.employeeData.lastName,
                middle_name: this.employeeData.middleName,
                contact_no: this.employeeData.contactNo,
                email: this.employeeData.email,
                gender: 'Male' /** Update this when gender option is available **/
            }

            if(this.applicant!='' && this.applicant_hired_id == this.statusData.selected) { //Hired triggered
                const title = 'This action converts the applicant to an employee.';
                const msg = 'Do you want to proceed?';
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                    .then(async({ ok }) => {
                        if (ok) {
                            let new_employee_no = '';
                            await this.getAvailableEmployeeNo().then((fs) => {
                                new_employee_no = fs;
                            });

                            let username = (this.employeeData.firstName.charAt(0) + this.employeeData.lastName).toLowerCase();
                            let email = username + '@fullscale.io';
                            await User.get({applicant: 'any', username: username, email: email}).then((res) => {
                                if (res.data[0] && res.data[0].id) {
                                    // It was agreed to instead leave the username and email as NULL if there's conflict.
                                    // We'll get back to this once we're on user management module.
                                    username = '';
                                    email = '';
                                    /** Mike 01-10-2019 Matt wants profile card to use hash instead of first/sur names in profile card URL **/
                                    // insert unique username for employee incase the username/employee selected is already existing in the DB
                                    //this.$set(data,'unique_str', new_employee_no.replace('-','').toLowerCase() + Math.random().toString(36).substring(2, 9));
                                }
                            });

                            this.$set(data,'unique_str', new_employee_no.replace('-','').toLowerCase() + Math.random().toString(36).substring(2, 9));
                            let userData = {
                                user_name: username,
                                email: email,
                                password: 'fullscale',
                                can_login: 0
                            };

                            let user = new User();
                            await user.save(userData).then((res) => {
                                this.$set(data,'employee_no', new_employee_no);
                                this.$set(data,'date_hired', this.formatDate(new Date(), "YYYY-MM-DD 00:00:00"));
                                this.$set(data,'user_id', res.data.id);
                                this.saveApplicant(data);
                            });
                        } else {
                            this.loading_data = false;
                        }
                    });
            }else{
                this.saveApplicant(data);
            }
        },
        _manualInput() {
            this.manualInput = true;
        },
        saveApplicant(data) {
            const employee = this.applicant!=''?new Employee({id:this.applicant}):new Employee();
            employee.save(data).then((res) => {
                this.savePosition(res.data.id).then((res2)=>{
                    let promises = [];
                    if(this.statusData.selected != this.applicant_status_id){
                        promises.push(this.saveApplicantStatus(res.data.id));
                    }

                    if(this.fileUpload.medium!=null){
                        this.fileUpload.assetable_id=res.data.id;
                        promises.push(this.submitFile());
                    }

                    if(this.applicant!='' && this.applicant_hired_id == this.statusData.selected){ // When hired, save contact_no to contacts table too (mobile)
                        let data = {
                            employee_id: this.applicant,
                            mobile_no: this.employeeData.contactNo
                        }

                        promises.push(this.saveContact(data));
                    }

                    promises.push(this.saveApplicantAddresses(res.data.id));
                    promises.push(this.saveSkills(res.data.id));
                    promises.push(this.saveWorkExperiences(res.data.id));
                    promises.push(this.saveApplicantEducation(res.data.id));
                    promises.push(this.saveApplicantOtherDetails(res.data.id)); //Applicant's Work shift will be called
                    Promise.all(promises).then((res3) => {
                        this.loading_data = false;
                        this.closeDialog();
                        this.notifyDialog('success', 'Successfully saved!');
                    });
                });
            });
        },
        async loadApplicantData() {
            this.employeeData.firstName = this.employee.first_name;
            this.employeeData.lastName = this.employee.last_name;
            this.employeeData.middleName = this.employee.middle_name;
            this.employeeData.contactNo = this.employee.contact_no;
            this.employeeData.email = this.employee.email;
            this.fileUpload.assetable_id = this.applicant;
            let pid = 0;
            let path = '';
            this.employee.photo.data.forEach((obj) => {
                if (obj.id > pid) {
                    pid = obj.id;
                    path = obj.path;
                }
            });

            this.applicant_cv_id = pid;
            this.fileUpload.old_id = pid;
            this.applicant_cv_path = path ? this.getAssetPath(path, true) : path;
            this.fileUpload.old_cv = path;
            let stat = "";
            this.employee.employeeStatuses.data.forEach((statobj) => {
                stat = statobj.status.id;
            });

            this.statusData.selected = stat;
            this.applicant_status_id = stat;
            let levelId = "";
            let positionId = "";
            let positionText = "";
            this.employee.positions.data.forEach((posobj) => {
                this.applicant_position_id = posobj.id;
                levelId = posobj.level_id;
                positionId = posobj.position_id;
                positionText = posobj.job_title;
            });

            this.formData.level = levelId;
            this.formData.positions.push({id: positionId, text: positionText});
        },
        async getAvailableEmployeeNo(){
            let freshNo = '';
            await this.generateEmployeeNo().then((newEmpNo) => {
                freshNo = newEmpNo;
            });

            return freshNo;
        },
        savePosition(employee_id){
            let employeeJobPosition = this.applicant_position_id!=''?new EmployeeJobPosition({id:this.applicant_position_id}):new EmployeeJobPosition();
            let employeeJobPositionData = {
                employee_id: employee_id,
                level: this.formData.level,
                position_id: this.formData.positions[0].id
            }

            return employeeJobPosition.save(employeeJobPositionData);
        },
        saveApplicantStatus(employee_id){
            let employeeStatus = new EmployeeStatus();
            let employeeStatusData = {
                employee_id: employee_id,
                status_id: this.statusData.selected,
                user_id: this.loggedInUser.data.id //This was fetched at login.vue
            }

            return employeeStatus.save(employeeStatusData);
        },
        loadLevelAndPositions(){
            // Load Level
            try {
                if(this.info.positions.data[0].level != '') {
                    this.level = this.info.positions.data[0].level_id;
                    this.formData.level = this.level;
                } else {
                    this.formData.level = '0';
                    this.level = '0';
                }
            } catch(e) {
                this.level = '0';
            }

            // Load Positions
            this.getPositions().then((res) => {
                let positions = res.data;
                _.each(positions, (position) => {
                    this.positions.push({
                        id: position.id,
                        text: position.job_title,
                    })
                });
            });
        },
        getPositions() {
            return JobPosition.get({
                take: 9999
            });
        },
        addPosition(obj) {
            obj.addTag();
        },
        handleFileUpload(e) {
            let uploadedFiles = e.target.files || e.dataTransfer.files;

            if (!uploadedFiles.length) {
                //Cancelled
                this.dialog_close_delay = 0;
                this.fileUpload.medium = null;
                return;
            } else if (!this.isValidCV(uploadedFiles[0].name.toUpperCase(), this.fileTypes)) {
                // Prompt user that the file is invalid
                // We don't touch the medium, this is to protect what was already set during edit
                const title = 'Please select a resume file in PDF/MSWord format. (With .pdf / .docx / .doc file extension)';
                const msg = `Filename: ${uploadedFiles[0].name}`;
                this.confirmDialog(title, msg, 'Close', '', 'sm');
                if(!this.applicant){
                    this.fileUpload.medium=null;
                    e.target.value = '';
                }

                return;
            } else if (uploadedFiles[0].size > 26214400) { // 25MB limit for admin
                const title = 'File limit exceeded. Please select a resume file not more than 25MB in file size.';
                const msg = `Filename: ${uploadedFiles[0].name}`;
                this.confirmDialog(title, msg, 'Close', '', 'sm');
                if(!this.applicant){
                    this.fileUpload.medium=null;
                    e.target.value = '';
                }

                return;
            }
            /** As reference - 10MB would need a delay of approx 1000 milliseconds */
            this.dialog_close_delay = (uploadedFiles[0].size / 10000);

            this.fileUpload.name = uploadedFiles[0].name;
            let reader = new FileReader();
            reader.onload = (e) => {
                this.fileUpload.medium = e.target.result;
                this.invalidFileType = true;

                if (this.checkSelectedFile()) {
                    this.invalidFileType = false;
                }
            };
            reader.readAsDataURL(uploadedFiles[0]);
        },
        checkSelectedFile() {
            if(this.fileUpload.name!='') {
                let extension = this.fileUpload.name.split('.');
                if(this.fileTypes.indexOf(extension[1].toUpperCase())>=0) {
                    return true;
                }
            }
            return false;
        },
        submitFile() {
            this.loading_data = true;
            let successful = true;
            if(this.checkSelectedFile()) {
                const asset = new Asset();
                asset.save(this.fileUpload).then(() => {
                    successful = true;
                });
            } else {
                successful = false;
            }

            return successful;
        },
        saveApplicantAddresses(employee_id) {
            if(this.hasValue(this.addressData.address, ['line_1', 'line_2', 'city', 'state_province', 'postal_zip_code'])) {
                this.saveAddress({
                    id: this.addressData.address.id,
                    employee_id: employee_id,
                    country_id: this.addressData.address.country_id,
                    line_1: this.addressData.address.line_1,
                    line_2: this.addressData.address.line_2,
                    city: this.addressData.address.city,
                    state_province: this.addressData.address.state_province,
                    postal_zip_code: this.addressData.address.postal_zip_code,
                    is_present: this.addressData.address.is_present,
                    is_permanent: this.addressData.sameAsPresent
                });
            }

            if(this.hasValue(this.addressData.paddress, ['line_1', 'line_2', 'city', 'state_province', 'postal_zip_code'])) {
                if(!this.addressData.sameAsPresent) {
                    this.saveAddress({
                        id: this.addressData.paddress.id,
                        employee_id: employee_id,
                        country_id: this.addressData.paddress.country_id,
                        line_1: this.addressData.paddress.line_1,
                        line_2: this.addressData.paddress.line_2,
                        city: this.addressData.paddress.city,
                        state_province: this.addressData.paddress.state_province,
                        postal_zip_code: this.addressData.paddress.postal_zip_code,
                        is_present: this.addressData.paddress.is_present,
                        is_permanent: this.addressData.paddress.is_permanent
                    });
                } else {
                    if(this.addressData.paddress.id) {
                        this.deleteAddress(this.addressData.paddress.id);
                    }
                }
            }
        },
        async loadAddresses(){
            if(this.employee.address.data && this.employee.address.data.length > 0) {
                let data = {};
                await this.employee.address.data.forEach((obj) => {
                    data = {
                        id: obj.id,
                        employee_id: this.employee.id,
                        country_id: parseInt(obj.country.data.id),
                        line_1: obj.line_1,
                        line_2: obj.line_2,
                        city: obj.city,
                        state_province: obj.state_province,
                        postal_zip_code: obj.postal_zip_code,
                        is_present: obj.is_present,
                        is_permanent: obj.is_permanent
                    };

                    if(obj.is_present) {
                        this.addressData.address = data;
                        this.addressData.sameAsPresent = obj.is_permanent;
                    } else if(!obj.is_present && obj.is_permanent) {
                        this.addressData.paddress = data;
                    }
                });
            }
        },
        isAddressEditable() {
            return this.addressData.sameAsPresent === 0 ? false : this.addressData.sameAsPresent;
        },
        saveSkills(employee_id) {
            let promises = [];
            let employeeSkillId = '';
            _.each(this.skillsData.skills, (skill, key) => {
                employeeSkillId = skill.record_id ? skill.record_id : '';
                promises.push(this.saveApplicantSkill({
                    id: employeeSkillId,
                    employee_id: employee_id,
                    skill_id: skill.id,
                    proficiency: skill.proficiency,
                    years_of_experience: skill.years_of_experience,
                    no_of_projects_handled: skill.no_of_projects_handled,
                    project_roles: skill.project_roles
                }));
            });

            if(this.employee != null && this.employee.skills && this.employee.skills.data) {
                let tempSkill = [];
                _.each(this.employee.skills.data, (skill, key) => {
                    tempSkill = this.skillsData.skills.filter((es) => es.id == skill.skill_id);
                    if(!tempSkill.length) {
                        promises.push(this.deleteApplicantSkill(skill.id));
                    }
                });
            }

            let self = this;
            Promise.all(promises).then((res) => {
                if( self.skillsData.otherSkills.description ) {
                    self.skillsData.otherSkills.employee_id = employee_id;
                    self.saveOtherSkills(self.skillsData.otherSkills);
                }
            });
        },
        async loadSkills(){
            if(this.employee.skills.data) {
                _.each(this.employee.skills.data, (skill)=>{
                    this.skillsData.skills.push({
                        record_id: skill.id, //transfer id into record_id because id will be utilized as the skill id
                        id: skill.skill_id, //The skill_id in record is the id of the array
                        employee_id: skill.employee_id,
                        skill_id: skill.skill_id,
                        proficiency: skill.proficiency,
                        years_of_experience: skill.years_of_experience,
                        no_of_projects_handled: skill.no_of_projects_handled,
                        project_roles: skill.project_roles,

                        text: skill.name
                    });
                });
            }

            if(this.employee.otherSkills && this.employee.otherSkills.data && this.employee.otherSkills.data.length > 0) {
                this.skillsData.otherSkills.id = this.employee.otherSkills.data[0].id;
                this.skillsData.otherSkills.employee_id = this.employee.otherSkills.data[0].employee_id;
                this.skillsData.otherSkills.description = this.employee.otherSkills.data[0].description;
            }
        },
        beforeAddingSkillTag(obj) {
            const deletedSkill = this.deleted.skills.filter(skill => skill.id == obj.tag.id);
            if(deletedSkill.length) {
                this.skillsData.skills.push(deletedSkill[0]);
            }

            obj.addTag();
            this.soGainFocus("input#skillsSelection");
        },
        beforeDeletingSkillTag(obj) {
            const skill = (this.employee != null && this.employee.skills != null) ? this.employee.skills.data.filter(skill => skill.skill_id == obj.tag.id) : [];
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

            obj.deleteTag();
            this.soGainFocus("input#skillsSelection");
        },
        saveApplicantOtherDetails(employee_id) {
            this.otherDetailsData.employee_id = employee_id;
            
            if(this.otherDetailsData.referrerArray && this.otherDetailsData.referrerArray.length) {
                this.otherDetailsData.referred_by_employee_id = this.otherDetailsData.referrerArray[0].id;
                this.otherDetailsData.referral_details = '';
            }

            if(!this.otherDetailsData.plan_work_abroad) {
                this.otherDetailsData.plan_work_abroad_when = '';
            }

            if(this.otherDetailsData.interviewersArray && this.otherDetailsData.interviewersArray.length) {
                let interviewers = [];
                this.otherDetailsData.interviewersArray.forEach((obj) => {
                    interviewers.push(obj.text);
                });
                this.otherDetailsData.interviewer = interviewers.join(',');
            }

            let data = {
                id: this.otherDetailsData.id,
                employee_id: this.otherDetailsData.employee_id,
                //job_position_applied: this.otherDetailsData.job_position_applied,
                referral_type_id: this.otherDetailsData.referral_type_id,
                referred_by_employee_id: this.otherDetailsData.referred_by_employee_id,
                start_date_availability: this.otherDetailsData.start_date_availability,
                //current_salary: this.otherDetailsData.current_salary,
                //expected_salary: this.otherDetailsData.expected_salary,
                //plan_work_abroad: this.otherDetailsData.plan_work_abroad ? 1 : 0,
                //plan_work_abroad_when: this.otherDetailsData.plan_work_abroad_when,
                recommendations: this.otherDetailsData.recommendations,
                interviewer: this.otherDetailsData.interviewer,
                notes: this.otherDetailsData.notes
            };

            /** Let's add these fields when they have values - the column have defaults to blank, but forcing them to
             *  include in the data even without value will throw the backend an error.
             */
            if(this.otherDetailsData.job_position_applied){  this.$set(data, 'job_position_applied',  this.otherDetailsData.job_position_applied); }
            if(this.otherDetailsData.current_salary){        this.$set(data, 'current_salary',        this.otherDetailsData.current_salary); }
            if(this.otherDetailsData.expected_salary){       this.$set(data, 'expected_salary',       this.otherDetailsData.expected_salary); }
            if(this.otherDetailsData.plan_work_abroad){      this.$set(data, 'plan_work_abroad',      this.otherDetailsData.plan_work_abroad); }
            if(this.otherDetailsData.plan_work_abroad_when){ this.$set(data, 'plan_work_abroad_when', this.otherDetailsData.plan_work_abroad_when); }
            if(this.otherDetailsData.referral_details){      this.$set(data, 'referral_details',      this.otherDetailsData.referral_details); }

            this.saveOtherDetail(data).then((res) => {
                this.saveApplicantShift(employee_id);
            });
        },
        async loadApplicantOtherDetails() {
            if(this.employee.otherDetails && this.employee.otherDetails.data) {
                let referrerArray = [];
                let interviewersArray = [];
                await this.employee.otherDetails.data.forEach((obj) => {
                     // Only load the latest record incase there are more
                    this.otherDetailsData = {
                        id: obj.id,
                        employee_id: obj.employee_id,
                        job_position_applied: obj.job_position_applied,
                        referred_by_employee_id: obj.referred_by_employee_id,
                        referral_type_id: obj.referral_type_id,
                        referral_details: obj.referral_details,
                        start_date_availability: obj.start_date_availability,
                        current_salary: obj.current_salary,
                        expected_salary: obj.expected_salary,
                        plan_work_abroad: obj.plan_work_abroad ? true : false,
                        plan_work_abroad_when: obj.plan_work_abroad_when,
                        recommendations: obj.recommendations,
                        interviewer: obj.interviewer,
                        notes: obj.notes,
                    }
                    
                    let referredBy = this.employees.filter(obj2 => obj.referred_by_employee_id === obj2.id);
                    if(referredBy.length) {
                        referrerArray.push({
                            id: referredBy[0].id,
                            text: (referredBy[0].first_name + ' ' + referredBy[0].middle_name + ' ' + referredBy[0].last_name)
                        });
                    }
                    
                    if(obj.interviewer) {
                        let splitted = obj.interviewer.split(',');
                        let fetched = '';
                        splitted.forEach((temp) => {
                            fetched = this.employees.filter(obj2 => (obj2.first_name + ' ' + obj2.middle_name + ' ' + obj2.last_name).toUpperCase() == temp.toUpperCase());
                            if(fetched && fetched.length){
                                interviewersArray.push({
                                    id: fetched[0].id,
                                    text: (fetched[0].first_name + ' ' + fetched[0].middle_name + ' ' + fetched[0].last_name)
                                });
                            }
                        });
                    }
                    
                });
                
                this.otherDetailsData.referrerArray = referrerArray;
                this.otherDetailsData.interviewersArray = interviewersArray;
            }
        },
        saveApplicantShift(employee_id) {
            if(this.shiftsData.value){
                if(this.shiftsData.value == "CUSTOM_TIME") {
                    this.shiftsData.shift_id = '';
                } else {
                    this.shiftsData.start_time = '';
                    this.shiftsData.end_time = '';
                    this.shiftsData.shift_id = this.shiftsData.value;
                }
            }

            this.saveEmployeeShift({
                id: this.shiftsData.id,
                employee_id: employee_id,
                shift_id: this.shiftsData.shift_id,
                start_time: this.shiftsData.start_time,
                end_time: this.shiftsData.end_time,
                start_time_timestamp: 0, // We need to set to zero so the mutator will generate timestamp on its own
                end_time_timestamp: 0 // We need to set to zero so the mutator will generate timestamp on its own
            });
        },
        async loadShifts() {
            await this.getShifts({query: {take: 9999}});
            await this.shifts.forEach((obj) => {
                this.shiftsData.options.push(obj);
            });

            if(this.applicant && this.employee && this.employee.shift && this.employee.shift.data) {
                let obj = this.employee.shift.data;
                this.shiftsData.id = obj.id;
                this.shiftsData.employee_id = obj.employee_id;
                this.shiftsData.shift_id = obj.shift_id;
                this.shiftsData.start_time = obj.shift_id <= 0 ? obj.time.ph.start : '';
                this.shiftsData.end_time = obj.shift_id <= 0 ? obj.time.ph.end : '';
                this.shiftsData.value = (this.employee.shift.data.shift_id === 0 ? "CUSTOM_TIME" : this.employee.shift.data.shift_id);
            }
        },
        async saveWorkExperiences(employee_id) {
            if(this.hasValueAll(this.workExperienceData.form,this.workExperienceData.fields)){
                await this.addWorkExperienceValue();
            }

            await this.workExperienceData.registered.forEach((work) => {
                if(!work.employee_id){ this.$set(work,'employee_id',employee_id); }
                if(!work.order){ this.$set(work,'order',0); }
                this.saveWorkExperience(work);
            });
            
            //Delete those removed in the list
            if(this.employee != null && this.employee.workExperiences && this.employee.workExperiences.data.length) {
                let tempData = [];
                await this.employee.workExperiences.data.forEach((work) => {
                    tempData = this.workExperienceData.registered.filter(obj => obj.id === work.id);
                    if(!tempData.length) {
                        this.deleteWorkExperience(work.id);
                    }
                });
            }
        },
        async loadWorkExperiences() {
            if(this.employee.workExperiences && this.employee.workExperiences.data.length) {
                this.employee.workExperiences.data.forEach((work) => {
                    this.workExperienceData.registered.push({
                        id: work.id,
                        employee_id: work.employee_id,
                        job_title: work.job_title,
                        company_name: work.company_name,
                        description: work.description,
                        reason_for_leaving: work.reason_for_leaving,
                        order: work.order,
                        start_date: work.start_date,
                        end_date: work.end_date,
                    });
                });
            }
        },
        async addWorkExperienceValue() {
            let data = {
                id: this.workExperienceData.form.id,
                employee_id: this.workExperienceData.form.employee_id,
                job_title: this.workExperienceData.form.job_title,
                company_name: this.workExperienceData.form.company_name,
                description: this.workExperienceData.form.description,
                reason_for_leaving: this.workExperienceData.form.reason_for_leaving,
                order: this.workExperienceData.form.order,
                start_date: this.workExperienceData.form.start_date,
                end_date: this.workExperienceData.form.end_date
            };

            if(this.workExperienceData.form.id) {
                await this.workExperienceData.registered.every((work) => {
                    if(work.id === this.workExperienceData.form.id){
                        work.employee_id = this.workExperienceData.form.employee_id;
                        work.job_title = this.workExperienceData.form.job_title;
                        work.company_name = this.workExperienceData.form.company_name;
                        work.description = this.workExperienceData.form.description;
                        work.reason_for_leaving = this.workExperienceData.form.reason_for_leaving;
                        work.order = this.workExperienceData.form.order;
                        work.start_date = this.workExperienceData.form.start_date;
                        work.end_date = this.workExperienceData.form.end_date;
                        return false;
                    } else { return true; }
                });
            } else {
                await this.workExperienceData.registered.push(data);
            }

            this.clearWorkExperienceFields(this.workExperienceData.form);
        },
        editWorkExperienceValue(nth) {
            this.workExperienceData.registered.every((work,index) => {
                if(index === nth) {
                    this.workExperienceData.form.id = work.id;
                    this.workExperienceData.form.employee_id = work.employee_id;
                    this.workExperienceData.form.job_title = work.job_title;
                    this.workExperienceData.form.company_name = work.company_name;
                    this.workExperienceData.form.description = work.description;
                    this.workExperienceData.form.reason_for_leaving = work.reason_for_leaving;
                    this.workExperienceData.form.order = work.order;
                    this.workExperienceData.form.start_date = work.start_date;
                    this.workExperienceData.form.end_date = work.end_date;
                    return false;
                }else { return true; }
            });
        },
        removeWorkExperienceValue(nth){
            this.workExperienceData.registered.splice(nth,1);
        },
        async saveApplicantEducation(employee_id){
            /** Also added another scenario here where they attempt to edit, change value but not clicked the "Update Record"*/
            if(this.hasValueAll(this.educationData.form,this.educationData.fields)) {
                await this.addEducationValue();
            }

            await this.educationData.registered.forEach((educ) => {
                if(!educ.employee_id){ this.$set(educ,'employee_id',employee_id); }
                if(!educ.order){ this.$set(educ,'order',0); }

                if(educ.year_completed === '' || isNaN(educ.year_completed) || educ.year_completed == 0) {
                    this.$set(educ,'is_present',1);
                } else {
                    this.$set(educ,'is_present',0);
                }
                
                this.saveEducation(educ);
            });

            //Delete those removed in the list
            if(this.employee != null && this.employee.educations && this.employee.educations.data.length){
                let tempData = [];
                await this.employee.educations.data.forEach((educ) => {
                    tempData = this.educationData.registered.filter(obj => obj.id === educ.id);
                    if(!tempData.length){
                        this.deleteEducation(educ.id);
                    }
                });
            }
        },
        async loadEducation(){
            this.educationData.registered = [];
            if(this.employee.educations && this.employee.educations.data.length){
                this.employee.educations.data.forEach((educ) => {
                    let data = {
                        id: educ.id,
                        employee_id: educ.employee_id,
                        educational_attainment_id: educ.educational_attainment_id,
                        course_degree: educ.course_degree,
                        school_university: educ.school_university,
                        year_completed: educ.year_completed === 0 ? '' : educ.year_completed,
                        is_present: educ.is_present,
                        order: educ.order
                    };
                    
                    this.educationData.registered.push(data);
                });
            }
        },
        async loadEducationalAttainmentOptions() {
            await this.attainments.forEach((obj) => {
                this.educationData.attainmentOptions.push({
                    id: obj.id,
                    text: obj.attainment
                });
            });
        },
        async addEducationValue() {
            let data = {
                id: this.educationData.form.id,
                employee_id: this.educationData.form.employee_id,
                educational_attainment_id: this.educationData.form.educational_attainment_id,
                course_degree: this.educationData.form.course_degree,
                school_university: this.educationData.form.school_university,
                year_completed: this.educationData.form.is_present ? 0 : this.educationData.form.year_completed,
                is_present: this.educationData.form.is_present ? 1 : 0,
                order: this.educationData.form.order
            };

            if(this.educationData.form.id) {
                await this.educationData.registered.every((educ) => {
                    if(educ.id === this.educationData.form.id) {
                        educ.employee_id = this.educationData.form.employee_id;
                        educ.educational_attainment_id = this.educationData.form.educational_attainment_id;
                        educ.course_degree = this.educationData.form.course_degree;
                        educ.school_university = this.educationData.form.school_university;
                        educ.year_completed = this.educationData.form.is_present ? 0 : this.educationData.form.year_completed;
                        educ.is_present = this.educationData.form.is_present ? 1 : 0;
                        educ.order = this.educationData.form.order;

                        return false;
                    } else { return true; }
                });
            } else {
                await this.educationData.registered.push(data);
            }

            this.clearEducationFields(this.educationData.form);
        },
        selectSource: function (selected) {
            selected = parseInt(selected);
            const withSource = [this.referral, this.socialMedia, this.jobPortal];
            if(withSource.includes(selected)) {
                this.displayReferralTypesSource = true

                /** We don't want to use the referrer id anymore, we'll just show the referrer details, no edits **/
                /*if(selected == this.referral) {
                    this.referralTypesSourceLabel = 'Referred By';
                    this.referralInput = true;
                    this.otherDetailsData.referral_details = ''
                } else {
                    this.referralTypesSourceLabel = 'Source'
                    this.referralInput = false;
                    this.otherDetailsData.referrerArray = []
                }*/
                this.referralInput = false;
                this.otherDetailsData.referrerArray = [];
            } else {
                this.displayReferralTypesSource = false
            }

            this.otherDetailsData.referral_type_id = selected
        },
        async loadReferralTypesOptions() {
            await this.referralTypes.forEach((obj) => {
                this.referralTypesArray.push({
                    id: obj.id,
                    text: obj.name
                });
            });
        },
        editEducationValue(nth ){
            this.educationData.registered.every((educ,index) => {
                if(index === nth) {
                    this.educationData.form.id = educ.id;
                    this.educationData.form.employee_id = educ.employee_id;
                    this.educationData.form.educational_attainment_id = educ.educational_attainment_id;
                    this.educationData.form.course_degree = educ.course_degree;
                    this.educationData.form.school_university = educ.school_university;
                    this.educationData.form.year_completed = educ.year_completed === 0 ? '' : educ.year_completed;
                    this.educationData.form.is_present = educ.is_present;
                    this.educationData.form.order = educ.order;

                    return false;
                }else { return true; }
            });
        },
        removeEducationValue(nth){
            this.educationData.registered.splice(nth,1);
        },
        controlYearCompleted() {
            let vm = this;
            setTimeout(()=> {
                if(vm.educationData.form.is_present){
                    vm.educationData.form.year_completed = '';
                }
            }, 20);
        },
        closeDialog() {
            /** This needs a delay as the file updated in the assets doesn't return the most up-to-date file name. */
            let vm = this;
            setTimeout(function() {
                vm.loading_data = false;
                vm.open = false;
                vm.$emit("success");
            }, this.dialog_close_delay > 500 ? parseInt(this.dialog_close_delay) + 200 : 500);
        },
        replaceText(str,look,replace) {
            if(str!=null && str!='') {
                return str.replace(look,replace);
            } return "";
        }
    },
    watch: {
        'addressData.sameAsPresent': function(value) {
            if (value) {
                this.addressData.temp = this.addressData.paddress;
                this.addressData.paddress = this.addressData.address;
            } else {
                this.addressData.paddress = this.addressData.temp;
            }
        }
    }
}
</script>
