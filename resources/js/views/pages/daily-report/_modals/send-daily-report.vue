<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" :confirmCancel="true" @close="closeModal">
		<template slot="button">
            <save-button v-if="forPreview" :loading="loading" :options="button" @action="preview" :disabled="!valid">Preview</save-button>
			<div class="action-wrapper" v-else>
				<save-button  :options="button" @action="update" :disabled="!valid">Edit</save-button>
				<save-button  :loading="loading" :options="button" @action="send" :disabled="!valid">Send Report</save-button>
			</div>
        </template>
        <template slot="body">
            <div class="row" v-if="forPreview">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" :class="{'has-error': errors.has('report_template_id')}">
								<label>Report Type<span class="error">*</span></label>
								<select2
								:disabled="disable || reportData.options.length <= 1"
								v-if="reportData && reportData.options.length"
								:options="reportData.options"
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
								:disabled="disable || projectData.options.length <= 1"
								v-if="projectData && projectData.options.length"
								:options="projectData.options"
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
						<div class="col-md-3">
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
						<div class="col-md-9">
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
                    	<label>What I did today:<span class="error">*</span></label>

                       	<wysiwyg v-model="form.content" :options="editorOptions" v-validate="'required'" name="content" placeholder="Enter your updates here"/>
                       	<span v-show="errors.has('content')" class="help-block form-error">{{ errors.first('content') }}</span>
                    </div>
                </div>
				<div class="col-md-12">
            		<div class="form-group" :class="{'has-error': errors.has('todo')}">
                    	<label>What I will be doing the next working day:<span class="error">*</span></label>
                       	<wysiwyg v-model="form.todo" :options="editorOptions" v-validate="'required'" name="todo" placeholder="Enter your updates here"/>
                       	<span v-show="errors.has('todo')" class="help-block form-error">{{ errors.first('todo') }}</span>
                    </div>
                </div>
				<div class="col-md-12">
            		<div class="form-group">
                    	<label>My Roadblocks/Impediments:</label>
                       	<wysiwyg v-model="form.roadblocks" :options="editorOptions" v-validate="'required'" name="roadblocks" placeholder="Enter your updates here"/>
                    </div>
                </div>
				<div class="col-md-12">
            		<div class="form-group">
                    	<label>Other Remarks:</label>
                       	<wysiwyg v-model="form.remarks" :options="editorOptions" v-validate="'required'" name="remarks" placeholder="Enter your updates here"/>
                    </div>
                </div>
            </div>
			<div class="row form-group" v-else>
				<div class="col-md-12">
					<div class="row preview-row">
						<div class="col-md-12">
						<label class="preview-label">Send To: </label>
						<div class="email-wrapper">
							<div v-for="email in emails">{{ email }} </div>
						</div>
						</div>
					</div>
					<div class="row preview-row">
						<div class="col-md-12">
						<label class="preview-label">Subject: </label>
						{{ form.subject }}
						</div>
					</div>
					<div class="row preview-row">
						<div class="col-md-12">
						<label class="preview-label">Report Date: </label>
						{{ form.report_date }}
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<label class="preview-label preview">Preview: </label>
					<div v-html="toPreview"></div>
				</div>
			</div>
        </template>
    </modal-dialog>
</template>
<style>
    body div.v-dialogs{
        position: relative;
        z-index: 9999;
    }
	div.modal-backdrop div[role='dialog'] header span{
        width: auto!important;
    }
    div.modal-backdrop div[role='dialog'] header span div.action-wrapper{
        float: right !important;
    }

	.modal-backdrop .modal {
		width: 847px!important;
		height: auto!important;
	    /*height: 660px!important;*/
		overflow-y: auto;
	}
	.modal #modalDescription {
		overflow-y: auto;
		overflow-x: hidden;
	}
	.action-wrapper {
		display: inline-block;
	}
	.preview-label {
		vertical-align: top;
		font-weight: bold;
		width: 8em;
		margin: 0;
	}
	.preview {
		padding-bottom: 1em;
	}
	.email-wrapper {
		display: inline-block;
	}
	.preview-row {
		padding-bottom: 1em;
	}
	.elseCondition {
		color: red;
	}
