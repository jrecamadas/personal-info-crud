<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" :cancel="closeText" @close="closeModal">
        <template slot="button" v-if="!isSuccess">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid">Update</save-button>
        </template>
        <template slot="body">
			<div class="row row-success" v-if="isSuccess" >
				<div class="col-md-12" style="font-size:24px;">
					Password has been changed!
				</div>
				<div class="col-md-12">
					You will be logged out for the new password to take effect.
				</div>
			</div>
            <div class="row" v-else>
				<div class="col-md-12">
                    <div class="form-group" :class="{'has-error': errors.has('current') || hasCurrentErr }">
						<label>Current Password:<span class="error">*</span></label>
                        <input type="password" name="current" v-model="form.current" @input="checkCurrent" class="form-control" v-validate="'required'"/>
						<span v-show="errors.has('current')" class="help-block form-error">{{ this.stringReplace(errors.first('current'),'current','Current Password') }}</span>
                        <span v-show="hasCurrentErr" class="help-block form-error">{{ hasCurrentErrMsg }}</span>
					</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group" :class="{'has-error': errors.has('new') || hasPasswordErr || newPassErr}">
						<label>New Password:<span class="error">*</span></label>
                        <input type="password" name="new" v-model="form.new" class="form-control" @input="checkPassword" v-validate="'required'"/>
						<span v-show="errors.has('new')" class="help-block form-error">{{ this.stringReplace(errors.first('new'),'new','New Password') }}</span>
                		<span v-show="newPassErr" class="help-block form-error">{{ newPassErrMsg }}</span>
					</div>
				</div>
                <div class="col-md-12">
                    <div class="form-group" :class="{'has-error': errors.has('confirmnew') || hasPasswordErr }">
						<label>Confirm New Password:<span class="error">*</span></label>
                        <input type="password" name="confirmnew" v-model="form.confirmnew" class="form-control" @input="checkPassword" />
						<span v-show="hasPasswordErr" class="help-block form-error">{{ passwordErrMsg }}</span>
                	</div>
				</div>
            </div>
        </template>
    </modal-dialog>
</template>
<style lang="scss" scoped>
    div.row-success{
        padding-top: 10px;
        padding-bottom: 20px;
        div{
            text-align: center;
        }
	}
</style>
<script>
	import _ from 'lodash';

	//Components
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
	import ModalDialog from '@components/modal-dialog.vue';

    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';

	import { mapActions, mapGetters } from 'vuex';

	export default {
		props: {
			info: { type: Object, required: true }
		},
		data() {
			return {
				option: { width: '460px' },
                button: { class: 'btn btn-primary',type: 'button' },
                loading: false,
				valid: false,
				title: '',
                form: {
                    current: '',
                    new: '',
                    confirmnew: ''
                },
                validation: [
                       { path: 'current', name: 'current', rule: 'required', msg: {required: 'The current password field is required'} },
					   { path: 'new', name: 'new', rule: 'required', msg: {required: 'The new password field is required'} }
				],
				notvalid: true,
				hasCurrentErr: false,
				hasPasswordErr: false,
				newPassErr: false,
				hasCurrentErrMsg: 'Incorrect password',
				newPassErrMsg: '',
				passwordErrMsg: '',
				isSuccess: false,
				isEqualToCurrent: false,
				closeText: 'Cancel',
				alpha_num: /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/
			}
        },
        computed: {
			...mapGetters({
				isCurrent: 'checkPass/data'
            }),
            isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.form, form.path))) {
	                            valid = false;
	                            return;
	                        }
	                    }
	                });

	                if (!valid) return;
                })
				
				if(this.notvalid) return false;
				if (!this.isCurrent.data.current) return;
				if(this.hasPasswordErr) return false;
				if(this.isEqualToCurrent) return false; 
				if(this.newPassErr) return false;
				if(!this.alpha_num.test(this.form.new)) return false;

				return valid;
			}
		},
		async created() {	
		},
		methods: {
            ...mapActions({
				checkPass: 'checkPass/check',
				saveUsername: 'users/saveUser',
            }),
            save() {
				this.loading = true;
				let data = {id: this.info.id, password: this.form.new};
                this.saveUsername(data).then((res) => {
					this.checkPass({password: this.form.new, user_id: this.info.id});
					if(this.isCurrent.data.current) {
						this.loading = false;
						this.isSuccess = true;
						this.closeText = "Close";
						this.$emit('success');
					}
				});
			},
			async doCheck() {
				await this.checkPass({password: this.term, user_id: this.info.id});
				this.notvalid = false;
				if(this.term != "") {
					this.hasCurrentErr = !this.isCurrent.data.current;
				}
				this.loading = false;
			},
			checkCurrent(term) {
				this.notvalid = true;
				this.loading = true;
				this.term = term.target.value;
				if(this.term == "") {
					this.hasCurrentErr = false;
				}
                if (this.timeOut != null) {
                    this.isTyping = false;
                    clearTimeout(this.timeOut);
                    this.timeOut = null;
                }
                if (!this.isTyping) {
                    this.timeOut = setTimeout(this.doCheck, 500);
                }
			},
			checkPassword() {
				if(this.form.new == this.form.current && !this.hasCurrentErr) {
					this.isEqualToCurrent = true;
					this.newPassErr = true;
					this.newPassErrMsg = 'New password must not match current password';
				} else {
					this.isEqualToCurrent = false;
					this.newPassErr = false;
					this.newPassErrMsg = '';
				}

				if(this.form.confirmnew != this.form.new && !this.isEqualToCurrent) {
					this.hasPasswordErr = true;
					this.passwordErrMsg = 'New password does not match';
				} else {
					this.hasPasswordErr = false;
					this.passwordErrMsg = '';
				}

				if(this.form.new.length < 6) {
					this.newPassErr = true;
					this.newPassErrMsg = 'New password must be at least 6 alphanumeric characters';
				} else {
					this.newPassErr = false;
					this.newPassErrMsg = '';
				}

				if(this.form.new.length >= 6) {
					if(!/(?=.*\d)/.test(this.form.new)) {
						this.newPassErr = true;
						this.newPassErrMsg = 'New password must contain atleast 1 numeric character';
					}
					if(!/(?=.*[a-z])/.test(this.form.new)) {
						this.newPassErr = true;
						this.newPassErrMsg = 'New password must contain atleast 1 lowercase character';
					}
					if(!/(?=.*[A-Z])/.test(this.form.new)) {
						this.newPassErr = true;
						this.newPassErrMsg = 'New password must contain atleast 1 uppercase character';
					}
				}
			}
		},
		components: {
	        GenerateButton,
	        SaveButton,
			ModalDialog
	    },
	    mixins: [
            ModalDialogMixin,
            StringHelperMixin
	    ]
	}
</script>