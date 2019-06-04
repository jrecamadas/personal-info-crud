<template>
    <modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!valid">{{ modal_save }}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="add-resource-input form-group">
                        <label>Resources</label>
                        <vue-tags-input
                            id="resourcesSelection"
                            v-model="resource"
                            v-if="employees"
                            :tags="data.resources"
                            :delete-on-backslash="false"
                            :autocomplete-items="filteredResources"
                            :autocomplete-always-open="displayAutoComplete"
                            :add-only-from-autocomplete="true"
                            @tags-changed="addResourceArr"
                            @before-adding-tag="beforeAddingResource"
                            @before-deleting-tag="beforeDeletingResource"
                            placeholder="Search Resources..."
                            :disabled="loading"
                            @input="updateValue"
                        /> 
                    </div>
                    <hr/>
                </div>
                <div class="col-sm-12">
                    <div class="form-group resources-scroll">
                        <div class="card mt-2" v-for="(res, i) in data.resources">
                            <div class="card-body">
                                <span class="float-right" style="cursor:pointer" @click="removeResource(i, res.id )">X</span>
                                <h5 class="card-title mb-0">{{res.text}}</h5>
                                <div>{{ employeePosition[res.employee_id] }}</div>
                            </div>
 
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>
<style scoped>
    .card-body {
        padding: 9px 20px 9px 11px;
    }
    hr {
        background-color: #dedbdb;
    }
</style>
<style>
    .add-resource-input > .vue-tags-input .tag.valid, .add-resource-input > .vue-tags-input .tag.invalid {
        display: none;
    }
    .v-dialog.active, .v-dialog:target {
        z-index: 10000 !important;
    }
    .resources-scroll {
        min-height: 70px;
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .resources-form {
        margin-top: 1em;
    }
    .add-resource-input .autocomplete {
        max-height: 130px;
        overflow-y: auto;
        position: absolute;
    }
</style>
<script type="text/javascript">
    import _ from 'lodash';
    import $ from 'jquery';

    //Components
    import GenerateButton from '@components/form/button.vue';
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';

    //Mixins
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import DatePickerMixin from '@common/mixin/DatePicker';
    import AlertMixin from '@common/mixin/AlertMixin';
    import EmployeeMixin from '@common/mixin/EmployeeMixin';

    import VueTagsInput from '@johmun/vue-tags-input';
    import FlatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    import { mapActions, mapGetters } from 'vuex';

    export default {
        props: {
            info: { type: Object, required: false}
        },
        data() {
            return {
                option: {
                    height: 'auto',
                    width: '600px',
                    bottom: 'auto'
                },
                title: '',
                modal_save : 'Save',
                loading: false,
                button: {
                    class: 'btn btn-primary',
                    type: 'button'
                },
                toExclude: '',
                resource: '',
                data: {
                    resources: []
                },
                deleted: {
                    resources: []
                },
                employeeList: [],
                employeePosition: [],
                include: ['employee'],
                displayAutoComplete: false
            }
        },
        async created() {
            this.loading = true;
            await this.getEmployees({query: {take: 100000, include: 'positions'}});
            _.each(this.employees, (s)=>{
                this.employeeList.push({
                    employee_id: s.id,
                    text: s.name,
                });
                this.employeePosition[s.id] = this.position(s.positions.data);
            });
            await this.getResourcesByProject({query: {take: 9999, project_id: this.info.project_id, orderBy: 'last_name', include: this.include.join(',') }});
            _.each(this.resources, (s)=>{
                this.data.resources.push({
                    id: s.id,
                    employee_id: s.employee_id,
                    text: s.employee.data.name,
                    role: s.role,
                    start_date: s.start_date,
                    end_date: s.end_date
                });
            });
            this.loading = false;
        },
        computed: {
            ...mapGetters({
                employees: 'employees/data',
                resources: 'employeeClientProjects/data'
            }),
            filteredResources: function() {
                return this.employeeList.filter(s => s.text.toUpperCase().includes(this.resource.toUpperCase()));
            },
            valid: function() {
                let valid = true;

                return valid;
            }
        },
        methods : {
        ...mapActions({
            getEmployees: 'employees/getEmployees',
            saveResource: 'employeeClientProjects/saveResource',
            deleteResource: 'employeeClientProjects/deleteResource',
            getResources: 'employeeClientProjects/getResources',
            getResourcesByProject: 'employeeClientProjects/getResourcesByProject'
        }),
        save() {
            this.loading = true;
            let promises = [];

            _.each(this.data.resources, (resource, key) => {
                promises.push(this.saveResource({
                    id:resource.id, 
                    employee_id:resource.employee_id, 
                    client_project_id:this.info.project_id, 
                    role:resource.role, 
                    start_date:resource.start_date, 
                    end_date:resource.end_date
                }));
            });

            _.each(this.deleted.resources, (resource, key) => {
                promises.push(this.deleteResource(resource.id));
            });

            Promise.all(promises).then((res) => {
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
        addResourceArr(value){
            let row = value[value.length - 1];
            value.splice(value.length-1,1);
            value.unshift(row);
            this.data.resources = value;
        },
        beforeDeletingResource(obj) {
            const resource = this.resources.filter(resource => resource.id == obj.tag.id);
            if(resource.length) {
                this.deleted.resources.push({
                    id: resource[0].id
                });
            }
            obj.deleteTag();
        },
        beforeAddingResource(obj){
            if($('#resourcesSelection').children('.autocomplete').length){
                obj.addTag();
            }
        },
        closeDialog(){
            this.$emit("success");
        },
        removeResource(i,id){
            const resource = this.resources.filter(resource => resource.id == id);
            if(resource.length) {
                this.deleted.resources.push({
                    id: resource[0].id
                });
            }
            this.data.resources.splice(i,1);
        }
        },
        components: {
            GenerateButton,
            SaveButton,
            ModalDialog,
            FlatPickr,
            VueTagsInput
        },
        mixins: [
            StringHelperMixin,
            DatePickerMixin,
            ModalDialogMixin,
            AlertMixin,
            EmployeeMixin
        ]
    }
</script>