</style>

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
	import AlertMixin from '@common/mixin/AlertMixin';

	import FlatPickr from 'vue-flatpickr-component';
	import 'flatpickr/dist/flatpickr.css';
	import { mapActions, mapGetters } from 'vuex';
	import jQuery from 'jquery';

	export default {
		props: {
			info: { type: Object, required: true }
		},
		data() {
			return {
				option: { width: '800px' },
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput : false,
	            validation: [
                       { path: 'subject',     name: 'subject',     rule: 'required', msg: {required: 'The subject field is required'} },
					   { path: 'content',     name: 'content',     rule: 'required', msg: {required: 'The message field is required'} },
					   { path: 'todo',        name: 'todo',        rule: 'required', msg: {required: 'The todo field is required'} },
					   { path: 'report_date', name: 'report_date', rule: 'required', msg: {required: 'The report date field is required'} },
                ],
	            form: {
					content: '',
					todo: '',
					roadblocks: '',
					remarks: '',
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
				projectData: {
					options: []
				},
				reportData: {
					options: []
				},
				contactOptions: [],
				reportDateOptions: {
					altFormat: "M d, Y",
					dateFormat: "M d, Y",
					allowInput: true,
					maxDate: 'today',
					onChange: (selectedDates, dateStr, instance) => {
						this.selectedDate = dateStr ? "(" + dateStr + ")" : "";
						let toSet = (this.selectedProject[this.form.client_project_id] ? this.selectedProject[this.form.client_project_id] + " : " : '');
						this.form.subject = toSet + "Daily Report " + this.selectedDate + " - " + this.info.employee;
					}
				},
				projectIncludes: [
					'clientProject',
					'employee'
				],
				selectedDate: '',
				emails: [],
				flag: 0,
				contactFlag: 1,
				forPreview: true,
				toPreview: '',
				disable: true,
				toSend: ''
			}
		},
		computed: {
			...mapGetters({
				loggedInUser: 'auth/data',
				employee: 'employees/single',
				reportTemplateFilter: 'reportTemplates/reportTemplateFilter',
				reports: 'reportTemplates/reportTemplateFilter',
				projects: 'employeeClientProjects/data',
				contacts: 'clientContacts/formatted',
				previews: 'sendReport/data'
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
                valid = (this.form.report_template_id == "---------------" || this.form.report_template_id == 0) ? false : valid;
                // Check if contact number is blank
				valid = (this.form.client_project_id == "---------------" || this.form.client_project_id == 0) ? false : valid;
				valid = !this.emails.length ? false : valid;

                return valid;
            }
		},
		async created() {
			this.loading = true;
			this.disable = true;

			this.projectData.options.push({id:0, text:'---------------'});
			this.reportData.options.push({id:0, text:'---------------'});
			await this.fetchEmployee({user_id: this.loggedInUser.data.id});
			this.form.employee_id = this.employee[0].id;
			await this.fetchProjects({
				employee: this.employee[0].id,
				include: this.projectIncludes.join(",")
			});

			await this.fetchReports({type:'Daily Report'});
			this.form.subject = 'Daily Report';

			this.projects.forEach(project => {
				this.selectedClient[project.clientProject.data.id] = project.clientProject.data.client_id;
				this.selectedProject[project.clientProject.data.id] = project.clientProject.data.project_name;
				this.projectData.options.push({id:project.clientProject.data.id, text:project.clientProject.data.project_name});
			});
			this.reportTemplateFilter.forEach(report => {
				this.reportData.options.push({id:report.id, text:report.name});

			});
			this.contactOptions = [{email:'reports@fullscale.io',id:1}];
			this.emails = ['reports@fullscale.io'];
			this.disable = false;
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
			async preview() {
				this.loading = true;
				this.info.name = "Preview Report";
				this.toSend = this.emails.join(', ');
				await this.sendDailyReport(this.form).then(() => {
					this.toPreview = this.previews.data.preview;
					this.forPreview = false;
					this.loading = false;
				});
			},
			update() {
				this.forPreview = true;
			},
			send() {
				this.loading = true;
				this.form.sent = 0;
				this.form.send_to = this.emails.join(',');
				this.form.report_date = this.formatDate(this.form.report_date, 'YYYY-MM-DD');
				this.form.roadblocks = this.form.roadblocks ? this.form.roadblocks : "None";
				this.saveEmployeeReport(this.form).then((res) => {
					this.$emit('success');
					this.loading = false;
					this.notifyDialog('success', 'Email Sent!');
				});
			},
			async updateSubjectProject($project) {
				this.loading = true;
				this.form.client_project_id = $project;
				if(this.selectedClient[$project] != undefined) {
					await this.fetchContacts({query: {client_id: this.selectedClient[$project]}});
					let contactCount = 0;
					if(this.contactFlag)
					{
						this.contactOptions = [];
						this.contacts.forEach(contact =>{
							this.contactOptions.push(contact);
							contactCount++;
							if(contactCount == this.contacts.length)
								this.contactFlag = 0;
						});
						this.contactOptions.push({email:'reports@fullscale.io',id:this.contacts.length+1});
						this.emails = ['reports@fullscale.io'];
					} else {
						this.contactFlag = 1;
					}

					if(!this.flag) {
						this.form.subject =  this.selectedProject[$project] + " : Daily Report " + this.selectedDate + " - " + this.info.employee;
						this.flag = 1;
					} else {
						this.flag = 0;
					}
				} else {
					this.form.subject =  "Daily Report " + this.selectedDate + " - " + this.info.employee;
					this.contactOptions = [{email:'reports@fullscale.io',id:1}];
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
			DatePickerMixin,
			AlertMixin
	    ]
	}
</script>
