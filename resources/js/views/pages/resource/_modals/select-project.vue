<template>
    <modal-dialog v-show="openModal" :options="option" :title="modal_title" @close="closeDialog(false)">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!valid">{{ modal_save }}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Select a Project: </label>
                        <div class="current-status">
                            <div class="status-level">
                                <div class="status-el">
                                    <select2
                                            :value="projectsData.selected"
                                            :options="projectsData.options"
                                            :style="'width: 100%;height: 36px!important;'"
                                            @select="projectsData.selected = $event"
                                    >
                                        <option value="0">&nbsp;&nbsp;---------</option>
                                    </select2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </modal-dialog>
</template>

<style type="text/css">

</style>

<script type="text/javascript">
    //Components
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import Select2 from '@components/select2.vue';

    //Mixins
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

    //Models
    import { mapGetters, mapActions } from 'vuex';

    export default {
        props: {
            resource_data: {
                type: Object,
                required: true
            },
            assigned_resources: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                loading: false,
                modal_save: 'Assign',
                modal_title: 'Assign Resource...',
                option: {
                    width: '420px'
                },
                projectsData: {
                    selected: '0',
                    options: []
                },
                button: {
                    class: 'btn btn-primary',
                    type: 'button'
                }
            }
        },
        computed: {
            ...mapGetters({
                searched_resource: 'employeeClientProjects/resource'
            }),
            valid: function(){
                return this.projectsData.selected > 0;
            }
        },
        async created () {
            this.resource_data.clientProjects.forEach((obj) => {
                this.projectsData.options.push({id:obj.id,text:obj.project_description});
            });
        },
        methods : {
            ...mapActions({
                getResources: 'employeeClientProjects/getResources',
                searchResource: 'employeeClientProjects/searchResource',
                saveResource: 'employeeClientProjects/saveResource',
            }),
            async save() {
                this.enableLoading(true);
                await this.executeDraggedResource(
                    this.resource_data.resource_id,
                    this.resource_data.fromClient,
                    this.resource_data.toClient,
                    this.projectsData.selected
                ).then((res) => {
                    this.closeDialog(true);
                });
            },
            async executeDraggedResource(resource_id, fromClient, toClient, clientProjectId){
                let self = this;
                let success = false;

                if(fromClient === 'resources'){
                    await this.searchResource(resource_id).then((res) => {
                        if(self.searched_resource.length > 0){
                            self.updateDraggedResource(
                                parseInt(self.searched_resource[0].id),
                                parseInt(self.searched_resource[0].employee_id),
                                parseInt(clientProjectId)
                            );
                            //self.enableLoading(false);
                            success = true;
                        } else {
                            self.updateDraggedResource('', parseInt(resource_id), parseInt(clientProjectId));
                            //self.enableLoading(false);
                            success = true;
                        }
                    });
                } else { /** Client to client resource update **/
                let record = this.assigned_resources.filter(obj => obj.employee_id == resource_id);
                    if(record && record[0]){
                        await this.updateDraggedResource(
                            record[0].id,
                            parseInt(resource_id),
                            parseInt(clientProjectId)
                        ).then((res) => {
                            //self.enableLoading(false);
                            success = true;
                        });
                    }
                }
                return success;
            },
            updateDraggedResource(id, employee_id, project_id){
                return this.saveResource({
                    id: id,
                    employee_id: employee_id,
                    client_project_id: project_id,
                    deleted_at: null
                });
            },
            closeDialog(flag){
                //this.loading = false;
                this.$emit(flag ? "success" : "close");
            },
            async enableLoading(bool){
                this.loading = bool;
            },
        },
        components: {
            SaveButton,
            ModalDialog,
            Select2,
        },
        mixins: [
            StringHelperMixin,
            ModalDialogMixin
        ]
    }
</script>
