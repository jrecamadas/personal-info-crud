<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
        <template slot="body">
            <div class="row">
				<div class="col-md-12">
                    <div class="form-group">
						<label>Sent To: </label>
						<div class="row">
							<div class="col-md-3" v-for="contact in contactOptions">
								{{ contact }}
							</div>
						</div>
                	</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group">
						<label>Report Date: </label>
						<div class="row">
							<div class="col-md-12">{{ formatDate(report.report_date, "MM-DD-YYYY") }}</div>
						</div>
                	</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group">
						<label>Subject: </label>
						<div class="row">
							<div class="col-md-12">{{ report.subject }}</div>
						</div>
                	</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group">
						<label>Content: </label>
						<div class="row">
							<div class="col-md-12">{{ report.content }}</div>
						</div>
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

	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';
	import DateMixin from '@common/mixin/DateMixin';

	import { mapActions, mapGetters } from 'vuex';

	export default {
		props: {
			info: { type: Object, required: true }
		},
		data() {
			return {
				option: { width: '700px' },
                button: { class: 'btn btn-primary',type: 'button' },
                contactOptions: []
			}
        },
        computed: {
			...mapGetters({
				report: 'employeeReports/employeeReport'
			})
		},
		async created() {
            await this.getEmployeeReport(this.info.id);
            this.contactOptions = this.report.send_to.split(',');
		},
		methods: {
            ...mapActions({
				getEmployeeReport: 'employeeReports/getEmployeeReport'
			}),
		},
		components: {
	        GenerateButton,
	        SaveButton,
			ModalDialog
	    },
	    mixins: [
	        ModalDialogMixin,
			StringHelperMixin,
			DateMixin
	    ]
	}
</script>