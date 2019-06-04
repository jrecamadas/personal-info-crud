<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
		<template slot="button">
            <save-button :loading="loading" :options="button" :disabled="!isValid">Send</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div v-if="!info.hideOtherFields" class="form-group" :class="{'has-error': errors.has('user_name') || hasUsernameErr }">
                                <label>Username</label>
                                <input v-model = "userData.user_name" v-validate="username_validation" type="text" ref="user_name" name="user_name" class="form-control" @keyup="checkUsernameIfAvailable"/>
                                <span v-show="errors.has('user_name')" class="help-block form-error">{{ this.stringReplace(errors.first('user_name'),'user_name','User Name') }}</span>
                                <span v-show="hasUsernameErr" class="help-block form-error">{{ usernameErrMsg }}</span>
                            </div>
                            <div v-if="!info.hideOtherFields" class="form-group" :class="{'has-error': errors.has('email')} || hasEmailErr">
                                <label>Email Address</label>
                                <input v-model="userData.email" v-validate="email_validation" type="text" ref="email" name="email" class="form-control" @keyup="checkEmailIfAvailable"/>
                                <span v-show="errors.has('email')" class="help-block form-error">{{ this.stringReplace(errors.first('email'),'email','Email Address') }}</span>
                                <span v-show="hasEmailErr" class="help-block form-error">{{ emailErrMsg }}asdfsa</span>
                            </div>
                            <template v-if="info.hideOtherFields">
                                <template v-if="client.contacts.data.length">
                                    <div v-bind:key="index" v-for="(contact,index) in client.contacts.data" class="contact_container">
                                        <span class="custom-control custom-checkbox">
                                            <input type="checkbox" v-model="selectedEmail" :value="contact.email" :id="contact.email" class="custom-control-input"/>
                                            <label :for="contact.email" class="custom-control-label"></label>
                                            <div class="contact_info">
                                                <span>
                                                    {{ contact.name }}
                                                </span>
                                                <span>
                                                    {{ contact.email }}
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </template>
                                <template v-else>No Contacts Found</template>
                            </template>
                            <div v-if="!info.hideOtherFields" class="form-group">
                                <label>Role</label>
                                    <select2
                                        v-if="roleOptions && roleOptions.length"
                                        :options="roleOptions"
                                        :value="RoleData.id"
                                        @select="RoleData.id = $event"
                                    ></select2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped>
    span.custom-control.custom-checkbox {
        padding: 0 !important;
        display: inline-block;
    }
    .custom-control-label {
        cursor: pointer;
        position: absolute !important;
        width: 27px !important;
        height: 29px !important;
        top: 4px !important;
        left: 0 !important;
    }
    .custom-control-label::before {
        left: 0 !important;
        width: 27px;
        height: 29px;
    }
    .custom-control-label::after {
        font-size: 20px!important;
        top: 6px!important;
        left: 6px!important;
    }
    span.custom-control.custom-checkbox .contact_info{
        margin-left: 45px;
        display: flex;
        flex-direction: column;
    }
    span.custom-control.custom-checkbox .contact_info span:first-child{
        font-weight: bold;
    }
    .contact_container {
        margin: 0 auto;
        margin-bottom: 15px;
        width: 340px;
        padding: 11px;
        border: solid 1px #36784124;
    }
</style>

<script>
	//Components
	import SendInviteButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import SaveButton from '@components/form/button.vue';
    import Select2 from '@components/select2.vue';

    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

    import { Validator } from 'vee-validate';
	import { mapActions, mapGetters } from 'vuex';

	export default {
        props: {
            info: { type: Object, required: true },
            showDropdown: { type: Boolean, default: true }
        },
        data() {
            return {
                option: { height: 'auto', width: '500px', bottom: 'auto' },
                RoleData: {	id: 1},
                button: { class: 'btn btn-primary',type: 'button' },
                validation: [
                    { path: 'email', name: 'email', rule: 'required', msg: {required: 'The Email Address field is required'} },
                    { path: 'user_name', name: 'user_name', rule: 'username_required', msg: {required: 'The User Name field is required'} },
	            ],
                loading: false,
                hasEmailErr: false,
	            emailErrMsg: '',
				hasUsernameErr: false,
                usernameErrMsg: '',
                userData: {
                    id: '',
                    user_name: '',
                    email: '',
                },
                selectedEmail: [],
                email_regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            }
        },
        computed: {
            ...mapGetters({
                roleOptions: 'roles/formatted',
                client:'clients/client',
            }),
            isValid() {
                let valid = true;
                let isUsernameValid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
	                _.each(rules, (rule) => {
                        switch(rule){
                            case 'required':
                                if (this.isEmpty(_.get(this.userData, form.path)) || !this.email_regex.test(this.userData.email) ) {
                                    valid = false;
                                }
                                break;
                            case 'username_required':
                                if (this.isEmpty(_.get(this.userData, form.path))) {
                                    isUsernameValid = false;
                                } else {
                                    valid = true;
                                }
                                break;
                        }
	                });
                    if (!valid && !isUsernameValid){
                        valid=false
                    } 
                })
                if (this.hasEmailErr) valid = false;
                if (this.hasUsernameErr) valid = false;
                if (this.selectedEmail.length > 0) valid = true;

				return valid;
            },
            username_validation() {
                return this.userData.email.length ? '' : 'required';
            },
            email_validation(){
                return this.userData.user_name.length ? 'email' : 'required|email';
            }
        },
        async created() {
            await this.getRoles({});
            await this.getClient(this.info.client_id);
        },
        methods: {
			...mapActions({
                getRoles: 'roles/getRoles',
                checkUsername :'users/checkUsername',
                checkEmail :'users/checkEmail',
                getClient: 'clients/getClient'
            }),
            checkUsernameIfAvailable(event) {
				this.hasUsernameErr = false;
                this.usernameErrMsg = '';
				if( this.userData.user_name.trim() != this.oldUsername && this.userData.user_name != '') {
					let data = {applicant: 'any',username:this.userData.user_name, email:this.userData.user_name+'fullscale.io'}
					this.checkUsername(data).then((res) => {
						if(res.data && res.data.length) {
							this.hasUsernameErr = true;
							this.usernameErrMsg = 'Username is not available';
						}
					});
				}
			},
			checkEmailIfAvailable() {
				this.hasEmailErr = false;
				this.emailErrMsg = '';
				if( this.userData.email.trim() != this.oldEmail && this.userData.email != '') {
                    let data = {applicant: 'any', email: this.userData.email}
					this.checkEmail(data).then((res) => {
						if(res.data && res.data.length) {
							this.hasEmailErr = true;
							this.emailErrMsg = 'Email is not available';
						}
					});
				}
            },
        },
		components: {
	        SendInviteButton,
            ModalDialog,
            SaveButton,
            Select2
	    },
	    mixins: [
	        ModalDialogMixin,
            StringHelperMixin
	    ]
	}
</script>
