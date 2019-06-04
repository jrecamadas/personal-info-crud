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
                            <div class="form-group" :class="{'has-error': errors.has('name') || hasSSerror }">
                                <label>Name<span class="error">*</span></label>
                                <textarea v-validate="'required'" name="name" class="form-control" v-model="personalinfoData.name"></textarea>
								<span v-show="errors.has('name')" class="help-block form-error">{{ errors.first('name') }}</span>
                                <span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('address') || hasSSerror }">
                                <label>Address<span class="error">*</span></label>
                                <textarea v-validate="'required'" name="address" class="form-control" v-model="personalinfoData.address"></textarea>
								<span v-show="errors.has('address')" class="help-block form-error">{{ errors.first('address') }}</span>
                                <span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
                            </div>
                        </div>
						<div class="col-sm-12">
							<div class="form-group" :class="{'has-error': errors.has('birthday') || hasSSerror }">
								<label>Birthdate<span class="error">*</span></label>
								<flat-pickr class="form-control" name="birthday" v-model="personalinfoData.birthday"
									
									v-validate="'date_format:YYYY-MM-DD'"/>
									<span v-show="errors.has('birthday')" class="help-block form-error">{{ errors.first('birthday') }}</span>
									<span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
							</div>
						</div>
						<div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('phone_number') || hasSSerror }">
                                <label>Phone Number<span class="error">*</span></label>
                                <textarea v-validate="'required|numeric'" name="phone_number" class="form-control" v-model="personalinfoData.phone_number"></textarea>
								<span v-show="errors.has('phone_number')" class="help-block form-error">{{ errors.first('phone_number') }}</span>
                                <span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('email') || hasSSerror }">
                                <label>Email Address<span class="error">*</span></label>
                                <textarea v-validate="'required|email'" name="email" class="form-control" v-model="personalinfoData.email"></textarea>
								<span v-show="errors.has('email')" class="help-block form-error">{{ errors.first('email') }}</span>
                                <span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
                            </div>
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
	import FlatPickr from 'vue-flatpickr-component';
	import 'flatpickr/dist/flatpickr.css';
	import { mask } from 'vue-the-mask';

	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';
	import AlertMixin from '@common/mixin/AlertMixin';
	import DateMixin from '@common/mixin/DateMixin';
	import DatePickerMixin from '@common/mixin/DatePicker';

	import { mapActions, mapGetters } from 'vuex';
	export default {
		props: {
			info: { type: Object, required: true}
		},
		data() {
			return {
				valid:false,
				option: { width: '500px' },
	            personalinfoData: { id: '', name: '',address : '', birthday: '',phone_number: '',email: ''},
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput : false,
	            hasSSerror: false,
	            ssError: null,
	            personalinfoNameDBVal:''
			}
		},
		computed: {
			...mapGetters({
				//personalinfo:'personalInfo/info',
				meta:'personalInfo/meta',
            	personalinfo: 'personalInfo/data'
			}),
			isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
					// validate accordingly
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.personalinfoData, form.path))) {
	                            valid = false;
	                            return;
	                        }
	                    }
	                });

	                if (!valid) return;
				})
				return valid;
			}
		},
		async created() {
			this.personalinfoData.id = this.info.info || 0;
			this.personalinfoData.name = this.personalinfo.name || '';
			this.personalinfoData.address = this.personalinfo.address || '';
			this.personalinfoData.birthday = this.personalinfo.birthday || '';
			this.personalinfoData.phone_number = this.personalinfo.phone_number || '';
			this.personalinfoData.email = this.personalinfo.email || '';
			this.personalinfoNameDBVal = this.personalinfo.name;
		},
		methods: {
			...mapActions({
				// actions.js
				savePersonalInfo: 'personalInfo/savePersonalInfo',
				fetchInfo: 'personalInfo/getPersonalInfo',
                searchPersonalInfo: 'personalInfo/searchPersonalInfo'
			}),
			async save() {
				this.loading = true;
			    if(this.personalinfoData.length && this.personalinfoData[0].deleted_at){
			        this.personalinfoData.id = this.personalinfoData[0].id;
                }
				this.hasSSerror = false;
				this.ssError = '';
				this.errors.clear();
				this.savePersonalInfo(this.personalinfoData).then(() => {
					this.$emit('success');
					setTimeout(() => {
						this.closeModal();
			    		this.loading = false;
						this.personalinfoData = {};
						this.notifyDialog('success', 'Successfully saved!');
					},150);
				}).catch((e) => {
					this.loading = false;
					this.hasSSerror = true;
					this.ssError = e.response.data.message.name[0];
				});
			},
			resetSSError(event) {
				if(event.target.value.trim() != this.personalinfoNameDBVal) {
					this.hasSSerror = false;
					this.ssError = '';
				}
			}
		},
		components: {
	        GenerateButton,
	        SaveButton,
			ModalDialog,
			FlatPickr
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
			StringHelperMixin,
			AlertMixin,
			DatePickerMixin,
			DateMixin,
	    ]
	}
</script>