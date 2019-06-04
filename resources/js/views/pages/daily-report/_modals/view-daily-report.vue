<template>
	<modal-dialog v-show="openModal" :options="option" :closeButtonText="'Close'" :title="info.name" @close="closeModal">
        <template slot="body">
            <div class="row">
				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label class="col-md-2 font-weight-bold">Sent To: </label>
							<div class="col-md-3" v-for="contact in contactOptions">
								{{ contact }}
							</div>
						</div>
                	</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label class="col-md-2 font-weight-bold">Report Date: </label>
							<div class="col-md-10">{{ formatDate(report.report_date, "MMM DD, YYYY") }}</div>
						</div>
                	</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label class="col-md-2 font-weight-bold">Subject: </label>
							<div class="col-md-10">{{ report.subject }}</div>
						</div>
                	</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group">
						<label class="font-weight-bold">What I did today: </label>
						<div class="row">
							<div class="col-md-12" v-html="report.content"></div>
						</div>
                	</div>
				</div>
				<div class="col-md-12">
                    <div class="form-group">
						<label class="font-weight-bold">What I will be doing the next working day: </label>
						<div class="row">
							<div class="col-md-12" v-html="report.todo"></div>
						</div>
                	</div>
				</div>
				<div class="col-md-12">
                    <div class="form-group">
						<label class="font-weight-bold">My Roadblocks/Impediments: </label>
						<div class="row">
							<div class="col-md-12" v-html="report.roadblocks"></div>
						</div>
                	</div>
				</div>
				<div v-if="report.remarks" class="col-md-12">
                    <div class="form-group">
						<label class="font-weight-bold">Other Remarks: </label>
						<div class="row">
							<div class="col-md-12" v-html="report.remarks"></div>
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
