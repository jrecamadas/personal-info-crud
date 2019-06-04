<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
		<template slot="button">
            <save-button :loading="loading" :options="button" @action="send" :disabled="!valid">{{info.name}}</save-button>
        </template>
        <template slot="body">
            <div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': errors.has('report_template_id')}">
								<label>Report Type<span class="error">*</span></label>
								<select2
								v-if="reportOptions.length"
								:options="reportOptions"
								:value="form.report_template_id"
								@select="form.report_template_id = $event"
								name="report_template_id"
								>
								</select2>
							</div>
						</div>
						<div class="col-md-6" :class="{'has-error': errors.has('client_project_id')}">
							<div class="form-group">
								<label>Project<span class="error">*</span></label>
								<select2
								v-if="projectOptions.length"
								:options="projectOptions"
								:value="form.client_project_id"
								@select="updateSubjectProject($event)"
								name="client_project_id"
								>
								</select2>
							</div>
						</div>
					</div>
                </div> 
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group" :class="{'has-error': errors.has('report_date')}">
								<label>Report Date<span class="error">*</span></label>
								<flat-pickr 
									v-model="form.report_date"
									:config="getConfig(true, false, reportDateOptions)"
									placeholder="Select a report date"
									name="report_date"
									v-validate="'required'"
								/>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group" :class="{'has-error': errors.has('subject')}">
								<label>Subject<span class="error">*</span></label>
								<input type="text" name="subject" v-model="form.subject" class="form-control" v-validate="'required'" :disabled="true"/>
								<span v-show="errors.has('subject')" class="help-block form-error">{{ errors.first('subject') }}</span>
							</div>
						</div> 
					</div>
				</div>
            	 <div class="col-md-12">
                	<div class="form-group" :class="{'has-error': errors.has('send_to')}">
						<label>Send To<span class="error">*</span></label>
						<div class="row">
							<div class="col-md-4" v-for="contact in contactOptions">
								<input type="checkbox" v-model="emails" :id="'email_' + contact.id" :value="contact.email"  />
								<label :for="'email_' + contact.id">{{ contact.email }}</label>
							</div>
						</div>
                		<!-- <label>To<span class="error">*</span></label>
                		<input type="text" name="send_to" v-model="form.send_to" class="form-control" v-validate="'required|email'" />
                       	<span v-show="errors.has('send_to')" class="help-block form-error">{{ errors.first('send_to') }}</span> -->
                	</div>
                </div> 
                <div class="col-md-12">
            		<div class="form-group" :class="{'has-error': errors.has('content')}">
                    	<label>Message<span class="error">*</span></label>
                       	<wysiwyg v-model="form.content" :options="editorOptions" v-validate="'required'" name="content" placeholder="Enter your updates here"/>
                       	<span v-show="errors.has('content')" class="help-block form-error">{{ errors.first('content') }}</span>
                    </div>
                </div> 
            </div>
        </template>
    </modal-dialog>
</template>

