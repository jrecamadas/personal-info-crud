<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
		<template slot="button">
            <save-button :loading="loading" :options="button" @action="save">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="assign-project-input form-group">
                        <label>Projects</label>
                        <vue-tags-input
                            id="projectsSelection"
                            v-model="project"
                            v-if="projects"
                            :tags="data.projects"
                            :autocomplete-items="filteredProjects"
                            :autocomplete-always-open="displayAutoComplete"
                            :add-only-from-autocomplete="true"
                            @tags-changed="newProject => data.projects = newProject"
                            @before-adding-tag="beforeAddingProject"
                            @before-deleting-tag="beforeDeletingProject"
                            placeholder="Enter Project"
                            :disabled="loading"
                            @input="updateValue"/>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
    .modal-backdrop .modal {
        width: 650px!important;
    }
    .assign-project-input .autocomplete {
        max-height: 140px;
        overflow-y: auto;
        position: relative!important;
    }
</style>

<script>
	import _ from 'lodash';
    import $ from 'jquery';

	//Components
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
	import ModalDialog from '@components/modal-dialog.vue';
    import VueTagsInput from '@johmun/vue-tags-input';

	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex';

	export default {
		components: {
	        GenerateButton,
	        SaveButton,
            ModalDialog,
            VueTagsInput
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
            StringHelperMixin,
            AlertMixin
	    ],
		props: {
			info: { type: Object, required: true }
		},
		data() {
			return {
				option: { height: 'auto', width: '500px', bottom: 'auto' },
	            button: { class: 'btn btn-primary',type: 'button' },
	            loading: false,
                project: '',
                data: {
                    projects: []
                },
                deleted: {
                    projects: []
                },
                projectIncludes: [
                    'clientProject',
                    'employee'
                ],
                displayAutoComplete: false
			}
		},
		computed: {
            ...mapGetters({
                projects: 'clientProjects/formatted',
                currentProjects: 'employeeClientProjects/data',
            }),
            filteredProjects: function() {
                return this.projects.filter(s => s.text.toUpperCase().includes(this.project.toUpperCase()));
            }
		},
		async created() {
            this.loading = true;
            await this.fetchProjects({
				employee: this.info.employee,
				include: this.projectIncludes.join(",")
            });
            await this.getProjects({query: { take: 9999 }});
            _.each(this.currentProjects, (s)=>{
                this.data.projects.push({
                    id: s.client_project_id,
                    text: s.clientProject.data.project_name,
                });
            });
            this.loading = false;
		},
		methods: {
            ...mapActions({
                getProjects: 'clientProjects/getClientProjects',
                saveEmployeeProjects: 'employeeClientProjects/saveResource',
                fetchProjects: 'employeeClientProjects/getProjectsOfResource',
                deleteEmployeeProjects: 'employeeClientProjects/deleteResource',
            }),
            save() {
                this.loading = true;
                 let promises = [];

                _.each(this.data.projects, (project) => {
                    let exists = this.currentProjects.filter(current => current.client_project_id == project.id && current.employee_id == this.info.employee);
                    if(!exists.length) {
                        promises.push(this.saveEmployeeProjects({
                            client_project_id : project.id,
                            employee_id: this.info.employee
                        }));
                    }
                });

                _.each(this.deleted.projects, (project) => {
                    promises.push(this.deleteEmployeeProjects(project.id));
                });

                Promise.all(promises).then((res) => {
                    this.data.projects = [];
                    this.deleted.projects = [];
                    this.closeDialog();
                    this.notifyDialog('success', 'Successfully saved!');
                });
            },
            updateValue(value) {
                if(value) {
                    this.displayAutoComplete = true;
                }
                else {
                    this.displayAutoComplete = false;
                }
            },
            beforeDeletingProject(obj) {
                if(obj.tag){
                    const project = this.currentProjects.filter(project => project.client_project_id == obj.tag.id);
                    if(project.length) {
                        this.deleted.projects.push({
                            id: project[0].id
                        });
                    }
                }
                
                obj.deleteTag();
            },
            beforeAddingProject(obj){
                if($('#projectsSelection').children('.autocomplete').length){
                    obj.addTag();
                }
            },
            closeDialog(){
                this.loading = false;
                this.open = false;
                this.$emit("success");
            }
		}
	}
</script>
