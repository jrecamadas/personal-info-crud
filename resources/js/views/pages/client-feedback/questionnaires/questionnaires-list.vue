<template>
    <div>
        <page-header :title="title"></page-header>
        <page-content :pageClass="pageClass">
	        <div class="ks-nav-body">
				<loader v-show="isProcessing" />
		        <div class="ks-nav-body-wrapper">
			        <div class="container-fluid">
						<nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">Questionnaire</li>
                            </ol>
                        </nav>
						<Can I="add" a="questionnaires">
							<div class="row">
								<div class="col-sm-12 col-md-7 pad">
									<div class="form-inline">
										<input type="text" 
											v-validate="'required'" 
											:disabled="isEditing"
											@keydown.enter="save()"
											@keyup="resetSSError" 
											@keydown.esc="questionnaireData.name = ''"
											name="name" 
											size="50"
											class="form-control mr-sm-2" 
											v-model="questionnaireData.name" 
											placeholder="Add Questionnaire" 
										/>
										<save-button 
											:options="button" 
											:disabled="!isAddValid"
											@action="save"
										>Add</save-button>
									</div>
									<span v-show="hasSSerror" class="help-block form-error">{{ ssError }}</span>
								</div>
							</div>
						</Can>
				         <data-table
					         :columns="data.columns"
					         :sortKey="sortKey"
					         :sortOrder="sortOrder"
					         :pagination="config.pagination"
							 :searchPlaceholder="searchPlaceholder"
					         @sort="sortList($event)"
					         @select="updateList($event)"
					         @search="search($event)"
					         @prev="paginate('prev')"
					         @next="paginate('next')"
					         @page="paginate($event)">
					        <!-- BEGIN QUESTIONNAIRES DATA -->
					         <tbody v-if="questionnaires.length">
						         <tr
							         :class="index % 2 == 0 ? 'even' : 'odd'"
							         v-for="(questionnaire, index) in this.questionnaires"
							         :key="questionnaire.id">
							        <td>
								         <div v-show="editOffset != index">
									         <router-link 
										         :to="{name: 'question_categories', params: {id: questionnaire.id.toString(), qName: questionnaire.name.toString() }}" 
										         class="survey-template mr-sm-2"
									         >{{ questionnaire.name }}</router-link>
								         </div>
								         <div v-show="editOffset==index">
									         <div class="form-inline">
										         <input
												     :id = "'item-user-'+index"
												     type="text"
												     v-validate="'required'" 
												     name="name" 
												     size="60"
												     class="form-control mr-sm-2" 
												     v-model="questionnaireData.updateName"
												     @keyup="resetSSErrorUpdate" 
												     @keydown.enter="updateName({id: questionnaire.id, name: questionnaireData.updateName})" 
												     @keydown.esc="cancelEditing()" 
										         />
									         </div>
									         <span v-show="hasSSerrorUpdate" class="help-block form-error">{{ ssError }}</span>
								         </div>
							         </td>
							         <td>{{ questionnaire.categoryCount }}</td>
							         <td @click="updateStatus({id:questionnaire.id, index: index})">
								         <span 
										     class="badge ks-circle badge-success no_selection cursor-pointer" 
										     title="Deactivate Questionnaire" 
										     v-if="questionnaire.isActive"
								         >Active</span>
								         <span 
										     class="badge ks-circle badge-danger no_selection cursor-pointer" 
									         title="Activate Questionnaire"
									         v-else
								         >Inactive</span>
							         </td>
							         <td style="text-align: center">
								         <div v-show="editOffset != index">
											 <Can I="update" a="questionnaires">
												<span 
													class="action-button la la-pencil cursor-pointer" 
													title="Edit Questionnaire" 
													@click="startEditing(index)"
												></span>
											 </Can>
									         <span 
											     class="action-button la la-file-text cursor-pointer" 
										         title="Preview Questionnaire" 
												 @click="previewQuestionaire(questionnaire.id)"
									         ></span>
								         </div>
								         <div v-show="editOffset==index">
									         <span 
											     class="action-button la la-check mr-sm-2 cursor-pointer"
										         title="Save" 
										         @click="updateName({id: questionnaire.id, name: questionnaireData.updateName})"
									         ></span>
									         <span 
											     class="action-button la la-close cursor-pointer" 
										         title="Cancel" 
										         @click="cancelEditing()"
									         ></span>
								         </div>
							         </td>
						         </tr>
					         </tbody>
					         <!-- END QUESTIONNAIRES DATA -->
				         </data-table>
			         </div>
		         </div>
	         </div>
         </page-content>
     </div>  
</template>
<style lang="scss" scoped>
    .pad {
	    padding-bottom: 20px;
     }
     .survey-template {
	    color: #333;
		 &:hover {
			text-decoration: underline;
		}
     }
     .action-button {
	    font-size: 20px;
		color: #25628F;
     }
	 .disable-button {
		 color: grey
	 }
	 .cursor-pointer {
		cursor: pointer;
	 }
	 .form-error {
		display: block;
		color: #b94a48;
		margin-top: 5px;
		margin-bottom: 10px;
		line-height: 140%;
	}
