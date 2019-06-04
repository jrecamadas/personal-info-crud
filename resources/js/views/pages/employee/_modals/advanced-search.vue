<template>
    <modal-dialog v-show="openModal" :options="option" :title="'Advanced Search'" @close="closeModal">
        <template slot="button">
            <custom-button id="clear-button" :options="button1" @action="clearSearch">Clear</custom-button>
            <custom-button :loading="loading" :options="button" @action="updateSearch">Search</custom-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12 search-container">
                    <div class="row scroll">
                        <div class="col-sm-12">
                            <div>
                                <label>Name</label>
                                <vue-tags-input
                                    id="namesSelection"
                                    v-model="inputName"
                                    v-if="employeesFormatted"
                                    :tags="data.names"
                                    :autocomplete-always-open="displayName"
                                    :autocomplete-items="filteredNames"
                                    :add-only-from-autocomplete="true"
                                    @tags-changed="newName => data.names = newName"
                                    @before-adding-tag="beforeAddingNameTag"
                                    @before-deleting-tag="beforeDeletingNameTag"
                                    placeholder="Enter Name"
                                    :disabled="loading"
                                    @input="updateName"
                                    />
                            </div>
                        </div>
                         <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div>
                                <label>Project</label>
                                <vue-tags-input
                                    id="projectsSelection"
                                    v-model="inputProject"
                                    v-if="clientProjects"
                                    :tags="data.projects"
                                    :autocomplete-always-open="displayProject"
                                    :autocomplete-items="filteredProjects"
                                    :add-only-from-autocomplete="true"
                                    @tags-changed="newProject => data.projects = newProject"
                                    @before-adding-tag="beforeAddingProjectTag"
                                    @before-deleting-tag="beforeDeletingProjectTag"
                                    placeholder="Enter Project"
                                    :disabled="loading"
                                    @input="updateProject"
                                    />
                            </div>
                        </div>
                        <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div>
                                <label>Client</label>
                                <vue-tags-input
                                    id="clientsSelection"
                                    v-model="inputClient"
                                    v-if="clients"
                                    :tags="data.clients"
                                    :autocomplete-always-open="displayClient"
                                    :autocomplete-items="filteredClients"
                                    :add-only-from-autocomplete="true"
                                    @tags-changed="newClient => data.clients = newClient"
                                    @before-adding-tag="beforeAddingClientTag"
                                    @before-deleting-tag="beforeDeletingClientTag"
                                    placeholder="Enter Client"
                                    :disabled="loading"
                                    @input="updateClient"
                                    />
                            </div>
                        </div>
                        <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div>
                                <label>Skill</label>
                                <vue-tags-input
                                    id="skillsSelection"
                                    v-model="inputSkill"
                                    v-if="skills"
                                    :tags="data.skills"
                                    :autocomplete-always-open="displaySkill"
                                    :autocomplete-items="filteredSkills"
                                    :add-only-from-autocomplete="true"
                                    @tags-changed="newSkill => data.skills = newSkill"
                                    @before-adding-tag="beforeAddingSkillTag"
                                    @before-deleting-tag="beforeDeletingSkillTag"
                                    placeholder="Enter Skill"
                                    :disabled="loading"
                                    @input="updateSkill"
                                    />
                            </div>
                        </div>
                        <label>&nbsp;</label>
                        <div class="col-sm-12">
                            <div>
                                <label>Location</label>
                                <vue-tags-input
                                    id="locationsSelection"
                                    v-model="inputlocation"
                                    v-if="empLocation"
                                    :tags="data.locations"
                                    :autocomplete-always-open="displayLocation"
                                    :autocomplete-items="filteredLocations"
                                    :add-only-from-autocomplete="true"
                                    @tags-changed="newLocation => data.locations = newLocation"
                                    @before-adding-tag="beforeAddingLocationTag"
                                    @before-deleting-tag="beforeDeletingLocationTag"
                                    placeholder="Enter Location"
                                    :disabled="loading"
                                    @input="updateLocation"
                                    />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style scoped>
.search-container {
    padding:5px 50px 35px;
    height: 430px;
}

#clear-button {
    margin-right:6px;
}
</style>
<style>
    .search-container .input {
        max-height: 57px;
        overflow-y: auto;
    }
    .search-container .autocomplete {
        max-height: 100px;
        overflow-y: auto;
    }
</style>

<script type="text/javascript">
import { Validator } from 'vee-validate';
import _ from 'lodash';
import $ from 'jquery';

//Components
import CustomButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import VueTagsInput from '@johmun/vue-tags-input';

//Mixins
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

//Modal
import { Employee } from '@common/model/Employee';
import { User } from '@common/model/User';

import { mapActions, mapGetters } from 'vuex';