<script>
	import _ from 'lodash';

	//Components
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
	import ModalDialog from '@components/modal-dialog.vue';
	import Select2 from "@components/select2.vue";

	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';
	import DatePickerMixin from '@common/mixin/DatePicker';

	import wysiwyg from "vue-wysiwyg";

	import FlatPickr from 'vue-flatpickr-component';
	import 'flatpickr/dist/flatpickr.css';
	
	import { mapActions, mapGetters } from 'vuex';

	export default {
		props: {
			info: { type: Object, required: true }
		},
		data() {
			return {
				option: { height: 'auto', width: '700px', bottom: 'auto' },
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput : false,
	            validation: [
                       { path: 'subject',      name: 'subject', rule: 'required', msg: {required: 'The subject field is required'} },
					   { path: 'content',      name: 'content', rule: 'required', msg: {required: 'The message field is required'} },
					   { path: 'report_date',      name: 'report_date', rule: 'required', msg: {required: 'The report date field is required'} },
                ],
	            form: {
	            	content:'',
	            	subject: '',
	            	employee_id: '',
	            	send_to: {},
					report_template_id: 0,
					client_project_id: 0,
	            	report_date: ''
	            },
	            editorOptions : {
	            	hideModules: { 
	            		forcePlainTextOnPaste: true, image:true, code:true 
	            	},
	            	maxHeight:'400px'
				},
				selectedProject: [],
				selectedClient: [],
				projectOptions: [],
				reportOptions: [],
				contactOptions: [],
				reportDateOptions: {
					altFormat: "MMM-dd-YYYY",
					dateFormat: "MMM-dd-YYYY",
					allowInput: true,
					maxDate: 'today',
					onChange: (selectedDates, dateStr, instance) => {
						this.selectedDate = dateStr ? "(" + dateStr + ")" : "";
						let toSet = (this.selectedProject[this.form.client_project_id] ? this.selectedProject[this.form.client_project_id] + " - " : '');
						this.form.subject = toSet + "Daily Report " + this.selectedDate;
					}
				},
				projectIncludes: [
					'clientProject',
					'employee'
				],
				selectedDate: '',
				emails: [],
				flag: 0,
				contactFlag: 1
			}
		},
		computed: {
			...mapGetters({
				loggedInUser: 'auth/data',
				employee: 'employees/single',
				reportTemplateFilter: 'reportTemplates/reportTemplateFilter',
				reports: 'reportTemplates/data',
				projects: 'employeeClientProjects/data',
				contacts: 'clientContacts/formatted'
			}),
         valid: function() {
                let valid = true;

                // check validation form validation set rule
                _.each(this.validation, (form) => {
                    // break validation rule
                    let rules = form.rule.split('|');

                    // validate accordingly
                    _.each(rules, (rule) => {
                        if (rule == 'required') {
                            if (this.isEmpty(_.get(this.form, form.path))) {
                                valid = false;
                                return;
                            }
                        }
                    });
                    if (!valid) return;
                });
				
				// Check if contact name is blank
                valid = (this.form.report_template_id == 0) ? false : valid;
                // Check if contact number is blank
                valid = (this.form.client_project_id == 0) ? false : valid;
				valid = !this.emails.length ? false : valid;

                return valid;
            }
		},
		async created() {
			this.loading = true;
			this.projectOptions.push({id:0, text:'---------------'});
			this.reportOptions.push({id:0, text:'---------------'});
			await this.fetchEmployee({user_id: this.loggedInUser.data.id});
			this.form.employee = this.employee[0].id;
			await this.fetchProjects({
				employee: this.employee[0].id,
				include: this.projectIncludes.join(",")
			});
			
			await this.fetchReports({type:'Daily Report'});
			this.form.subject = 'Daily Report';
			
			this.projects.forEach(project => {
				this.selectedClient[project.clientProject.data.id] = project.clientProject.data.client_id;
				this.selectedProject[project.clientProject.data.id] = project.clientProject.data.project_name;
				this.projectOptions.push({id:project.clientProject.data.id, text:project.clientProject.data.project_name});
			});
			
			this.reports.forEach(report => {
				this.reportOptions.push({id:report.id, text:report.name});
			});
			this.contactOptions.push({id:0,email:'reports@fullscale.io'});
			this.loading = false;
		},
		methods: {
			...mapActions({
				fetchReports:'reportTemplates/getReportTemplatesWithFilter',
				fetchEmployee: 'employees/getEmployee',
				fetchProjects: 'employeeClientProjects/getProjectsOfResource',
				fetchContacts: 'clientContacts/getContacts',
				saveEmployeeReport: 'employeeReports/saveEmployeeReport',
				sendDailyReport: 'sendReport/send'
			}),
			formatDate(date, format) {
            	return moment(date).format(format);
        	},
			send() {
				this.loading = true;
				this.form.sent = 0;
				let toSend = this.emails.join(',');
				this.form.send_to = toSend;
				this.form.report_date = this.formatDate(this.form.report_date, 'YYYY-MM-DD');
				this.saveEmployeeReport(this.form).then((res) => {
					this.loading = false;
					this.$emit('success');
				});
			}, 
			async updateSubjectProject($project) {
				this.loading = true;
				this.contactOptions = [{id:0,email:'reports@fullscale.io'}];
				this.form.client_project_id = $project;
				if(this.selectedClient[$project] != undefined) {
					await this.fetchContacts({query: {client_id: this.selectedClient[$project]}});
					let contactCount = 0;
					if(this.contactFlag)
					{
						this.contacts.forEach(contact =>{
							this.contactOptions.push(contact);
							contactCount++;
							if(contactCount == this.contacts.length)
								this.contactFlag = 0;
						});
					} else {
						this.contactFlag = 1;
					}

					if(!this.flag) {
						this.form.subject =  this.selectedProject[$project] + " - Daily Report " + this.selectedDate;
						this.flag = 1;
					} else {
						this.flag = 0;
					}
				} else {
					this.form.subject =  "Daily Report " + this.selectedDate;
				}
				this.loading = false;
			}
		},
		components: {
	        GenerateButton,
	        SaveButton,
			ModalDialog,
			Select2,
			FlatPickr
	    },
	    mixins: [
	        ModalDialogMixin,
			StringHelperMixin,
			DatePickerMixin
	    ]
	}
</script>
