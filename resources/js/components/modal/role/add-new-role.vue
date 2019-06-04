<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
		<template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid || errors.has('name') || errors.has('display_name') || hasNameError || hasDisplayNameError">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('name') || hasNameError }">
                                <label>Name<span class="error">*</span></label>
                                <input type="text" ref="name" name="name" v-validate="'required|alpha'" class="form-control" v-model="roleData.name" @keyup="resetError" />
								<span v-show="errors.has('name')" class="help-block form-error">{{ errors.first('name') }}</span>
                                <span v-show="hasNameError" class="help-block form-error">{{ nameDbError }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('display_name') || hasDisplayNameError }">
                                <label>Display Name<span class="error">*</span></label>
                                <input type="text" ref="display_name" name="display_name" v-validate="'required|alpha_spaces'" class="form-control" v-model="roleData.display_name" @keyup="resetError" />
								<span v-show="errors.has('display_name')" class="help-block form-error">{{ errors.first('display_name') }}</span>
                                <span v-show="hasDisplayNameError" class="help-block form-error">{{ displayNameDbError }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" v-model="roleData.description" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script>
	//components
	import SaveButton from '@components/form/button.vue';
	import ModalDialog from '@components/modal-dialog.vue';

	//mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex'

	export default {
		props: {
			info: { type: Object, required: true}
		},
		data() {
			return {
				option: { height: 'auto', width: '500px', bottom: 'auto' },
				button: { class: 'btn btn-primary', type: 'button' },
				roleData: { id: '', name: '', display_name: '', description: ''},
				loading: false,
				hasNameError: false,
				hasDisplayNameError: false,
				nameDbError: null,
				displayNameDbError: null,
				validation: [
					{ path: 'name', name: 'name', rule: 'required', msg: {required: 'The name field is required'} },
					{ path: 'display_name', name: 'display_name', rule: 'required', msg: {required: 'The display name name field is required'} },
	            ],			
			}
		},
		computed: {
			...mapGetters({
				role: 'roles/role',
				loggedInUser: 'auth/data'
			}),
			isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
					// validate accordingly
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.roleData, form.path))) {
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
			await this.getRole(this.info.role);
			this.roleData.id = this.role.id || 0;
			this.roleData.name = this.role.name || '';
			this.roleData.display_name = this.role.display_name || '';	
			this.roleData.description = this.role.description || '';
			this.roleNameDBVal = this.role.name;
			this.roleDisplayNameDBVal = this.role.display_name;
			this.loggedInUser;
		},
		methods: {
			...mapActions({
				saveRole: 'roles/saveRole',
				getRole: 'roles/getRole',
				searchRoleByName: 'roles/searchRoleByName'
			}),
			async save() {
			     // check if role was previously added. If found, restore soft-deleted role
				await this.searchRoleByName(this.roleData.name);
			    if(this.role.length && this.role[0].deleted_at){
			        this.roleData.id = this.role[0].id;
                }
				
				this.hasNameError = false;
				this.hasDisplayNameError = false;				
				this.loading = true;
				this.errors.clear();

				this.roleData.updated_by_user = this.loggedInUser.data.id;
				
				this.saveRole(this.roleData).then(() => {
			    	this.loading = false;
					this.$emit('success');
					setTimeout(() => {
						this.closeModal();
						this.rolesData = {};
						this.notifyDialog('success', 'Successfully saved!');
					},150);
				}).catch((e) => {
					this.loading = false;
					if(e.response.data.message.name) {
						this.hasNameError = true;
						this.nameDbError = e.response.data.message.name[0];
					}
					if(e.response.data.message.display_name) {
						this.hasDisplayNameError = true;
						this.displayNameDbError = e.response.data.message.display_name[0];
					}
				});
			},
			resetError(event) {
				if(event.target.value.trim() != this.roleNameDBVal) {
					this.hasNameError = false;
					this.nameDbError = '';
				}
				if(event.target.value.trim() != this.roleDisplayNameDBVal) {
					this.hasDisplayNameError = false;
					this.displayNameDbError = '';
				}
			}
		},
		components: {
	        SaveButton,
	        ModalDialog
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
			StringHelperMixin,
			AlertMixin
	    ]
	}
</script>