export default {
    props: {
        selectedNames: Array,
        selectedProjects: Array,
        selectedClients: Array,
        selectedSkills: Array,
        selectedLocations: Array
    },
    data() {
        return {
            option: {
                height: '540px',
                width: '650px',
                bottom: 'auto'
            },
            data: {
                names: [],
                projects: [],
                skills: [],
                locations: [],
                clients: []
            },
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            button1:{
                class: 'btn btn-success',
                type: 'button'
            },
            loading: false,
            inputName: '',
            inputProject: '',
            inputClient: '',
            inputSkill: '',
            inputlocation: '',
            displayName: false,
            displayProject: false,
            displaySkill: false,
            displayLocation: false,
            displayClient: false
        }
    },
    async created () {
        this.loading = true;
        this.getData();
    },
    computed: {
        ...mapGetters({
            clients: 'clients/formatted_with_name',
            clientProjects: 'clientProjects/formatted',
            employeesFormatted: 'employees/formatted',
            skills: 'skills/formatted',
            empLocation: 'empLocation/formatted'
        }),
        //These computed functions retrieves the dropdown choices based on the user input
        filteredNames: function() {
            return this.getUnique(this.employeesFormatted,'text').filter(s => s.text.toUpperCase().includes(this.inputName.toUpperCase()));
        },
        filteredClients: function() {
            return this.getUnique(this.clients,'text').filter(s => s.text.toUpperCase().includes(this.inputClient.toUpperCase()));
        },
        filteredProjects: function() {
            return this.getUnique(this.clientProjects,'text').filter(s => s.text.toUpperCase().includes(this.inputProject.toUpperCase()));
        },
        filteredSkills: function() {
            return this.getUnique(this.skills,'text').filter(s => s.text.toUpperCase().includes(this.inputSkill.toUpperCase()));
        },
        filteredLocations: function() {
            return this.getUnique(this.empLocation,'text').filter(s => s.text.toUpperCase().includes(this.inputlocation.toUpperCase()));
        }
    },
    methods : {
        ...mapActions({
            getClientProjects : 'clientProjects/getClientProjects',
            //getEmpLocation: 'empLocation/getEmployeeLocations'
        }),
        updateName(value) {
            if(value) {
                this.displayName = true;
            }
            else {
                this.displayName = false;
            }
        },
        updateProject(value) {
            if(value) {
                this.displayProject = true;
            }
            else {
                this.displayProject = false;
            }
        },
        updateClient(value) {
            if(value) {
                this.displayClient = true;
            }
            else {
                this.displayClient = false;
            }
        },
        updateSkill(value) {
            if(value) {
                this.displaySkill = true;
            }
            else {
                this.displaySkill = false;
            }
        },
        updateLocation(value) {
            if(value) {
                this.displayLocation = true;
            }
            else {
                this.displayLocation = false;
            }
        },
        async getData(){
            await this.getClientProjects({query: {take: 9999}});
            this.clientProjects.push({'id':'-1', 'text':'Unassigned'});
            this.data.names = this.selectedNames;
            this.data.clients = this.selectedClients;
            this.data.projects = this.selectedProjects;
            this.data.skills = this.selectedSkills;
            this.data.locations = this.selectedLocations;
            this.loading = false;
        },

        //This function clears the selected data back to zero
        clearSearch(){
            this.data.names = [];
            this.data.projects = [];
            this.data.skills = [];
            this.data.locations = [];
            this.data.clients = [];
        },

        //This function returns the data the user selected back to the datatable component
        updateSearch(){
            this.$emit('success', this.data.names, this.data.projects, this.data.skills, this.data.locations, this.data.clients);
            this.$emit('close');
        },

        //These functions are for adding/deleting tags in the input field
        beforeAddingNameTag(obj){
            if($('#namesSelection').children('.autocomplete').length){
                obj.addTag();
            }
        },

        beforeDeletingNameTag(obj){
            obj.deleteTag();
        },

        beforeAddingProjectTag(obj){
            if($('#projectsSelection').children('.autocomplete').length){
                obj.addTag();
            }
        },

        beforeDeletingProjectTag(obj){
            obj.deleteTag();
        },

        beforeAddingClientTag(obj){
            if($('#clientsSelection').children('.autocomplete').length){
                obj.addTag();
            }
        },

        beforeDeletingClientTag(obj){
            obj.deleteTag();
        },

        beforeAddingSkillTag(obj){
            if($('#skillsSelection').children('.autocomplete').length){
                obj.addTag();
            }
        },

        beforeDeletingSkillTag(obj){
            obj.deleteTag();
        },

        beforeAddingLocationTag(obj){
            if($('#locationsSelection').children('.autocomplete').length){
                obj.addTag();
            }
        },

        beforeDeletingLocationTag(obj){
            obj.deleteTag();
        },
    },
    components: {
        CustomButton,
        VueTagsInput,
        ModalDialog
    },
    mixins: [
        EmployeeMixin,
        StringHelperMixin,
        ModalDialogMixin
    ]
}
</script>
