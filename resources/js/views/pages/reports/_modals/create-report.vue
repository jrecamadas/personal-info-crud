<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
		<template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid">{{info.name}}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Report Type<span class="error">*</span></label>
                                <select2
	                                v-if="reports.length"
	                                :options="reports"
	                                :value="reportTemplateData.report_id"
	                                @select="onChangeReport"
	                            />
                            </div>
                        </div>
                        <div class="col-sm-12"> 
                            <div class="form-group">
                                <label>Report Name<span class="error">*</span></label>
                                <input type="text" name="name" class="form-control" v-validate="'required'" v-model="reportTemplateData.name">
                            </div>
                        </div>
                        <div class="col-sm-12"> 
                            <div class="form-group">
                                <label>Template File<span class="error">*</span></label>
                                <input type="text" name="view_file" class="form-control" v-validate="'required'" :disabled="1" v-model="reportTemplateData.view_file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>
<style lang="scss" scoped>
</style>

<script>
	import _ from 'lodash';

	//Components
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
	import ModalDialog from '@components/modal-dialog.vue';
	import Select2 from '@components/select2.vue';

	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex';

	export default {
		props: {
			info: { type: Object, required: true}
		},
		data() {
			return {
				valid:false,
				option: { width: '500px' },
	            reportTemplateData: {id: '', report_id: 0, name: '', view_file: '', default:false},
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput : false,
	            validation: [
	                { path: 'name', name: 'name', rule: 'required', msg: {required: 'The name field is required'} }
	            ]
			}
		},
		computed: {
			...mapGetters({
				reportTemplate:'reportTemplates/reportTemplate',
				reports:'reports/formatted',
				reportTemplateFilter:'reportTemplates/reportTemplateFilter'
			}),
			isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
					// validate accordingly
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.reportTemplateData, form.path))) {
	                            valid = false;
	                            return;
	                        }
	                    }
	                });

	                if (!valid) return;
				})
				return valid;
			},
		},
		async created() {
			await this.fetchReports({take:9999});
			await this.fetchReportTemplate(this.info.template);
			this.reportTemplateData.name 		= this.reportTemplate.name;
			this.reportTemplateData.view_file 	= (!this.reportTemplate.view_file) ? "daily_report" : this.reportTemplate.view_file;
			this.reportTemplateData.id 			= this.reportTemplate.id;
			this.reportTemplateData.report_id 	= this.reportTemplate.report_id || 1;
			this.reportTemplateData.default 	= (this.reportTemplate.default == 1) ? true : false;
		},
		methods: {
			...mapActions({
				saveReportTemplate: 'reportTemplates/saveReportTemplate',
				fetchReportTemplate: 'reportTemplates/getReportTemplate',
				reportTemplatesWithFilter : 'reportTemplates/getReportTemplatesWithFilter',
				fetchReports:'reports/getReports'
			}),
			async save() {
				this.loading = true;
				this.reportTemplateData.default = this.reportTemplateData.default ? 1 : 0;  
				// if the current report template was set to default
				// then set all the existing default report template in the db to 0 
				if (this.reportTemplateData.default) {
					let data = this.reportTemplateFilter;
					await Promise.all(data.map(async value => {
						if (value.default) {
							value.default = 0;
							const response = await this.saveReportTemplate(value);
						}
					}));
				} 

				await this.saveReportTemplate(this.reportTemplateData);
				this.$emit('success');
				setTimeout(() => {
					this.closeModal();
					this.loading = false;
					this.reportTemplateData = {};
					this.notifyDialog('success', 'Successfully saved!');
				},150);
			},
			onChangeReport(event) {
				this.reportTemplateData.report_id = event;
				this.loadReportTemplatesByReportId(event)
			},
			async loadReportTemplatesByReportId(report_id) {
				await this.reportTemplatesWithFilter({report_id:report_id});
			},


		},
		components: {
	        GenerateButton,
	        SaveButton,
	        ModalDialog,
	        Select2
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
			StringHelperMixin,
			AlertMixin
	    ]
	}
</script>
