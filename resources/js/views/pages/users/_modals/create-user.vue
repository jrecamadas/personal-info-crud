<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
		<template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('user_name') || hasUsernameErr }">
                                <label>Username<span class="error">*</span></label>
                                <input type="text" v-validate="'required'" ref="user_name" name="user_name" class="form-control" v-model="UserData.user_name" @keyup="checkUsernameIfAvaialble"/>
                                <span v-show="errors.has('user_name')" class="help-block form-error">{{ errors.first('user_name') }}</span>
                                <span v-show="hasUsernameErr" class="help-block form-error">{{ usernameErrMsg }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': hasPasswordErr }">
                                <label>Password</label>
                                <input type="password" ref="password" name="password" class="form-control" @input="checkPassword" v-model="UserData.password" />
                                <!-- <span v-show="errors.has('user_name')" class="help-block form-error">{{ errors.first('password') }}</span> -->
                                <!-- <span v-show="hasError" class="help-block form-error">{{ msg }}</span> -->
                            </div>
							<div class="form-group" :class="{'has-error': hasPasswordErr }">
                                <label>Confirm Password</label>
                                <input type="password" ref="confirm_password" name="confirm_password" class="form-control" @input="checkPassword" v-model="UserData.confirmPassword"/>
								<span v-show="hasPasswordErr" class="help-block form-error">{{ passwordErrMsg }}</span>
                            </div>
                            <div class="form-group" :class="{'has-error': errors.has('email') || hasEmailErr }">
                                <label>Email<span class="error">*</span></label>
                                <input type="text" v-validate="'required|email'" ref="email" name="email" class="form-control" v-model="UserData.email" @keyup="checkEmailIfAvaialble"/>
                                <span v-show="errors.has('email')" class="help-block form-error">{{ errors.first('email') }}</span>
                                <span v-show="hasEmailErr" class="help-block form-error">{{ emailErrMsg }}</span>
                            </div>
							<div class="form-group">
                                <label>Role</label>
                                <!-- Added v-if so options will not get repeated during async ops -->
                                    <select2
                                        v-if="roleOptions && roleOptions.length"
                                        :options="roleOptions"
                                        :value="RoleData.role_id"
                                        @select="RoleData.role_id = $event"
                                    	>
                                    </select2>
                            </div>
							<div class="form-group">
                                <label>Access</label>
                                <!-- Added v-if so options will not get repeated during async ops -->
                                    <select2
                                        v-if="accessOptions && accessOptions.length"
                                        :options="accessOptions"
                                        :value="UserData.can_login"
                                        @select="UserData.can_login = $event"
                                    	>
                                    </select2>
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

	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';

	import Select2 from '@components/select2.vue';

	import { mapActions, mapGetters } from 'vuex';

	import { VeeValidate } from 'vee-validate';

	export default {
		props: {
			info: { type: Object, required: true }
		},
		data() {
			return {
				valid:false,
				option: { width: '500px' },
				UserData: {id: '', user_name: '', email: '', password:'', can_login:0},
				RoleData: {	role_id: '', user_id: '', user_type: ''},
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput : false,
	            validation: [
	                { 
	                	path: 'user_name', user_name: 'user_name', rule: 'required', msg: {required: 'The username field is required'} 
	            	},
				],
				accessOptions: [
					{id: 1, text: 'Denied'},
					{id: 2, text: 'Granted'}
				],
	            hasError: false,
	            msg: '',
	            hasEmailErr: false,
	            emailErrMsg: '',
				hasUsernameErr: false,
				hasPasswordErr: false,
				usernameErrMsg: '',
				passwordErrMsg: '',
	            oldUsername: '',
				oldEmail: '',
				isNew: false
	        }
		},
		computed: {
			...mapGetters({
				user: 'users/user',
				roleOptions: 'roles/formatted',
				role: 'roleUsers/role'
			}),
			isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.UserData, form.path))) {
	                            valid = false;
	                            return;
	                        }
	                    }
	                });

	                if (!valid) return;
				})

				if (this.hasEmailErr) return;
	            if (this.hasUsernameErr) return;
				if (this.hasError) return;
				if (this.hasPasswordErr) return;
				return valid;
			}
			
		},
		async created() {
			await this.fetchUser(this.info.user);
			await this.getUserRole(this.info.user).catch(() => {});
			await this.getRoles({query:this.getParams()});
			this.UserData.id = this.user.id || 0;
			this.UserData.user_name = this.user.user_name || '';
			this.UserData.email = this.user.email || '';
			this.UserData.password = this.user.password || '';
			this.UserData.can_login = this.user.can_login + 1;
			this.oldUsername = this.user.user_name || '';
			this.oldEmail = this.user.email || '';
			this.RoleData.role_id = this.role.role_id || 3;
		},
		methods: {
			...mapActions({
				saveUsername: 'users/saveUser',
				fetchUser: 'users/getUser',
				checkUsername :'users/checkUsername',
				checkEmail :'users/checkEmail',
				getRoles: 'roles/getRoles',
				getUserRole: 'roleUsers/getUserRole',
				saveUserRole: 'roleUsers/saveUserRole'
			}),
			checkPassword() {
				if(this.UserData.confirmPassword != this.UserData.password) {
					this.hasPasswordErr = true;
					this.passwordErrMsg = 'Password does not match';
				} else {
					this.hasPasswordErr = false;
					this.passwordErrMsg = '';
				}
			},
			save() {
				this.hasError = false;
				this.msg = '';
				this.loading = true;
				this.errors.clear();
				let data = this.UserData;
				if(!data.password.length) {
					delete data.password;
				}
				delete data.confirmPassword;
				data.can_login = data.can_login - 1;
				this.saveUsername(data).then((res) => {
					this.RoleData.id = (this.role.role_id == undefined) ? 0 : res.data.id;
					this.RoleData.user_id = res.data.id;
					this.RoleData.user_type = "App\\Models\\User";
					this.saveUserRole(this.RoleData).then(() => {
						this.loading = false;
						this.$emit('success');
						setTimeout(() => {
							this.closeModal();
							this.UserData = {};
						},150);
					});
				}).catch((e) => {
					this.loading = false;
					this.hasError = true;
					this.msg = e.response.data.message.name[0];
				});
			},
			checkUsernameIfAvaialble(event) {
				this.hasUsernameErr = false;
				this.usernameErrMsg = '';
				if( this.UserData.user_name.trim() != this.oldUsername && this.UserData.user_name != '') {
					let data = {applicant: 'any',username:this.UserData.user_name,email:this.UserData.email}
					this.checkUsername(data).then((res) => {
						if(res.data && res.data.length) {
							this.hasUsernameErr = true;
							this.usernameErrMsg = 'Username is not available';
						}
					});
				}
			},
			checkEmailIfAvaialble() {
				this.hasEmailErr = false;
				this.emailErrMsg = '';
				if( this.UserData.email.trim() != this.oldEmail && this.UserData.email != '') {
					let data = {applicant:'any',email:this.UserData.email.trim()}
					this.checkEmail(data).then((res) => {
						if(res.data && res.data.length) {
							this.hasEmailErr = true;
							this.emailErrMsg = 'Email is not available';
						}
					});
				}
			}
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
	        StringHelperMixin
	    ]
	}
</script>
