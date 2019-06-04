<template>
	<modal-dialog v-show="openModal" :options="option" :title="form.name" @close="closeModal">
		<template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid">{{form.name}}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('name') || hasSSerror }">
                                <label>Name<span class="error">*</span></label>
                                <input type="text" ref="firstName" name="name" class="form-control" v-model="statusData.name" @keyup="resetSSError"/>
								<span v-show="errors.has('name')" class="help-block form-error">{{ errors.first('name') }}</span>
                                <span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea  class="form-control" rows="5" v-model="statusData.description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script>
	//Components
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
	import ModalDialog from '@components/modal-dialog.vue';

	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex';
    import _ from 'lodash';

	export default {
        props: {
            info: { type: Object, required: false},
            form: { type: Object, required: false},
        },
		data() {
			return {
				valid:false,
				option: { height: 'auto', width: '500px', bottom: 'auto' },
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
	            manualInput : false,
	            hasSSerror: false,
	            ssError: null,
                statusNameDBVal:'',
                statusData: {
                	id: 0,
                   	name: '',
                   	description: ''
                },

			}
		},
		computed: {
			...mapGetters({
                status: 'statuses/status',
			}),
			isValid() {
				let valid = true;
				_.each(this.validation, (form) => {
					let rules = form.rule.split('|')
					// validate accordingly
	                _.each(rules, (rule) => {
	                    if (rule == 'required') {
	                        if (this.isEmpty(_.get(this.statusData, form.path))) {
	                            valid = false;
	                            return;
	                        }
	                    }
	                });

	                if (!valid) return;
				});
				
                if(this.statusData.name == '') { valid = false; }
				return valid;
			}
		},
        async created() {
            if (this.info != null && this.info.id) {
                await this.getStatus(this.info.id);
                this.statusData.name = this.status.name;
                this.statusData.description = this.status.description;
			}
			
		    this.statusData.id = this.info.id || 0;
		},
		methods: {
			...mapActions({
                getStatuses: 'statuses/getStatuses',
                getStatus: 'statuses/getStatus',
                saveStatus: 'statuses/saveStatus',

			}),
			async save() {
				this.loading = true;
				this.hasSSerror = false;
				this.ssError = '';
                this.errors.clear();
				await this.saveStatus(this.statusData).then(() => {
					this.$emit('success');
					setTimeout(() => {
						this.closeModal();
			    		this.loading = false;
						this.StatusData = {};
						this.notifyDialog('success', 'Successfully saved!');
					},150);
				}).catch((e) => {
					this.loading = false;
					this.hasSSerror = true;
					this.ssError = e.response.data.message.name[0];
				});
			},
			resetSSError(event) {
				if(event.target.value.trim() != this.statusNameDBVal) {
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
