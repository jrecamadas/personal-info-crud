<template>
    <div class="s-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light main-page">
        <div class="header-form bg-info">
            <div class="comp-logo-container">
                <img :src="fullScaleLogo" :alt="organizationShortNameAllCaps" class="comp-logo" />
            </div>
        </div>

        <div class="main-form">
            <div class="form-title">
                <span>
                    Application Form
                    <div class="loading-indicator-container"><i v-show="loading_data" class="fa fa-spinner fa-spin loading-indicator"></i></div>
                </span>
                <div class="ks-info" v-if="loading_data">
                    <div style="height:42px"></div>
                    <div class="progress ks-progress ks-progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" :style="'width: '+ApplicantMixinData.progressbar+'%'" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="refresh-page-container" v-if="loading_data">
                <span>It is unlikely to load the page this long. You may press Ctrl-F5 or <a href="javascript:void(0)" onclick="document.location.reload()">click here</a> to refresh the page.</span>
            </div>

            <!----------------- ACCORDION -------------------->
            <div class="col-sm-12 col-md-12" v-if="!loading_data">
                <!------- GENERAL --------->
                <div class="fs-accordion" :class="controlTabs.general">
                    <div class="fs-field">
                        <div class="card panel panel-default ks-information ks-light">
                            <div class="card-header" @click="controlTab('general')">
                                <h4 class="ks-text">General</h4>
                            </div>
                            <div class="card-block fs-accordion-content">
                                <div class="fs-info-wrapper">
                                    <!------------------------------>
                                    <div class="tab-pane active" id="basic" role="tabpanel" aria-expanded="false">
                                        <div class="row content-row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group" :class="{'has-error': errors.has('first_name')}">
                                                            <label>First Name<span class="error">*</span></label>
                                                            <input type="text" v-validate="'required'" ref="firstName" name="first_name" class="form-control" v-model="employeeData.firstName" :class="addIndicator('first_name')" />
                                                            <span v-show="errors.has('first_name')" class="help-block form-error">{{ this.stringReplace(errors.first('first_name'),'first_name','First Name') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input type="text"  name="middle_name" class="form-control" v-model="employeeData.middleName" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group" :class="{'has-error': errors.has('last_name')}">
                                                            <label>Last Name<span class="error">*</span></label>
                                                            <input type="text" v-validate="'required'" name="last_name" class="form-control" v-model="employeeData.lastName" :class="addIndicator('last_name')" />
                                                            <span v-show="errors.has('last_name')" class="help-block form-error">{{ this.stringReplace(errors.first('last_name'),'last_name','Last Name') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group" :class="{'has-error': errors.has('contact_no')}">
                                                            <label>Contact No<span class="error">*</span></label>
                                                            <input type="tel" name="contact_no" class="form-control" :class="addIndicator('contact_no')"
                                                                   v-model="employeeData.contactNo"
                                                                   v-validate="'required|numeric'"
                                                                   v-mask="'###############'"
                                                            />
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
                                                            <input type="text" v-validate="'required|email'" name="email" class="form-control" v-model="employeeData.email" :class="addIndicator('email')" />
                                                            <span v-show="errors.has('email')" class="help-block form-error">{{ this.stringReplace(errors.first('email'),'email','Email Address') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <!--<div class="form-group">
                                                            <label>Applicant Status:</label>
                                                            <div class="current-status">
                                                                <div class="status-level">
                                                                    <div class="status-el">
                                                                        <select2
                                                                                v-if="statusData.options && statusData.options.length && !loading_data"
                                                                                :value="statusData.selected"
                                                                                :options="statusData.options"
                                                                                :style="'width: 100%;height: 36px!important;'"
                                                                                @select="statusData.selected = $event"
                                                                        >
                                                                            <option value="0">&nbsp;&nbsp;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;</option>
                                                                        </select2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>-->

                                                        <div class="form-group">
                                                            <label>Date of Birth<span class="error">*</span></label>
                                                            <div id="birth-fields" :class="addIndicator('birth_date')">
                                                                <flat-pickr
                                                                        v-model="employeeData.dateOfBirth"
                                                                        :config="getConfig(true, false, {allowInput:true, maxDate: getLegalYear(18), onClose: function(selectedDates, dateStr, instance){ controlEnteredDate(instance,employeeData,'dateOfBirth'); }})"
                                                                        placeholder="Select birth date"
                                                                        name="birth_date"
                                                                        v-validate="'required'"
                                                                />
                                                            </div>
                                                            <span v-show="errors.has('birth_date')" class="help-block form-error">{{ this.stringReplace(errors.first('birth_date'),'birth_date','Date of Birth') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group" :class="{'has-error': errors.has('contact_no')}">
                                                            <label>Job Position Applying for: </label><span class="error">*</span>
                                                            <div class="current-position">
                                                                <div class="position-level">
                                                                    <div class="position-el">
                                                                        <select2
                                                                                v-if="positionLevels.length && !loading_data"
                                                                                :value="formData.level"
                                                                                :options="positionLevels"
                                                                                :style="'width: 110px;height: 36px!important;'"
                                                                                @select="formData.level = $event"
                                                                        >
                                                                            <option value="0">&nbsp;&nbsp;---------</option>
                                                                        </select2>
                                                                    </div>
                                                                </div>
                                                                <div class="position" :class="addIndicator('job_position')">
                                                                    <vue-tags-input
                                                                            v-model="formData.position"
                                                                            :tags="formData.positions"
                                                                            :add-only-from-autocomplete="true"
                                                                            :autocomplete-items="filteredPositions"
                                                                            :max-tags=1
                                                                            @tags-changed="newPosition => formData.positions = newPosition"
                                                                            @before-adding-tag="addPosition"
                                                                            :placeholder="formData.positions.length>0?'':'Select Position'"
                                                                            name="job_position"
                                                                            v-validate="'required'"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>CV/Resume File: </label><span class="error">*</span>
                                                            <a href="#" :href="applicant_cv_path+'?'+(new Date().getTime())" target="_blank" v-if="fileUpload.medium==null && applicant_cv_path!=''">Uploaded CV</a>
                                                            <span v-if="fileUpload.medium!=null" class="ks-text file-selected-indicator">New File Selected</span>

                                                            <div class="col-sm-10">
                                                                <label class="btn btn-primary ks-btn-file">
                                                                    <span class="la la-cloud-upload ks-icon"></span>
                                                                    <span class="ks-text">Choose file</span>
                                                                    <input type="file" name="applicantResume" ref="files" id="applicantResume" @change="handleFileUpload($event)">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!------------------------------>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!------- ADDRESS --------->
                <div class="fs-accordion" :class="controlTabs.address">
                    <div class="fs-field">
                        <div class="card panel panel-default ks-information ks-light">
                            <div class="card-header" @click="controlTab('address')">
                                <h4 class="ks-text">Address</h4>
                            </div>
                            <div class="card-block fs-accordion-content">
                                <div class="fs-info-wrapper">
                                    <div class="tab-pane" id="address" role="tabpanel" aria-expanded="false">
                                        <div class="row content-row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <a class="address-wrapper flex link">
                                                        <span class="la la-map-marker this-icon"></span>
                                                        <label class="content-header-text">Current Address<span class="error">*</span></label>
                                                    </a>
                                                    <div>
                                                        <div class="address-wrapper">
                                                            <input v-model="addressData.address.line_1" type="text" name="line_1" placeholder="Address Line 1" class="form-control" v-validate="'required'" :class="addIndicator('line_1')" />
                                                        </div>
                                                        <div class="address-wrapper">
                                                            <input v-model="addressData.address.line_2" type="text" name="line_2" placeholder="Address Line 2" class="form-control" />
                                                        </div>
                                                        <div class="address-wrapper flex">
                                                            <input v-model="addressData.address.city" type="text" name="city" placeholder="City" class="form-control" v-validate="'required'" :class="addIndicator('city')" />
                                                            <input v-model="addressData.address.state_province" type="text" name="state_province" placeholder="State / Province" class="form-control" v-validate="'required'" :class="addIndicator('state_province')" />
                                                        </div>
                                                        <div class="address-wrapper flex">
                                                            <input v-model="addressData.address.postal_zip_code" type="text" name="zip_code" placeholder="Postal / Zip Code" class="form-control" v-validate="'required'" :class="addIndicator('zip_code')" />
                                                            <select2
                                                                    :if="countriesReady && !loading_data"
                                                                    :options="countries"
                                                                    :value="addressData.address.country_id"
                                                                    @select="addressData.address.country_id = $event"
                                                            />
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
                                                        <label class="content-header-text">Permanent Address<span class="error">*</span></label>
                                                    </a>
                                                    <div class="custom-control custom-checkbox">
                                                        <input v-model="addressData.sameAsPresent" type="checkbox" id="is_present" name="is_present" class="custom-control-input" />
                                                        <label class="custom-control-label noselect" for="is_present">Same as the Present Address</label>
                                                    </div>
                                                    <div id="control-permanent-address">
                                                        <div>
                                                            <div class="address-wrapper">
                                                                <input type="text" name="pline_1" placeholder="Address Line 1" class="form-control"
                                                                       v-validate="'required'"
                                                                       v-model="addressData.sameAsPresent ? addressData.address.line_1 : addressData.paddress.line_1"
                                                                       :disabled="isAddressEditable()"
                                                                       :class="addIndicator('pline_1')"
                                                                />
                                                            </div>
                                                            <div class="address-wrapper">
                                                                <input type="text" name="pline_2" placeholder="Address Line 2" class="form-control"
                                                                       v-model="addressData.sameAsPresent ? addressData.address.line_2 : addressData.paddress.line_2"
                                                                       :disabled="isAddressEditable()"
                                                                />
                                                            </div>
                                                            <div class="address-wrapper flex">
                                                                <input type="text" name="pcity" placeholder="City" class="form-control"
                                                                       v-validate="'required'"
                                                                       v-model="addressData.sameAsPresent ? addressData.address.city : addressData.paddress.city"
                                                                       :disabled="isAddressEditable()"
                                                                       :class="addIndicator('pcity')"
                                                                />
                                                                <input type="text" name="pstate_province" placeholder="State / Province" class="form-control"
                                                                       v-validate="'required'"
                                                                       v-model="addressData.sameAsPresent ? addressData.address.state_province : addressData.paddress.state_province"
                                                                       :disabled="isAddressEditable()"
                                                                       :class="addIndicator('pstate_province')"
                                                                />
                                                            </div>
                                                            <div class="address-wrapper flex">
                                                                <input type="text" name="ppostal_zip_code" placeholder="Postal / Zip Code" class="form-control"
                                                                       v-validate="'required'"
                                                                       v-model="addressData.sameAsPresent ? addressData.address.postal_zip_code : addressData.paddress.postal_zip_code"
                                                                       :disabled="isAddressEditable()"
                                                                       :class="addIndicator('ppostal_zip_code')"
                                                                />
                                                                <select2
                                                                        :disabled="isAddressEditable()"
                                                                        :if="countriesReady && !loading_data"
                                                                        :options="countries"
                                                                        :value="addressData.sameAsPresent ? addressData.address.country_id : addressData.paddress.country_id"
                                                                        @select="addressData.sameAsPresent ? addressData.address.country_id : addressData.paddress.country_id = parseInt($event)"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------- SKILLS --------->
                <div class="fs-accordion" :class="controlTabs.skills">
                    <div class="fs-field">
                        <div class="card panel panel-default ks-information ks-light">
                            <div class="card-header" @click="controlTab('skills')">
                                <h4 class="ks-text">Skills</h4>
                            </div>
                            <div class="card-block fs-accordion-content">
                                <div class="fs-info-wrapper">
                                    <div class="tab-pane" id="skills" role="tabpanel" aria-expanded="false">
                                        <div class="row content-row" :style="getSkillsCanScroll(skillsData.skills.length)">
                                            <div class="col-sm-12 padding-bottom">
                                                <h4 class="content-header-text">
                                                    <i class="la la-wrench"></i>
                                                    Skills<span v-if="!skillsData.otherSkills.description" class="error">*</span>
                                                </h4>
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
                                                        @blur="soControlTag(skills,'skillsData','skills', 'skillsSelection', tagOptionData,'skillsFlag',false)"
                                                />

                                                <vue-tags-input
                                                        id="skillsOptions"
                                                        v-model="tagOptionData.skillsField"
                                                        v-show="tagOptionData.skillsFlag"
                                                        :tags="soFilteredSkills(skills,'skillsData','skills',skillsData.skills)"
                                                        :add-only-from-autocomplete="false"
                                                        @select="blur()"
                                                />
                                                <div class="skills-and-proficiencies-wrapper">
                                                    <template v-show="skillsData.skills.length">
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
                                                                    <input v-model="skill.years_of_experience" placeholder="Years of Experience" name="years_of_experience" type="tel" class="form-control" title="Years of Experience" v-mask="'##'" />
                                                                </div>
                                                            </div>
                                                            <div class="flex-sm-column-reverse">
                                                                <div class="form-group" :class="skill.no_of_projects_handled ? '' : 'has-danger'">
                                                                    <input v-model="skill.no_of_projects_handled" placeholder="No. of Projects Handled" name="no_of_projects_handled" type="tel" class="form-control" title="No. of Projects Handled" v-mask="'##'" />
                                                                </div>
                                                            </div>
                                                            <div class="flex-sm-column-reverse">
                                                                <div class="form-group" :class="skill.project_roles ? '' : 'has-danger'">
                                                                    <input v-model="skill.project_roles" placeholder="Project Role" name="project_roles" type="text" class="form-control" title="Project Roles" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                    <span v-show="!skillsData.skills.length">None entered</span>
                                                </div>
                                                <!-- END SKILLS -->
                                            </div>
                                        </div>
                                        <div class="row content-row">
                                            <div class="col-sm-6 padding-bottom">
                                                <div>
                                                    <h4 class="content-header-text"><i class="la la-wrench"></i>Other Skills</h4>
                                                    <textarea v-model="skillsData.otherSkills.description" class="form-control" name="other_skills" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- WORK EXPERIENCE ----->
                <div class="fs-accordion" :class="controlTabs.experience">
                    <div class="fs-field">
                        <div class="card panel panel-default ks-information ks-light">
                            <div class="card-header" @click="controlTab('experience')">
                                <h4 class="ks-text">Work Experience</h4>
                            </div>
                            <div class="card-block fs-accordion-content">
                                <div class="fs-info-wrapper">
                                    <div class="tab-pane" id="experience" role="tabpanel" aria-expanded="false">
                                        <div class="row content-row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Company Name:</label>
                                                            <input type="text" name="company_id" class="form-control" v-model="workExperienceData.form.company_name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Job Title:</label>
                                                            <input type="text" name="job-title_id" class="form-control" v-model="workExperienceData.form.job_title" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Start Date:</label>
                                                            <flat-pickr
                                                                    v-model="workExperienceData.form.start_date"
                                                                    :config="getConfig(true, false, {allowInput: true, onClose: function(selectedDates, dateStr, instance){ controlEnteredDate(instance,workExperienceData.form,'start_date'); }})"
                                                                    placeholder="Select a date"
                                                                    name="start_date"
                                                            />
                                                            <span v-show="!isValidWorkExperiencePeriod(workExperienceData.form) && workExperienceData.form.start_date && workExperienceData.form.end_date" class="help-block form-error">Invalid Date Range</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>End Date:</label>
                                                            <flat-pickr
                                                                    v-model="workExperienceData.form.end_date"
                                                                    :config="getConfig(true, false, {allowInput: true, onClose: function(selectedDates, dateStr, instance){ controlEnteredDate(instance,workExperienceData.form,'end_date'); }})"
                                                                    placeholder="Select a date"
                                                                    name="end_date"
                                                            />
                                                            <span v-show="!isValidWorkExperiencePeriod(workExperienceData.form) && workExperienceData.form.start_date && workExperienceData.form.end_date" class="help-block form-error">
                                                                End date cannot be the same or earlier than the start date.
                                                            </span>
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
                                                    <add-button
                                                            :options="buttons.add_more"
                                                            @action="addWorkExperienceValue"
                                                            :disabled="!hasValueAll(workExperienceData.form, workExperienceData.fields) || !isValidWorkExperiencePeriod(workExperienceData.form)"
                                                    >
                                                        {{ (workExperienceData.index > 0) ? 'Update Record' : 'Add More' }}
                                                    </add-button>
                                                    &nbsp;&nbsp;
                                                    <clear-button
                                                            :options="button"
                                                            @action="clearWorkExperienceValue(workExperienceData.form)"
                                                            :disabled="hasNoValueAll(workExperienceData.form, workExperienceData.fields)"
                                                    >
                                                        Clear
                                                    </clear-button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row content-row" v-if="workExperienceData.registered.length" :style="getWorkExperienceCanScroll(this.workExperienceData.registered.length)">
                                            <table class="table text-light stacktable" v-model="workExperienceData.registered">
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
                                                <tr v-for="(work, index) in workExperienceData.registered">
                                                    <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.company_name }}</label></td>
                                                    <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.job_title }}</label></td>
                                                    <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.start_date }}</label></td>
                                                    <td @click="editWorkExperienceValue(index)" class="weVal"><label>{{ work.end_date }}</label></td>
                                                    <td class="work-experience-actions">
                                                        <a href="#!" @click="editWorkExperienceValue(index)" title="Edit Added Work Experience" class="action-button work-experience-action-button"><i class="la la-file-text-o"></i></a>
                                                        <a href="#!" @click="removeWorkExperienceValue(index)" title="Delete Work Experience" class="action-button work-experience-action-button"><i class="la la-trash"></i></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ----- EDUCATION ----- -->
                <div class="fs-accordion" :class="controlTabs.education">
                    <div class="fs-field">
                        <div class="card panel panel-default ks-information ks-light">
                            <div class="card-header" @click="controlTab('education')">
                                <h4 class="ks-text">Education</h4>
                            </div>
                            <div class="card-block fs-accordion-content">
                                <div class="fs-info-wrapper">
                                    <div class="tab-pane" id="education" role="tabpanel" aria-expanded="false">
                                        <div class="row content-row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Course/Degree:<span v-if="controlEducationFlag" class="error">*</span> </label>
                                                            <input type="text" name="course_degree" class="form-control" v-model="educationData.form.course_degree" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>School/University:<span v-if="controlEducationFlag" class="error">*</span> </label>
                                                            <input type="text" name="school_university" class="form-control" v-model="educationData.form.school_university" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Educational Attainment:<span v-if="controlEducationFlag" class="error">*</span> </label>
                                                            <select2
                                                                    v-if="attainments.length && educationData.attainmentOptions.length && !loading_data"
                                                                    :options="educationData.attainmentOptions"
                                                                    :value="educationData.form.educational_attainment_id"
                                                                    @select="educationData.form.educational_attainment_id = $event"
                                                            >
                                                            </select2>
                                                        </div>
                                                    </div>
                                                     <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Year Completed:<span v-if="controlEducationFlag" class="error">*</span> </label>
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <input type="number" class="form-control" name="year_completed" id="year_completed" min="1900" placeholder="yyyy"
                                                                           :disabled="educationData.form.is_present === 1 || educationData.form.is_present === true"
                                                                           v-model="educationData.form.year_completed"
                                                                           v-mask="'####'"
                                                                           v-validate="controlVeeValidateYearCompleted"
                                                                           maxlength="4"
                                                                    >
                                                                    <span v-show="errors.has('year_completed')" class="help-block form-error">Year Completed input format of YYYY with allowed range from 1970 to present.</span>
                                                                </div>
                                                                <div class="col-sm-7">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="education_is_present" id="education_is_present"
                                                                               v-model="educationData.form.is_present"
                                                                               @click="controlYearCompleted"
                                                                               :checked="educationData.form.is_present === 1"
                                                                        >
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
                                                            :disabled="!isEducationFormComplete"
                                                    >
                                                        {{ educationData.form.id ? 'Update Record' : 'Add More' }}
                                                    </add-button>
                                                    &nbsp;&nbsp;
                                                    <clear-button
                                                            :options="button"
                                                            @action="clearEducationFields(educationData.form)"
                                                            :disabled="hasNoValueAll(educationData.form, educationData.fields) && hasNoValueAll(educationData.form, ['year_completed', 'is_present'])"
                                                    >
                                                        Clear
                                                    </clear-button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row content-row" v-if="educationData.registered.length" :style="getEducationCanScroll(educationData.registered.length)">
                                            <table class="table text-light stacktable" v-model="educationData.registered">
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
                                                <tr v-for="(education, index) in educationData.registered">
                                                    <td @click="editEducationValue(index)" class="weVal"><label>{{ getEducationalAttainmentText(educationData.attainmentOptions,education.educational_attainment_id) }}</label></td>
                                                    <td @click="editEducationValue(index)" class="weVal"><label>{{ education.course_degree }}</label></td>
                                                    <td @click="editEducationValue(index)" class="weVal"><label>{{ education.school_university }}</label></td>
                                                    <td @click="editEducationValue(index)" class="weVal"><label>{{ education.is_present ? 'Ongoing' : education.year_completed }}</label></td>
                                                    <td class="education-actions">
                                                        <a href="#!" @click="editEducationValue(index)" title="Edit this record" class="action-button"><i class="la la-file-text-o"></i></a>
                                                        <a href="#!" @click="removeEducationValue(index)" title="Delete this record" class="action-button"><i class="la la-trash"></i></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- --- OTHER DETAILS --- -->
                <!-- <div class="fs-accordion" :class="controlTabs.others">
                    <div class="fs-field">
                        <div class="card panel panel-default ks-information ks-light">
                            <div class="card-header" @click="controlTab('others')">
                                <h4 class="ks-text">Other Details</h4>
                            </div>
                            <div class="card-block fs-accordion-content">
                                <div class="fs-info-wrapper">
                                    <div class="tab-pane" id="otherDetails" role="tabpanel" aria-expanded="false">
                                        <div class="row content-row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Position of Interest: </label>
                                                            <input type="text" name="job_position_applied" class="form-control" v-model="otherDetailsData.job_position_applied" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Availability to Start:</label>
                                                            <flat-pickr
                                                                    v-model="otherDetailsData.start_date_availability"
                                                                    :config="getConfig(true, false, {allowInput:true})"
                                                                    placeholder="Select a date"
                                                                    name="date_start"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Preferred Shift</label>
                                                            <select2
                                                                    v-if="shiftsData.options.length && !loading_data"
                                                                    :options="shiftsData.options"
                                                                    :value="shiftsData.value"
                                                                    @select="shiftsData.value = $event"
                                                            >
                                                                <option value="CUSTOM_TIME">Custom Time</option>
                                                            </select2>
                                                            <div class="custom-shift" v-show="shiftsData.value == 'CUSTOM_TIME'">
                                                                <div class="time-selection col-sm-6">
                                                                    <div class="form-group" :class="shiftsData.start_time ? '' : 'has-danger'">
                                                                        <label>Start Time</label>
                                                                        <flat-pickr
                                                                                v-model="shiftsData.start_time"
                                                                                :config="getConfig(false)"
                                                                                placeholder="Select a time"
                                                                                name="start_time"
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div class="time-selection col-sm-6">
                                                                    <div class="form-group" :class="shiftsData.start_time ? '' : 'has-danger'">
                                                                        <label>End Time</label>
                                                                        <flat-pickr
                                                                                v-model="shiftsData.end_time"
                                                                                :config="getConfig(false)"
                                                                                placeholder="Select a time"
                                                                                name="end_time"
                                                                        />
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
                                                            <input :placeholder="'Enter current salary here...'" v-mask="'######'" type="text" name="current_salary" class="form-control" v-model="otherDetailsData.current_salary" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Expected Salary</label>
                                                            <input :placeholder="'Enter expected salary here...'" v-mask="'######'" type="text" name="expected_salary" class="form-control" v-model="otherDetailsData.expected_salary" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row abroad">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input v-model="otherDetailsData.plan_work_abroad" type="checkbox" id="plan_work_abroad" name="plan_work_abroad" class="custom-control-input" />
                                                                <label class="custom-control-label noselect" for="plan_work_abroad">Plan to work abroad?</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" v-show="otherDetailsData.plan_work_abroad" :class="otherDetailsData.plan_work_abroad_when ? '' : 'has-danger'">
                                                            <label>When do you plan to work Abroad?</label>
                                                            <input type="text" name="plan_work_abroad_when" class="form-control" v-model="otherDetailsData.plan_work_abroad_when" />
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
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group referrer">
                                                            <label>Referred By: </label>
                                                            <vue-tags-input
                                                                    :max-tags=1
                                                                    v-model="referrer"
                                                                    v-if="employeeNames && employeeNames.length"
                                                                    :tags="otherDetailsData.referrerArray"
                                                                    :autocomplete-items="filteredReferrer"
                                                                    :add-only-from-autocomplete="true"
                                                                    @tags-changed="newInput => otherDetailsData.referrerArray = newInput"
                                                                    :placeholder="otherDetailsData.referrerArray && otherDetailsData.referrerArray > 0 ? '' : 'Enter Referrer'"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Interviewer: </label>
                                                            <vue-tags-input
                                                                    v-model="interviewers"
                                                                    v-if="employeeNames && employeeNames.length"
                                                                    :tags="otherDetailsData.interviewersArray"
                                                                    :autocomplete-items="filteredInterviewers"
                                                                    :add-only-from-autocomplete="true"
                                                                    @tags-changed="newInput => otherDetailsData.interviewersArray = newInput"
                                                                    placeholder="Enter Interviewer"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <!-- --- hear about us --- -->
                <div class="fs-accordion" :class="controlTabs.learnaboutus">
                    <div class="fs-field">
                        <div class="card panel panel-default ks-information ks-light">
                            <div class="card-header" @click="controlTab('learnaboutus')">
                                <h4 class="ks-text">About us</h4>
                            </div>
                            <div class="card-block fs-accordion-content">
                                <div class="fs-info-wrapper">
                                    <div class="tab-pane active" id="basic" role="tabpanel" aria-expanded="false">
                                        <div class="row content-row">
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>How did you learn about FULL SCALE? </label><span class="error">*</span>
                                                            <select2
                                                                    :options="referralTypesData.referralTypesArray"
                                                                    :value="referralTypesData.form.referral_type_id"
                                                                    @select="selectSource"
                                                            >
                                                            </select2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6" v-show="displayReferralTypesSource">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>{{ referralTypesSourceLabel }}: </label><span class="error">*</span>
                                                            <vue-tags-input
                                                                    :max-tags=1
                                                                    v-model="referrer"
                                                                    v-show="referralInput"
                                                                    v-if="employeeNames && employeeNames.length"
                                                                    :tags="referralTypesData.form.referral_array"
                                                                    :autocomplete-items="filteredReferrer"
                                                                    :add-only-from-autocomplete="true"
                                                                    @tags-changed="(newInput) => {referralTypesData.form.referral_array = newInput}"
                                                                    :placeholder="referralTypesData.form.referral_array && referralTypesData.form.referral_array.length > 0 ? '' : 'Enter Referrer'"
                                                            />
                                                            <input type="text" v-show="!referralInput" name="referral_details" class="form-control" v-model="referralTypesData.form.referral_details" autocomplete="off" v-validate="'required'" :class="addIndicator('referral_details')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------- END ACCORDION ------------------>

            <div class="submit-button-container" v-if="!loading_data">
                <div class="custom-control custom-checkbox applicant-agreement">
                    <input v-model="applicant_agreed" type="checkbox" id="applicant_agreed" name="applicant_agreed" class="custom-control-input" />
                    <label class="custom-control-label noselect" for="applicant_agreed">I hereby acknowledge that all information entered above are true and correct.</label>
                </div>
                <save-button :loading="loading" :options="button" @action="save" :disabled="!valid || errors.count() > 0">{{ modal_save }}</save-button>
                <span id="uploading-notification">Please wait while the page is still uploading information.</span>
            </div>
        </div>
    </div>
</template>

<style type="text/css">
    body{
        padding-top: 0px!important;
    }
    div.modal-backdrop > div.modal{
        overflow: visible!important;
    }
    .noselect {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .file-selected-indicator{ color: #1e8eff; }
    .col-sm-10{ padding-left:0px!important; }
    div.position ul.tags > li.tag.valid + li > input{ display:none; }
    div.referrer ul.tags > li.tag.valid + li > input{ display:none; }
    span.selection > .select2-selection{ height: 36px!important; }
    .position-level {
        display: flex;
        flex-direction: column;
        width: 115px;
    }
    .position-el {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .current-position {
        display: flex;
        flex-direction: row;
    }
    .position { width: 252px; }

    div#birth-fields{
        background-color: #ffffff;
    }
    div#birth-fields input.form-control{
        background-color: transparent !important;
    }
</style>
<style lang="scss" scoped>
    .input-required{
        background-color: #fdeaea!important;
        input{
            background-color: transparent !important;
            .flatpickr-input{
                background-color: transparent !important;
            }
        }
    }
    span.error{
        color: #ff3600 !important;
        font-size: 18px !important;
        padding-left: 3px !important;
        position: absolute;
    }
    .form-error{
        color: red;
    }
    .refresh-page-container{
        display: none;
        padding-top: 20px;
        margin-left: 50%;
        left: -366px;
        position: relative;
        width: 100%;
        span{
            font-size: 16px;
            font-weight: 400;
            color: #555;
        }
    }
    .applicant-agreement{
        padding-left: 40px;
    }
    .submit-button-container{
        width: 1000px;
        position: relative;
        padding-top: 20px!important;
        padding-bottom: 20px!important;
        padding-right: 15px;
        margin-bottom: 50px;
        height: 200px;
        button{
            float: right;
            margin-top: 35px!important;
        }
        span{
            left: auto;
            right: 12px !important;
            position: absolute;
            margin-top: 85px;
            font-size: 15px;
            font-weight: 600;
            display:none;
        }
    }
    .card-header{
        h4{
            position: relative;
            margin-top: 7px!important;
        }
    }
    .form-title{
        margin-top: 40px!important;
        margin-bottom: 25px!important;
        span{
            font-size: 26pt;
            font-weight: 700;
            color: #aaa;
            margin-left: 50%!important;
            left: -151px!important;
            position: relative;
        }
    }
    .main-form{
        width: 1000px!important;
        position: relative;
        margin-left: 50%!important;
        left: -500px!important;
        top: 60px;
    }
    .form-header{
        height: 200px!important;
        max-width: 100%!important;
        width: 100%!important;
    }
    div.header-form{
        height: 60px!important;
        max-width: 100%!important;
        width: 100%!important;
        position: fixed!important;
        top: 0px;
        left: 0px;
        z-index: 1;
        box-shadow: 0 4px 4px -1px #999999;
        -moz-box-shadow: 0 4px 4px -1px #999999;
        -webkit-box-shadow: 0 4px 4px -1px #999999;
        div, .comp-logo-container{
            width: 1000px;
            position: relative;
            margin: 0 auto;
            span{
                width: 223px!important;
                position: relative;
                top: 12px!important;
                left: -7px!important;
                z-index: 1;
                color: #FFFFFF;

                font-size: 18px;
                text-transform: uppercase;
                font-weight: 700;
                line-height: 29px;
            }
            .comp-logo {
                width: 108px;
            }
        }
    }
    .main-page{
        top: 0px;
        left: 0px!important;
        position: relative;
    }
    .loading-indicator-container{
        position: absolute!important;
        left: 320px;
        top: 0px!important;
    }
    .loading-indicator{
        position: relative;
    }
    .abroad{
        margin-top: 5px!important;
    }
    .custom-shift {
        display: flex;
        flex-direction: row;
        margin-top: 10px;
    }
    .custom-shift .time-selection:first-child {
        margin-right: 10px;
    }
    tr > td.weVal > label{
        position: relative;
        top: 5px;
        cursor: pointer;
        color: #585858;
    }
    .education-actions{
        font-size: 20px!important;
        padding-left: 23px!important;
        :hover{
            color: #ab2424;
        }
    }
    .work-experience-actions{
        font-size: 20px!important;
        padding-left: 23px!important;
        :hover{
            color: #ab2424;
        }
    }
    .work-experience-buttons-placeholder{
        margin-left: 0px!important;
    }
    .stacktable{
        margin-left: 15px!important;
        margin-right: 15px!important;
        margin-top: 15px!important;
        thead.thead-default tr th{
            background-color: #50ae55!important;
            color: #ffffff!important;
        }
    }
    .proficiency-width{
        max-width: 150px!important;
    }
    .flex-sm-column-reverse{
        margin-left: 5px!important;
        margin-right: 5px!important;
    }
    .skill-item{
        top: 7px!important;
        position: relative;
    }
    .custom-control-label.noselect{
        margin-bottom: 3px!important;
    }
    div > label.custom-control-label::after{
        left: -23px !important;
    }
    .nav-link.active{
        font-weight: 600!important;
    }
    .skills-and-proficiencies > .col-lg-6 > span{
        top: 5px!important;
        position: relative;
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
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .address-wrapper {
        margin: 6px 0;
        &.flex {
            display: flex;
            flex-direction: row;
            font-size: 12px;
            input:first-child {
                margin-right: 5px;
            }
            &.link {
                cursor: pointer;
            }
        }
    }
    .this-icon{
        font-size: 20px!important;
    }
    .skills-box{
        border: 1px solid #eeeeee;
    }
    .content-row{
        width: auto;
        /*padding-right: 15px;
        padding-top: 15px!important;*/
        margin-bottom: 10px!important;
    }
    .content-placeholder{
        overflow-y: scroll;
        overflow-x: hidden;
        height: 570px!important;
    }
    .content-header-text{
        font-size: 10pt;
        font-weight: 400;
    }
    .content-header{
        padding-top: 15px!important;
    }
    .bottom-border{
        border-bottom: 1px solid #eeeeee;
    }
    .margin-top{
        margin-top: 15px;
    }
    .margin-bottom-zero{
        margin-bottom: 0px!important;
    }
    .padding-bottom{
        padding-bottom: 25px;
    }
    .custom-control.custom-checkbox {
        margin-top: .7em;
    }
</style>

<script type="text/javascript">
    //Components
    import Select2 from '@components/select2.vue';
    import GenerateButton from '@components/form/button.vue';
    import SaveButton from '@components/form/button.vue';
    import ClearButton from '@components/form/button.vue';
    import AddButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import TouchSpin from '@components/touchspin.vue';
    import VueTagsInput from '@johmun/vue-tags-input';
    import FlatPickr from 'vue-flatpickr-component';
    import OAuth from '@common/oauth/OAuth';
    import 'flatpickr/dist/flatpickr.css';
    import AlertMixin from '@common/mixin/AlertMixin';
    import { mask } from 'vue-the-mask';

    //Mixins
    import EmployeeMixin from '@common/mixin/EmployeeMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import DateMixin from '@common/mixin/DateMixin';
    import ApplicantMixin from '@common/mixin/ApplicantMixin';
    import SkillsOptionMixin from '@common/mixin/SkillsOptionMixin';
    import DatePickerMixin from '@common/mixin/DatePicker';
    import LoaderMixin from '@common/mixin/LoaderMixin';

    //Models
    import { Employee } from '@common/model/Employee';
    import { EmployeeJobPosition } from '@common/model/EmployeeJobPosition';
    import { EmployeeStatus } from '@common/model/EmployeeStatus';
    import { JobPosition } from '@common/model/JobPosition';
    import { Asset } from '@common/model/Asset';
    import { User } from '@common/model/User';
    import { mapGetters, mapActions } from 'vuex';
    import _ from 'lodash';
    import jQuery from 'jquery';

    export default {
        directives: {
            mask
        },
        data() {
            return {
                controlTabs: {
                    general: 'is-primary',
                    address: 'is-primary',
                    skills: 'is-primary',
                    experience: 'is-primary',
                    education: 'is-primary',
                    others: 'is-primary',
                    learnaboutus: 'is-primary',

                    opened: 'is-primary',
                    closed: 'is-closed is-dark'
                },
                applicant: '',
                applicant_agreed: '',
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
                loading_data: true,
                loading_value: 0,
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
                    value: 1,
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
                    validate_fields: ['country_id','line_1','city','state_province','postal_zip_code'],
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
                    dateOfBirth: '',
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
                    selected: 3, //Default is 'New', but since 'New' is not yet in DB, we use 'For Exam' instead
                    options: [],
                    values: []
                },
                workExperienceData: {
                    index: '',
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
                year_completed: '',
                otherDetailsData: {
                    id: '',
                    employee_id: '',
                    job_position_applied: '',
                    referred_by_employee_id: '',
                    start_date_availability: '',
                    current_salary: '',
                    expected_salary: '',
                    plan_work_abroad: '',
                    plan_work_abroad_when: '',
                    recommendations: '',
                    interviewer: '',
                    notes: '',

                    referrerArray: [],
                    interviewersArray: []
                },
                referralTypesData: {
                    form: {
                        id: '',
                        employee_id: '',
                        referral_type_id: '',
                        referral_details: '',
                        referral_array: [],
                        referred_by_employee_id: ''
                    },
                    referralTypesArray: []
                },
                displayReferralTypesSource: false,
                referral: 1,
                socialMedia: 2,
                jobPortal: 3,
                referralTypesSourceLabel: 'Source',
                referralInput: false,
                modal_title: 'Applicant Form',
                modal_save: 'Submit Form',
                loading: false,
                manualInput : false,
                validation: [
                    {path: 'firstName', name: 'first_name', rule: 'required', msg: {required: 'First Name is required'}},
                    {path: 'lastName', name: 'last_name', rule: 'required', msg: {required: 'Last Name is required'}},
                    {path: 'contactNo', name: 'contact_no', rule: 'required', msg: {required: 'Contact No is required'}},
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
                invalidFileType: false,
                fileTypes:['PDF', 'DOCX', 'DOC'],
                email_regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                number_regex: /\d$/,
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
                organizationShortNameAllCaps: 'appSettings/getShortNameTextAllCaps',
                fullScaleLogo: 'appSettings/getFullScaleLogo',
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
                if(!this.applicant_agreed) return false;

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
                // General
                if(this.formData.positions.length <= 0){ valid = false; }
                if(this.statusData.selected <= 0){ valid = false; }
                if(!this.checkSelectedFile()){ valid = false; }
                if(this.applicant_cv_path == '' && this.fileUpload.medium == null){ valid = false; }
                if(this.employeeData.email == '' || !this.email_regex.test(this.employeeData.email)){ valid = false; }
                if(!this.number_regex.test(this.employeeData.contactNo) || isNaN(parseInt(this.employeeData.contactNo))){ valid = false; }
                if(!this.employeeData.dateOfBirth){ valid = false; }

                // Address
                if(!this.hasValueAll(this.addressData.address,this.addressData.validate_fields)){ valid = false; }
                if(!this.addressData.sameAsPresent && !this.hasValueAll(this.addressData.paddress,this.addressData.validate_fields)){ valid = false; }

                // Skills
                if(!this.skillsData.skills.length && !this.skillsData.otherSkills.description){ valid = false; }
                if(!this.validateSkills(this.skillsData.skills)){ valid = false; }

                // Work Experience
                if(!this.hasNoValueAll(this.workExperienceData.form)){
                    if(this.hasIncompleteValues(this.workExperienceData.form,this.workExperienceData.fields)){ valid = false; }
                    if(!this.workExperienceData.registered.length && !this.hasValueAll(this.workExperienceData.form,this.workExperienceData.fields)){ valid = false; }
                    if((this.workExperienceData.form.start_date.length && this.workExperienceData.form.end_date.length) && !this.isValidWorkExperiencePeriod(this.workExperienceData.form)){ valid = false; }
                }

                // Education
                /** If there are changes here under education, please update isEducationFormComplete function as necessary **/
                if(this.hasIncompleteValues(this.educationData.form,this.educationData.fields)){ valid = false; }
                if(this.hasNoValueAll(this.educationData.form,this.educationData.fields) && !this.hasNoValueAll(this.educationData.form,['year_completed', 'is_present'])){ valid = false; }
                let yearRef = /\d{4}/;
                if(this.educationData.form.year_completed && !yearRef.test(this.educationData.form.year_completed)){ valid = false; }

                // Learn about FS
                if(this.referralTypesData.form.referral_type_id == ''){ valid = false; }
                if([this.socialMedia,this.jobPortal].includes(this.referralTypesData.form.referral_type_id) && this.referralTypesData.form.referral_details == ''){ valid = false; }
                //if(this.referralTypesData.form.referral_type_id == this.referral && !this.referralTypesData.form.referral_array.length){ valid = false; }
                if(this.referralTypesData.form.referral_type_id == this.referral && this.referralTypesData.form.referral_details == ''){ valid = false; }
                
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
            controlVeeValidateYearCompleted: function(){
                if(!this.educationData.form.is_present && this.educationData.form.year_completed.length > 0){
                    return 'required|numeric|date_format:YYYY|date_between:1969,' + ((new Date().getFullYear()) + 1) +'';
                }else{ return ''; }
            },
            controlEducationFlag(){
                let flag = false;
                if(this.hasIncompleteValues(this.educationData.form,this.educationData.fields)){ flag = true; }
                if(this.hasNoValueAll(this.educationData.form,this.educationData.fields) && !this.hasNoValueAll(this.educationData.form,['year_completed', 'is_present'])){ flag = true; }
                let yearRef = /\d{4}/;
                if(this.educationData.form.year_completed && !yearRef.test(this.educationData.form.year_completed)){ flag = true; }
                if(!this.educationData.registered.length){ flag = true; }
                return flag;
            }
        },
        mounted() {
            this.hideLoader();
        },
        async created () {
            let vm = this;
            setTimeout(function(){ if(vm.loading_data){ $(".main-form .refresh-page-container").show(); }},20000);

            await this.generateToken(true);
            if(this.applicant){
                this.modal_title = "Update Applicant";
                this.modal_save = "Update";
            }
            this.progress(5);
            await this.getSkills({query: {take: 9999}, extra: {proficiency: 5}});
            await this.getYears({min: 2000, max: new Date().getFullYear()});
            await this.getActiveEducationalAttainments({query: {orderBy: 'level|asc'},extra: {}});
            await this.getReferralTypes({query: {take: 9999}});
            this.progress(30);

            await this.loadLevelAndPositions();
            await this.getStatuses({query: {take: 9999}});
            this.statuses.forEach((obj)=>{
                if(obj.name.toUpperCase() !== "HIRED" || (obj.name.toUpperCase() === "HIRED" && this.applicant)){
                    if(this.exclude_stats.indexOf(obj.description.toUpperCase())<0){
                        this.statusData.options.push({id:obj.id,text:obj.description});
                    }
                    if(obj.name.toUpperCase() === "HIRED"){
                        this.applicant_hired_id = obj.id;
                    }
                    if(obj.name.toUpperCase() === "NEW"){
                        this.statusData.selected = obj.id;
                    }
                }
            });
            this.progress(55);

            await this.getCountries({query: {take: 9999}});
            await this.loadEducationalAttainmentOptions();
            await this.loadReferralTypesOptions();
            this.addressData.address.country_id = this.countryDefault[0];
            this.addressData.paddress.country_id = this.countryDefault[0];

            await this.getEmployees({query: {take: 999999, include: 'positions'}});
            this.progress(85);

            await this.loadShifts();
            await this.employees.forEach((obj) => {
                this.employeeNames.push({ id: obj.id, text: (obj.first_name + ' ' + obj.middle_name + ' ' + obj.last_name) });
            });
            this.progress(100);

            this.loading_data = false;
            await this.generateToken(false);

            /** CTRL+ALT+G : Generates dummy values of this form except the CV file upload */
            $("input[name='first_name']").keydown(function(e){
                if(e.ctrlKey && e.altKey && e.keyCode == 71){
                    vm.generateDummyValue();
                }
            });
        },
        methods : {
            controlTab(tab, toggle = true, opened = true){
                if(toggle){
                    this.controlTabs[tab] = this.controlTabs[tab] === this.controlTabs.opened ? this.controlTabs.closed : this.controlTabs.opened;
                } else {
                    this.controlTabs[tab] = opened ? this.controlTabs.opened : this.controlTabs.closed;
                }
            },
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
                setAuth : 'auth/setAuthData',
                getReferralTypes: 'referralTypes/getReferralTypes'
            }),
            async save() {
                await this.generateToken(true);
                this.loading = true;
                const data = {
                    first_name: this.employeeData.firstName,
                    last_name: this.employeeData.lastName,
                    middle_name: this.employeeData.middleName,
                    contact_no: this.employeeData.contactNo,
                    date_of_birth: this.employeeData.dateOfBirth,
                    email: this.employeeData.email
                }
                if(this.applicant && this.applicant_hired_id == this.statusData.selected){
                    let new_employee_no = '';
                    await this.getAvailableEmployeeNo().then((fs)=> {
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
                            //this.$set(data, 'unique_str', new_employee_no.replace('-','').toLowerCase() + Math.random().toString(36).substring(2, 9));
                        }
                    });

                    this.$set(data, 'unique_str', new_employee_no.replace('-','').toLowerCase() + Math.random().toString(36).substring(2, 9));
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
                }else{
                    await this.saveApplicant(data);
                }
            },
            _manualInput() {
                this.manualInput = true;
            },

            saveApplicant(data){
                const employee = this.applicant ? new Employee({id:this.applicant}) : new Employee();
                let returnedEmployeeId = this.applicant ? this.applicant : '';

                if(this.fileUpload.medium != null && this.checkSelectedFile()){
                    employee.save(data).then((res) => {
                        returnedEmployeeId = res.data.id;
                        this.applicant = returnedEmployeeId;

                        this.submitFile(returnedEmployeeId).then(() => {
                            this.savePosition(returnedEmployeeId).then(()=>{
                                let promises = [];
                                if(this.statusData.selected != this.applicant_status_id){
                                    promises.push(this.saveApplicantStatus(returnedEmployeeId));
                                }
                                promises.push(this.saveApplicantAddresses(returnedEmployeeId));
                                promises.push(this.saveSkills(returnedEmployeeId));
                                promises.push(this.saveWorkExperiences(returnedEmployeeId));
                                promises.push(this.saveApplicantEducation(returnedEmployeeId));
                                promises.push(this.saveApplicantReferral(returnedEmployeeId));
                                Promise.all(promises).then(() => {
                                    this.generateToken(false);
                                    this.closeDialog();
                                });
                            });
                        });
                    });
                } else {
                    const title = 'Unable to proceed';
                    const msg = 'No resume have been selected. Please select your resume and try again';
                    this.confirmDialog(title, msg, 'Close', '', 'sm');
                }
            },
            async loadApplicantData() {
                this.employeeData.firstName = this.employee.first_name;
                this.employeeData.lastName = this.employee.last_name;
                this.employeeData.middleName = this.employee.middle_name;
                this.employeeData.contactNo = this.employee.contact_no;
                this.employeeData.dateOfBirth = this.employee.date_of_birth;
                this.employeeData.email = this.employee.email;

                this.fileUpload.assetable_id = this.applicant;

                let pid = 0;
                let path = '';

                if(this.employee.photo){
                    this.employee.photo.data.forEach((obj) => {
                        if (obj.id > pid) {
                            pid = obj.id;
                            path = obj.path;
                        }
                    });
                }

                this.applicant_cv_id = pid;
                this.fileUpload.old_id = pid;
                this.applicant_cv_path = path;
                this.fileUpload.old_cv = path;

                let stat = "";

                if(this.employee.employeeStatuses){
                    this.employee.employeeStatuses.data.forEach((statobj) => {
                        stat = statobj.status_id;
                    });
                }

                //this.statusData.selected = stat; // Value set in created method, for public applicant form only.
                this.applicant_status_id = stat;

                let levelId = "";
                let positionId = "";
                let positionText = "";

                if(this.employee.positions){
                    this.employee.positions.data.forEach((posobj) => {
                        this.applicant_position_id = posobj.id;
                        levelId = posobj.level_id;
                        positionId = posobj.position_id;
                        positionText = posobj.job_title;
                    });
                }

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
                let employeeJobPosition = this.applicant_position_id != '' ? new EmployeeJobPosition({id:this.applicant_position_id}) : new EmployeeJobPosition();
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
                    status_id: this.statusData.selected, // - Value set in created method, for public applicant form only.
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
                this.updateJobPositionIndicator(obj);
                obj.addTag();
            },
            updateJobPositionIndicator(obj = null){
                let $ = jQuery;
                if (!obj) {

                }else if(!obj.tag.id){
                    this.formData.position = '';
                    $("div.position div.vue-tags-input div.input").css("border-color", "red");
                    $("div.position div.vue-tags-input div.input").attr("title", "Type and select the available position in the dropdown.");
                } else {
                    $("div.position div.vue-tags-input div.input").css("border-color", "");
                    $("div.position div.vue-tags-input div.input").removeAttr("title");
                }
            },

            handleFileUpload(e) {
                let uploadedFiles = e.target.files || e.dataTransfer.files;
                if (!uploadedFiles.length){
                    this.fileUpload.medium=null;
                    return;
                } else if (!this.isValidCV(uploadedFiles[0].name.toUpperCase(), this.fileTypes)) {
                    // Prompt user that the file is invalid
                    // We don't touch the medium, this is to protect what was already set during edit
                    const title = 'Please select a resume file in PDF/MSWord format. (With .pdf / .docx / .doc file extension)';
                    const msg = `Filename: ${uploadedFiles[0].name}`;
                    this.confirmDialog(title, msg, 'Close', '', 'sm');
                    this.fileUpload.medium=null;
                    e.target.value = '';
                    return;
                } else if (uploadedFiles[0].size > 10485760) { // Public applicant form 10MB limit
                    const title = 'File limit exceeded. Please select a resume file not more than 10MB in file size.';
                    const msg = `Filename: ${uploadedFiles[0].name}`;
                    this.confirmDialog(title, msg, 'Close', '', 'sm');
                    this.fileUpload.medium=null;
                    e.target.value = '';
                    return;
                }

                this.fileUpload.name = uploadedFiles[0].name;
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.fileUpload.medium = e.target.result;
                };
                reader.readAsDataURL(uploadedFiles[0]);
            },
            checkSelectedFile(){
                if(this.fileUpload.name!=''){
                    let extension = this.fileUpload.name.split('.');
                    if(this.fileTypes.indexOf(extension[1].toUpperCase())>=0) {
                        return true;
                    }
                }
                return false;
            },
            submitFile(returnedEmployeeId){
                return new Promise((resolve) => {
                    this.fileUpload.assetable_id = returnedEmployeeId;
                    this.loading = true;
                    const asset = new Asset();

                    setTimeout(function(){
                        let $ = jQuery;
                        $("span#uploading-notification").show(200);
                    },15000);

                    try{
                        asset.save(this.fileUpload).then(() => {
                            resolve(true);
                        });
                    }catch(e){
                        const title = 'Error!';
                        const msg = 'An unexpected error has occurred while uploading your resume, please try again.';
                        this.confirmDialog(title, msg, 'Close', '', 'sm');
                        resolve(false);
                    }
                });
            },

            saveApplicantAddresses(employee_id){
                if(this.hasValue(this.addressData.address, ['line_1', 'line_2', 'city', 'state_province', 'postal_zip_code'])){
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
                if(this.hasValue(this.addressData.paddress, ['line_1', 'line_2', 'city', 'state_province', 'postal_zip_code'])){
                    if(!this.addressData.sameAsPresent){
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
                        if(this.addressData.paddress.id){
                            this.deleteAddress(this.addressData.paddress.id);
                        }
                    }
                }
            },
            async loadAddresses(){

                if(this.employee.address && this.employee.address.data && this.employee.address.data.length > 0){
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
                        if(obj.is_present){
                            this.addressData.address = data;
                            this.addressData.sameAsPresent = obj.is_permanent;
                        }else if(!obj.is_present && obj.is_permanent){
                            this.addressData.paddress = data;
                        }
                    });
                }
            },
            isAddressEditable(){
                return this.addressData.sameAsPresent === 0 ? false : this.addressData.sameAsPresent;
            },

            async saveSkills(employee_id){
                let promises = [];
                let employeeSkillId = '';

                await _.each(this.skillsData.skills, (skill, key) => {
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

                /**
                 *  This is commented as we are not going to compare records with existing employee.
                 *  The records we are expecting here are coming from new applicant, meaning fresh
                 *  addition to the record and no comparison has to be done here.
                 */
                /*if(this.employee.skills && this.employee.skills.data){
                    let tempSkill = [];
                    await _.each(this.employee.skills.data, (skill, key) => {
                        tempSkill = this.skillsData.skills.filter((es) => es.id == skill.skill_id);
                        if(!tempSkill.length) {
                            promises.push(this.deleteApplicantSkill(skill.id));
                        }
                    });
                }*/

                let self = this;
                await Promise.all(promises).then((res) => {
                    if( self.skillsData.otherSkills.description ){
                        self.skillsData.otherSkills.employee_id = employee_id;
                        self.saveOtherSkills(self.skillsData.otherSkills);
                    }
                });
            },
            async loadSkills(){
                if(this.employee.skills && this.employee.skills.data){
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
                if(this.employee.otherSkills && this.employee.otherSkills.data && this.employee.otherSkills.data.length > 0){
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

            saveApplicantOtherDetails(employee_id){
                this.otherDetailsData.employee_id = employee_id;

                if(this.otherDetailsData.referrerArray && this.otherDetailsData.referrerArray.length){
                    this.otherDetailsData.referred_by_employee_id = this.otherDetailsData.referrerArray[0].id;
                }
                if(!this.otherDetailsData.plan_work_abroad){
                    this.otherDetailsData.plan_work_abroad_when = '';
                }
                if(this.otherDetailsData.interviewersArray && this.otherDetailsData.interviewersArray.length){
                    let interviewers = [];
                    this.otherDetailsData.interviewersArray.forEach((obj) => {
                        interviewers.push(obj.text);
                    });
                    this.otherDetailsData.interviewer = interviewers.join(',');
                }

                this.saveOtherDetail({
                    id: this.otherDetailsData.id,
                    employee_id: this.otherDetailsData.employee_id,
                    job_position_applied: this.otherDetailsData.job_position_applied,
                    referred_by_employee_id: this.otherDetailsData.referred_by_employee_id,
                    start_date_availability: this.otherDetailsData.start_date_availability,
                    current_salary: this.otherDetailsData.current_salary,
                    expected_salary: this.otherDetailsData.expected_salary,
                    plan_work_abroad: this.otherDetailsData.plan_work_abroad ? 1 : 0,
                    plan_work_abroad_when: this.otherDetailsData.plan_work_abroad_when,
                    recommendations: this.otherDetailsData.recommendations,
                    interviewer: this.otherDetailsData.interviewer,
                    notes: this.otherDetailsData.notes
                }).then((res) => {
                    //this.saveApplicantShift(employee_id); // - hide from form
                });
            },
            async loadApplicantOtherDetails(){
                if(this.employee.otherDetails && this.employee.otherDetails.data){

                    let referrerArray = [];
                    let interviewersArray = [];

                    await this.employee.otherDetails.data.forEach((obj) => { // Only load the latest record incase there are more
                        this.otherDetailsData = {
                            id: obj.id,
                            employee_id: obj.employee_id,
                            job_position_applied: obj.job_position_applied,
                            referred_by_employee_id: obj.referred_by_employee_id,
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
                        if(referredBy.length){
                            referrerArray.push({
                                id: referredBy[0].id,
                                text: (referredBy[0].first_name + ' ' + referredBy[0].middle_name + ' ' + referredBy[0].last_name)
                            });
                        }
                        if(obj.interviewer){
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

            saveApplicantShift(employee_id){
                if(this.shiftsData.value){
                    if(this.shiftsData.value == "CUSTOM_TIME"){
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
            async loadShifts(){
                await this.getShifts({query: {take: 9999}});
                await this.shifts.forEach((obj) => {
                    this.shiftsData.options.push(obj);
                });
                if(this.applicant && this.employee.shift && this.employee.shift.data){
                    let obj = this.employee.shift.data;

                    this.shiftsData.id = obj.id;
                    this.shiftsData.employee_id = obj.employee_id;
                    this.shiftsData.shift_id = obj.shift_id;
                    this.shiftsData.start_time = obj.shift_id <= 0 ? obj.time.ph.start : '';
                    this.shiftsData.end_time = obj.shift_id <= 0 ? obj.time.ph.end : '';

                    this.shiftsData.value = (this.employee.shift.data.shift_id === 0 ? "CUSTOM_TIME" : this.employee.shift.data.shift_id);
                }
            },

            async saveWorkExperiences(employee_id){
                if(this.hasValueAll(this.workExperienceData.form,this.workExperienceData.fields)){
                    await this.addWorkExperienceValue();
                }
                await this.workExperienceData.registered.forEach((work) => {
                    if(!work.employee_id){ this.$set(work,'employee_id',employee_id); }
                    if(!work.order){ this.$set(work,'order',0); }
                    this.saveWorkExperience(work);
                });

                /**
                 *  This is commented as we are not going to compare records with existing employee.
                 *  The records we are expecting here are coming from new applicant, meaning fresh
                 *  addition to the record and no comparison has to be done here.
                 */
                //Delete those removed in the list
                /*if(this.employee.workExperiences && this.employee.workExperiences.data.length){
                    let tempData = [];
                    await this.employee.workExperiences.data.forEach((work) => {
                        tempData = this.workExperienceData.registered.filter(obj => obj.id === work.id);
                        if(!tempData.length){
                            this.deleteWorkExperience(work.id);
                        }
                    });
                }*/
            },
            async loadWorkExperiences(){
                if(this.employee.workExperiences && this.employee.workExperiences.data.length){
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
            async addWorkExperienceValue(){
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

                if(this.workExperienceData.index > 0){
                    await this.workExperienceData.registered.every((work,index) => {
                        if(index === (this.workExperienceData.index - 1)){
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
                
                this.clearWorkExperienceValue(this.workExperienceData.form);
            },
            clearWorkExperienceValue(workExperienceForm) {
                this.workExperienceData.index = 0;
                this.clearWorkExperienceFields(workExperienceForm);
            },
            editWorkExperienceValue(nth){
                this.workExperienceData.registered.every((work,index) => {
                    if(index === nth){
                        this.workExperienceData.index = ++index;
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
                if((this.workExperienceData.index - 1) === nth)
                    this.clearWorkExperienceValue(this.workExperienceData.form);
                this.workExperienceData.registered.splice(nth,1);
            },

            async saveApplicantEducation(employee_id){
                if(this.hasValueAll(this.educationData.form,this.educationData.fields)){
                    await this.addEducationValue();
                }
                await this.educationData.registered.forEach((educ) => {
                    /** This form doesn't expect to edit already backend saved records.
                     *  We just generated temporary id while adding it to registered variable.
                     *  We should not save record with ID as it's not existing in the backend yet
                     * @type {string}
                     */
                    educ.id = '';

                    if(!educ.employee_id){ this.$set(educ,'employee_id',employee_id); }
                    if(!educ.order){ this.$set(educ,'order',0); }

                    if(educ.year_completed === '' || isNaN(educ.year_completed) || educ.year_completed == 0){
                        this.$set(educ,'is_present',1);
                    } else {
                        this.$set(educ,'is_present',0);
                    }
                    this.saveEducation(educ);
                });

                /**
                 *  This is commented as we are not going to compare records with existing employee.
                 *  The records we are expecting here are coming from new applicant, meaning fresh
                 *  addition to the record and no comparison has to be done here.
                 */
                //Delete those removed in the list
                /*if(this.employee.educations && this.employee.educations.data.length){
                    let tempData = [];
                    await this.employee.educations.data.forEach((educ) => {
                        tempData = this.educationData.registered.filter(obj => obj.id === educ.id);
                        if(!tempData.length){
                            this.deleteEducation(educ.id);
                        }
                    });
                }*/
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
                            year_completed: educ.year_completed,
                            year_completed: educ.year_completed === 0 ? '' : educ.year_completed,
                            is_present: educ.is_present,
                            order: educ.order
                        };
                        this.educationData.registered.push(data);
                    });
                }
            },
            async loadEducationalAttainmentOptions(){
                await this.attainments.forEach((obj) => {
                    this.educationData.attainmentOptions.push({
                        id: obj.id,
                        text: obj.attainment
                    });
                });
            },
            async addEducationValue(){
                let data = {
                    id: this.educationData.form.id.length ? this.educationData.form.id : this.educationData.registered.length + 1,
                    employee_id: this.educationData.form.employee_id,
                    educational_attainment_id: this.educationData.form.educational_attainment_id,
                    course_degree: this.educationData.form.course_degree,
                    school_university: this.educationData.form.school_university,
                    year_completed: this.educationData.form.is_present ? 0 : this.educationData.form.year_completed,
                    is_present: this.educationData.form.is_present ? 1 : 0,
                    order: this.educationData.form.order
                };

                if(this.educationData.form.id){
                    await this.educationData.registered.every((educ) => {
                        if(educ.id === this.educationData.form.id){
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
            editEducationValue(nth){
                this.educationData.registered.every((educ,index) => {
                    if(index === nth){
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
                setTimeout(()=>{
                    if(vm.educationData.form.is_present){
                        vm.educationData.form.year_completed = '';
                    }
                },20);
            },

            closeDialog(){
                this.loading = false;
                this.open = false;
                this.$router.push('/thankyou');
            },

            // This is not final. We need to discuss further on its security
            async generateToken(flag){
                let self = this;
                if (flag) {
                    await OAuth.tokenize().then(response => {
                        self.loading = false;
                        if (response == true) {
                            self.invalid = false;
                            User.me(true).then((res) => {
                                // redirect to dashboard
                                self.setAuth(res);
                            })
                        } else {
                            this.$router.push('/login');
                        }
                    });
                } else {
                    await OAuth.logout().then(() => {
                        let $ = jQuery;
                        $(document).ready(function(){
                            setTimeout(function(){
                                localStorage.removeItem('vuex');
                                localStorage.removeItem('auth_token');
                            },300);
                        });
                    });
                }
            },
            getLegalYear: function (years){
                var date = new Date();
                date.setFullYear(date.getFullYear() - years);
                return date;
            },
            selectSource: function (selected) {
                selected = parseInt(selected);
                const withSource = [this.referral, this.socialMedia, this.jobPortal];
                if(withSource.includes(selected)) {
                    this.displayReferralTypesSource = true;

                    /** Commented out, we don't want to use auto-suggest - instead the source **/
                    /*if(selected == this.referral) {
                        this.referralTypesSourceLabel = 'Referred By'
                        this.referralInput = true;
                    } else {
                        this.referralTypesSourceLabel = 'Source'
                        this.referralInput = false;
                    }*/

                    this.referralTypesSourceLabel = 'Source';
                    this.referralInput = false;
                } else {
                    this.displayReferralTypesSource = false
                }
                this.referralTypesData.form.referral_type_id = selected
                this.referralTypesData.form.referral_details = ''
                this.referralTypesData.form.referral_array = []
            },
            async loadReferralTypesOptions() {
                await this.referralTypes.forEach((obj) => {
                    this.referralTypesData.referralTypesArray.push({
                        id: obj.id,
                        text: obj.name
                    });
                });
            },
            async saveApplicantReferral(employee_id) {
                if(this.referralTypesData.form.referral_array && this.referralTypesData.form.referral_array.length){
                    this.referralTypesData.form.referred_by_employee_id = this.referralTypesData.form.referral_array[0].id;
                }

                let data = {
                    employee_id: employee_id,
                    referral_type_id: this.referralTypesData.form.referral_type_id,
                    referred_by_employee_id: this.otherDetailsData.referred_by_employee_id,
                };

                if(this.referralTypesData.form.referral_details){       this.$set(data, 'referral_details',      this.referralTypesData.form.referral_details); }

                this.saveOtherDetail(data).then((res) => {});
            },
            async generateDummyValue(){ // For debugging purposes only
                let grandom = new Date().getTime();
                this.employeeData.firstName = 'First Name';
                this.employeeData.middleName = 'Middle Name';
                this.employeeData.lastName = 'Last Name';
                this.employeeData.contactNo = '09052470382';
                this.employeeData.email = grandom + '@gmail.com';
                this.employeeData.dateOfBirth = '2000-12-12';
                //this.statusData.selected = 3; // Value set in created method, for public applicant form only.

                this.formData.positions.push({
                    id: 16,
                    text: 'Developer'
                });

                this.addressData.address.line_1 = 'Address Line 1';
                this.addressData.address.line_2 = 'Address Line 2';
                this.addressData.address.city = 'New City';
                this.addressData.address.postal_zip_code = '6000';
                this.addressData.address.state_province = 'Province of Cebu';

                this.addressData.paddress.line_1 = 'Address Line 1';
                this.addressData.paddress.line_2 = 'Address Line 2';
                this.addressData.paddress.city = 'New City';
                this.addressData.paddress.postal_zip_code = '6000';
                this.addressData.paddress.state_province = 'Province of Cebu';

                let data = {
                    id: 19,
                    text: "Web Designing",
                    proficiency: 5,
                    years_of_experience: 1,
                    no_of_projects_handled: 1,
                    project_roles: "Developer"
                };
                this.skillsData.skills.push(data);

                this.workExperienceData.form.company_name = "Company ABC";
                this.workExperienceData.form.job_title = "Job Title";
                this.workExperienceData.form.start_date = "2011-11-11";
                this.workExperienceData.form.end_date = "2014-11-11";
                this.workExperienceData.form.description = "Description";
                this.workExperienceData.form.reason_for_leaving = "I don't know";

                this.educationData.form.educational_attainment_id = 2;
                //this.educationData.form.year_completed = 2015;
                this.educationData.form.is_present = 1;
                this.educationData.form.course_degree = "Course of Nature";
                this.educationData.form.school_university = "University of Universe";

                this.applicant_agreed = true;
            },
        },
        components: {
            Select2,
            GenerateButton,
            SaveButton,
            ClearButton,
            AddButton,
            ModalDialog,
            VueTagsInput,
            TouchSpin,
            FlatPickr
        },
        mixins: [
            EmployeeMixin,
            StringHelperMixin,
            ModalDialogMixin,
            DateMixin,
            ApplicantMixin,
            DatePickerMixin,
            AlertMixin,
            SkillsOptionMixin,
            LoaderMixin
        ]
    }
</script>
