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
                                <input type="text" v-validate="'required'" ref="firstName" name="name" class="form-control" v-model="skillsData.name" @keyup="resetSSError"/>
                                <span v-show="errors.has('name')" class="help-block form-error">{{ errors.first('name') }}</span>
                                <span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea v-validate="'required'" name="description" class="form-control" v-model="skillsData.description" rows="5"></textarea>
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
	            skillsData: {id: '', name: '',description: ''},
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput : false,
	            validation: [
	                { path: 'name', name: 'name', rule: 'required', msg: {required: 'The name field is required'} },
	            ],
	            hasSSerror: false,
	            ssError: null,
	            skillNameDBVal:''
			}
		},
		computed: {
			...mapGetters({
				skill:'skills/skill',
			}),
			isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
					// validate accordingly
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.skillsData, form.path))) {
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
			await this.fetchSkill(this.info.skill);
			this.skillsData.name = this.skill.name || '';
			this.skillsData.description = this.skill.description || '';
			this.skillsData.id = this.skill.id || 0;
			this.skillNameDBVal = this.skill.name;
		},
		methods: {
			...mapActions({
				saveSkill: 'skills/saveSkill',
				fetchSkill: 'skills/getSkill',
                searchSkillByName: 'skills/searchSkillByName'
			}),
			async save() {
				this.loading = true;
			    // This will check if the skill was previously added. When it has, this will restore the soft-deleted
			    await this.searchSkillByName(this.skillsData.name);
			    if(this.skill.length && this.skill[0].deleted_at){
			        this.skillsData.id = this.skill[0].id;
                }

				this.hasSSerror = false;
				this.ssError = '';
				this.errors.clear();
				this.saveSkill(this.skillsData).then(() => {
					this.$emit('success');
					setTimeout(() => {
						this.closeModal();
			    		this.loading = false;
						this.skillsData = {};
						this.notifyDialog('success', 'Successfully saved!');
					},150);
				}).catch((e) => {
					this.loading = false;
					this.hasSSerror = true;
					this.ssError = e.response.data.message.name[0];
				});
			},
			resetSSError(event) {
				if(event.target.value.trim() != this.skillNameDBVal) {
					this.hasSSerror = false;
					this.ssError = '';
				}
			}
		},
		components: {
	        GenerateButton,
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