</style>
<script>
    // components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import Select2 from '@components/select2.vue';
	import SaveButton from '@components/form/button.vue';
	import Loader from "@components/loader.vue";

    // mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';

    import { mapActions, mapGetters } from 'vuex'

    export default {
	    data() {
		    let sortOrder = {};
		    let sortKey = 'name';
		    let columns = [
			    { label: 'Questionnaire', 		key: 'name', 				sortKey: 'name', 				width: '70%', 	sortable: false },
			    { label: 'Categories',          key: 'categoryCount', 		                         		width: '10%', 	sortable: false },
			    { label: 'Status', 				key: 'is_active', 			sortKey: 'is_active', 			width: '10%', 	sortable: false },
			    { label: 'Action', 																		width: '10%', 	sortable: false }
		     ];

		    columns.forEach(function(col) {
			    sortOrder[col.sortKey] = 'desc'
		     });
		    return {
			    title:'Survey Questionnaires',
			    pageClass: 'ks-content-nav',
			    sortKey:sortKey,
				sortOrder:sortOrder,
				searchPlaceholder: 'Search Questionnaire',
				isProcessing: false,
			    isEditing: false,
			    limit: 10,
			    open: false,
			    editOffset: -1,
			    editPost: {},
			    editPostOri: {},
			    hasSSerror: false,
			    ssError: null,
			    hasSSerrorUpdate: false,
			    questionnaireData: {
 				    id: 0,
				    name: '',
				    updateName: ''
			     },
			    data: {
				    columns:columns,
					rows: []
			     },
			    form: {
				    key: '',
				    name: '',
				    questionnaire:{}
			    },
			    validation: [
				    { path: 'name', name: 'name', rule: 'required', msg: {required: 'The name field is required'} },
			     ],
			    button: { class: 'btn btn-primary',type: 'button' }	
		     }
	     },
	    computed: {
		    ...mapGetters({
			    questionnaires:'questionnaires/questionnaire',
			    meta:'questionnaires/meta'
		    }),
		    isAddValid() {
				let valid = true;
			    _.each(this.validation, (form) => {
				    let rules = form.rule.split('|')
				    // validate accordingly
				    _.each(rules, (rule) => {
					    if (rule == 'required') {
						    if (this.isEmpty(_.get(this.questionnaireData, form.path))) {
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
			this.setSorting(`id|desc`);
		    this.reload();
	     },
	     methods : {
		    ...mapActions({
			    getQuestionnaires: 'questionnaires/getQuestionnaires',
			    saveQuestionnaire: 'questionnaires/saveQuestionnaire',
			    updateQuestionnaireStatus: 'questionnaires/updateQuestionnaireStatus'
		     }),
		     async save() {
			    this.isProcessing = true;
			    this.resetSSError();
			    this.errors.clear();
			    this.saveQuestionnaire(this.questionnaireData).then(() => {
 				    this.isProcessing = false;
				    this.$emit('success');
				    this.cancelEditing();
				    this.reload();
				    setTimeout(() => {
					    this.questionnaireData = {};
				     },150);
			     }).catch((e) => {
				    this.isProcessing = false;
				    this.hasSSerror = true;
				    this.ssError = e.response.data.message.name[0];
			     });
		     },
		    async updateStatus(data){
				let newStatus = !(this.questionnaires[data.index].isActive)
				this.questionnaires[data.index].isActive = newStatus;
				data.isActive = newStatus;
				this.isProcessing = true;
			    this.updateQuestionnaireStatus(data).then((res) => {
					this.isProcessing = false;
				    this.$emit('success');
					this.reload();
			    });
		     },
		    async startEditing(index){
				if(!this.isAddValid){
					this.editOffset = index
					this.isEditing = true;
					this.editPost = this.questionnaires[index]
					this.editPostOri = JSON.parse(JSON.stringify(this.editPost))
					this.questionnaireData.updateName = this.editPost.name
					this.$nextTick(function(){
						document.getElementById('item-user-'+this.editOffset).focus()
					}.bind(this))
				}
		    },
		    async updateName(data){
			    if(data.name == "" || data.name == this.editPost.name)
				    this.cancelEditing();
			    else {
				    this.hasSSerrorUpdate = false;
				    this.ssError = '';
				    this.saveQuestionnaire(data).then(() => {
				    	this.isProcessing = true;
					    this.$emit('success');
					    this.cancelEditing();
					    this.reload();
					    setTimeout(() => {
						    this.questionnaireData = {};
						    this.isProcessing = false;
					    },150);
				    }).catch((e) => {
					    this.isProcessing = false;
					    this.hasSSerrorUpdate = true;
					    this.ssError = e.response.data.message.name[0];
				    });
			     }
		     },
		    async cancelEditing() {
				//this.$set(this.questionnaireData, this.editOffset, this.editPostOri)
				this.isEditing = false;
			    this.editOffset = -1;
			    this.editPostOri = {};
				this.editPost = {};
				this.hasSSerror = false;
				this.hasSSerrorUpdate = false;
		     },
		    async getData() {
			    await this.getQuestionnaires({query:this.getParams()});
			    this.setPagination(this.meta.pagination);
		     },
		    async paginate(page) {
			    this.gotoPage(page);
			    this.getData();
		     },
		    async search(term) {
				this.gotoPage();
			    this.setSearch(term);
			    this.getData();
		     },
		    async sortList(key) {
			    this.sortKey = key;
			    this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
			    this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
			    this.getData();
		     },
		    async updateList(limit) {
			    this.setPaginationLimit(limit);
			    this.getData();
		     },
		    async reload() {
			    this.getData();
			    this.open = false;
		     },
		    resetSSError(event) {
			    this.hasSSerror = false;
			    this.ssError = '';
		     },
		    resetSSErrorUpdate(event) {
			    this.hasSSerrorUpdate = false;
			    this.ssError = '';
			},
			previewQuestionaire(id) {
				window.open('/survey/preview/'+ id, '_blank');
			}
	     },
	     components: {
		    Select2,
		    DataTable,
		    PageHeader,
		    PageContent,
			SaveButton,
			Loader,
	     },
	     mixins: [
		    DataTableMixin,
		    StringHelperMixin
	     ]
     }
</script>
