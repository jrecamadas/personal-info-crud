<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal" :closeIsDisabled="isDisabled">
		<template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid || isDisabled">Save</save-button>
        </template>
        <template slot="body">
            <div class="ks-tabs-container ks-tabs-default ks-tabs-no-separator">
                <ul class="nav ks-nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link  active show" href="#" data-toggle="tab" data-target="#tab1">Account Info</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1" role="tabpanel">
                        <div class="form-group" :class="{'has-error': errors.has('user_name') || hasUsernameErr }">
                            <label>Username</label>
                            <input v-model = "userData.user_name" type="text" ref="user_name" name="user_name" class="form-control" @keyup="checkUsernameIfAvailable"/>
                            <span v-show="errors.has('user_name')" class="help-block form-error">{{ errors.first('user_name') }}</span>
                            <span v-show="hasUsernameErr" class="help-block form-error">{{ usernameErrMsg }}</span>
                        </div>
                        <div class="form-group" :class="{'has-error': errors.has('email')} || hasEmailErr">
                            <label>Email Address<span class="error">*</span></label>
                            <input v-model="userData.email" v-validate="'required|email'" type="text" ref="email" name="email" class="form-control" @keyup="checkEmailIfAvailable"/>
                            <span v-show="errors.has('email')" class="help-block form-error">{{ this.stringReplace(errors.first('email'),'email','Email Address') }}</span>
                            <span v-show="hasEmailErr" class="help-block form-error">{{ emailErrMsg }}</span>
                        </div>
						<div class="form-group">
                            <label>Password</label>
                            <input v-model="userData.password" v-validate="''" type="password" ref="password" name="password" class="form-control"/>
                            <span v-show="false" class="help-block form-error">{{ }}</span>
                        </div>
						<div class="form-group">
                            <label>Confirm Password</label>
                            <input v-model="confirm_pass" v-validate="''" type="password" ref="confirm_pass" name="confirm_pass" class="form-control"/>
                            <span v-show="confirm_pass_error" class="error help-block form-error">Please confirm Password</span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped>
    .fs-accordion {
        padding: 0 0 15px;
    }
    .fs-accordion .card.panel .card-header .ks-text {
        color: white;
    }
    .fs-accordion .card.panel .card-header {
        background-color: #008240;
    }
    .fs-accordion .fs-accordion-content {
        padding: 0 !important;
        overflow-y: auto;
        /* height: 400px; */
        max-height: 245px;
        overflow-x: hidden;
    }
    .fs-accordion .fs-accordion-content::-webkit-scrollbar {
        width: 8px;
    }
    .fs-accordion .fs-accordion-content::-webkit-scrollbar-thumb {
        background-color: #e2e2e2;
        outline: 1px solid slategrey;
    }
    span.custom-control.custom-checkbox {
        padding: 0 !important;
        width: 18px !important;
        height: 18px !important;
        display: inline-block;
    }
    .custom-control-label {
        position: absolute !important;
        width: 18px !important;
        height: 18px !important;
        top: 0 !important;
        left: 0 !important;
    }
    .custom-control-label::before {
        left: 0 !important;
    }
    .table-striped tbody tr{
        background-color: #ffffff!important;
    }
    div.dataTables_wrapper table.dataTable.table-bordered td, 
    div.dataTables_wrapper table.dataTable.table-bordered th {
        border: 0!important;
    }
    .fs-accordion {
        padding: 0!important;
    }
</style>

<style>
    .modal div.dataTables_wrapper table.dataTable.table-bordered th {
        border: 0;
        border-bottom: solid 1px #dddfe0;
    }
    .modal div.dataTables_wrapper table.dataTable.table-bordered th:not(:first-child) {
        text-align: center;
    }
</style>

<script>
	import _ from 'lodash';
	//Components
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
	import DataTable from '@components/datatable.vue'
	import Select2 from '@components/select2.vue';
    import AccordionMixin from '@common/mixin/AccordionMixin';
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    
    import { Validator } from 'vee-validate';
	import { mapActions, mapGetters } from 'vuex';
	export default {
		props: {
			info: { type: Object, required: true }
		},
		data() {
            let columns = [
                { label: 'Permission', key: 'permission', sortKey: 'permission', width: '40%' },
                { label: 'View', key: 'view', sortKey: 'view', width: '15%' },
	            { label: 'Add', key: 'add', sortKey: 'add', width: '15%'},
                { label: 'Edit', key: 'edit', sortKey: 'edit', width: '15%'},
                { label: 'Delete', key: 'delete', sortKey: 'delete', width: '15%'},
	        ];
			return {
                valid: false,
				option: { height: 'auto', width: '600px', bottom: 'auto' },
	            button: { class: 'btn btn-primary',type: 'button' },
                loading: false,
                validation: [
	                { path: 'email', name: 'email', rule: 'required', msg: {required: 'The email field is required'} },
	            ],
                data: {
					columns:columns,
					rows: []
                },
                userData: {
                    id: '',
                    user_name: '',
                    email: '',
					updated_by_user_id: '',
					password: '',
				},
				confirm_pass: '',
				confirm_pass_error: false,
                oldUsername: '',
				oldEmail: '',
                isNew: false,
                hasEmailErr: false,
	            emailErrMsg: '',
				hasUsernameErr: false,
                usernameErrMsg: '',
                isDisabled: false
	        }
		},
		computed: {
			...mapGetters({
                user: 'users/user',
                loggedInUser: 'auth/data'
            }),
            isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
					// validate accordingly
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.userData, form.path))) {
	                            valid = false;
	                            return;
	                        }
	                    }
	                });
	                if (!valid) return;
                })
                if (this.hasEmailErr) return;
	            if (this.hasUsernameErr) return;
				return valid;
			}
		},
		async created() {
            var self = this;
            await this.fetchUser(this.info.user);
            this.userData.user_name = this.user.user_name || '';
            this.userData.email = this.user.email || '';
            this.userData.id = this.user.id || 0;
            this.oldUsername = this.user.user_name || '';
            this.oldEmail = this.user.email || '';
        },
		methods: {
			...mapActions({
                fetchUser: 'users/getUser',
                saveUser: 'users/saveUser',
                checkUsername :'users/checkUsername',
                checkEmail :'users/checkEmail',
            }),
            async save() {
				this.loading = true;
                this.errors.clear();
				this.userData.updated_by_user_id = this.loggedInUser.data.id;
				let flag = false;
				
				if(this.userData.password) {
					if(this.userData.password == this.confirm_pass) {
						flag = true;
					} else {
						this.confirm_pass_error =  true;
						flag = false;
						this.loading = false;
					}
				} else {
					flag = true;
				}
				
				if(flag) { 
					this.saveUser(this.userData).then(() => {
						this.loading = false;
						this.$emit('success');
						setTimeout(() => {
							this.closeModal();
                            this.userData = {};
                            this.notifyDialog('success', 'Successfully saved!');
						},150);
					}).catch((e) => {
						this.loading = false;
					});
				} else {
					this.loading = false;
				}
            },
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
	        GenerateButton,
	        SaveButton,
	        ModalDialog,
            Select2,
            DataTable
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
            StringHelperMixin,
            AccordionMixin,
            AlertMixin
	    ]
	}
</script>