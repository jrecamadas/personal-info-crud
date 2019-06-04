<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title"></page-header>
        <!-- END PAGE HEADER -->

        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <!-------- KANBAN BOARD --------->
                        <div class="ks-page-content-body ks-projects-kanban-board">
                            <div class="ks-wrapper">

                                <!------------------------------------------------->
                                <draggable v-model="projects" class="dragColumnArea" :options="{group:'projects'}" :move="cancelDrag">
                                    <transition-group name="project-group" class="dragColumnAreaTarget ks-wrapper">
                                        <div v-for="project in projects" class="ks-column projects" :class="'ks-'+project.projectcolor" :key="project.projectid">
                                            <div class="ks-header">
                                                <span class="ks-name project-name" title="Double click to edit project name"
                                                      v-show="!project.editmode"
                                                      v-on:dblclick="project.editmode=true;forceFocus(project.projectid+'-input')">
                                                        {{project.projectname}}
                                                </span>
                                                <input class="form-control edit-form-control" :id="project.projectid+'-input'"
                                                       v-if="project.editmode"
                                                       v-model="project.projectname"
                                                       v-on:keyup.enter="project.editmode=false"
                                                       v-on:keyup.esc="project.editmode=false"
                                                       v-on:focus.self="edit_name_focus=true"
                                                       v-on:blur.self="edit_name_focus=false;controlEdit(project)"
                                                />
                                                <div class="dropdown ks-control">
                                                    <a class="btn btn-link ks-no-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="ks-icon la la-ellipsis-h"></span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                                        <a class="dropdown-item" href="#" @click="project.editmode=true;forceFocus(project.projectid+'-input')">Edit</a>
                                                        <a v-show="project.projectid!=default_project" class="dropdown-item" href="#" @click="deleteProject(project.projectid,project.projectname)">Delete</a>
                                                        <a class="dropdown-item" href="#" @click="showForm(true)">New Project</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <form class="ks-column ks-primary ks-new-list ks-form-box" v-if="project.editmode">
                                                <div class="ks-pick-color ks-column ks-new-list" v-if="project.editmode">
                                                    <div class="ks-header ks-edit-color-text">Click to change color</div>
                                                    <div class="ks-controls ks-edit-box">
                                                        <div v-for="color in newproject.colors" class="custom-control custom-radio ks-radio ks-as-checkbox ks-lg ks-edit-color" :class="'ks-'+color.value">
                                                            <input name="radio" type="radio" class="custom-control-input"
                                                                   v-model="project.projectcolor"
                                                                   :id="color.id"
                                                                   :value="color.value"
                                                                   :checked="color.value==project.projectcolor"
                                                                   v-on:keyup.enter="project.editmode=false"
                                                                   v-on:keyup.esc="project.editmode=false"
                                                                   v-on:focus.self="edit_color_focus=true"
                                                                   v-on:blur.self="edit_color_focus=false;controlEdit(project)"
                                                            >
                                                            <label class="custom-control-label" :for="color.id"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="ks-cards ui-sortable">
                                                <div class="card ks-drop-or-add">Drop card here or <a href="#">Add</a></div>

                                                <draggable v-model="project.assigned" class="dragArea" :options="{group:'developers'}">
                                                    <transition-group name="dev-group" class="dragAreaTarget">
                                                        <div v-for="assign in project.assigned" class="card panel panel-default" :key="assign.id" :class="assign.class">
                                                            <div class="card-header">
                                                                <span class="ks-name ui-sortable-handle">{{assign.name}}</span>
                                                                <div class="dropdown ks-control">
                                                                    <a class="btn btn-link ks-no-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="ks-icon la la-angle-down"></span>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                                                        <a class="dropdown-item" href="#">Edit</a>
                                                                        <a class="dropdown-item" href="#">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-block">
                                                                <div class="ks-controls">
                                                                    <span class="la la-play-circle ks-play"></span>
                                                                    <span class="ks-time">{{assign.time}}</span>
                                                                </div>
                                                                <div class="ks-info">
                                                                    <div class="progress ks-progress ks-progress-xs">
                                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 20%" v-bind:aria-valuenow="assign.progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <span class="ks-step-progress">{{assign.progress}}</span>
                                                                </div>
                                                                <div class="ks-footer">
                                                                    <span class="ks-comments">
                                                                        <span class="la la-comments ks-icon"></span>
                                                                        <span class="ks-amount">{{assign.comments}}</span>
                                                                    </span>
                                                                    <span class="ks-status">
                                                                        <span class="la la-flag ks-icon ks-color-success"></span>
                                                                        <span class="ks-date">{{assign.date}}</span>
                                                                    </span>
                                                                    <span class="ks-users">
                                                                        <img src="assets/img/avatars/ava-1.png" class="ks-avatar" width="24" height="24">
                                                                        <span class="ks-amount">+{{assign.amount}}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </transition-group>
                                                </draggable>

                                            </div>
                                        </div>
                                    </transition-group>
                                </draggable>
                                <!------------------------------------------------->

                                <form v-model="newproject" class="ks-column ks-primary ks-new-list" v-show="newproject.enabled" v-on:submit="false">
                                    <div class="form-group">
                                        <input v-model="newproject.name" class="form-control" :placeholder="newproject.placeholder">
                                    </div>
                                    <div class="ks-pick-color">
                                        <div class="ks-header">Pick a color</div>
                                        <div class="ks-controls">
                                            <div v-for="color in newproject.colors" class="custom-control custom-radio ks-radio ks-as-checkbox ks-lg" :class="'ks-'+color.value">
                                                <input v-model="newproject.selected" :id="color.id" name="radio" type="radio" class="custom-control-input" :value="color.value">
                                                <label class="custom-control-label" :for="color.id"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ks-controls">
                                        <button type="button" class="btn btn-outline-primary ks-light ks-bg-none" @click="showForm(false)">Cancel</button>
                                        <button type="button" class="btn btn-primary" @click="addNewProject" :disabled="!valid">Add Project</button>
                                    </div>
                                </form>
                                <div class="ks-column ks-new-column" v-show="!this.newproject.enabled" id="addnewproject">
                                    <a href="#" class="ks-add" @click="showForm(true)">
                                        <span class="ks-control">
                                            <span class="ks-icon la la-plus-circle"></span>
                                        </span>
                                        Add Project
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!------ END KANBAN BOARD ------->
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
    </div>
</template>

<style lang="scss" scoped>
    .dragColumnAreaTarget > div:nth-child(1){
        position: sticky;
        margin-left: 0%!important;
        left: 260px!important;
        z-index: 1;
    }
    .ks-projects-kanban-board .ks-wrapper > .ks-column form{
        margin: 0px!important;
    }
    form > div.ks-pick-color.ks-column.ks-new-list{
        width: 224px !important;
        min-width: 224px!important;
        border-radius: 2px !important;
        margin-right: 0px !important;
        align-self: flex-start !important;
        height: auto !important;
        padding: 0px !important;
        margin-left: 0px!important;
    }

    .ks-projects-kanban-board .ks-wrapper .dragColumnAreaTarget.ks-wrapper > div.ks-primary{ border-top:4px solid #25628F !important; background-color: #f5f6fa!important; }
    .ks-projects-kanban-board .ks-wrapper .dragColumnAreaTarget.ks-wrapper > div.ks-success{ border-top:4px solid #4caf50 !important; background-color: #f5fcf8!important; }
    .ks-projects-kanban-board .ks-wrapper .dragColumnAreaTarget.ks-wrapper > div.ks-info{ border-top:4px solid #42a5f5 !important; background-color: #f4fbfe!important; }
    .ks-projects-kanban-board .ks-wrapper .dragColumnAreaTarget.ks-wrapper > div.ks-purple{ border-top:4px solid #cb48bb !important; background-color: #fdf6fd!important; }
    .ks-projects-kanban-board .ks-wrapper .dragColumnAreaTarget.ks-wrapper > div.ks-warning{ border-top:4px solid #ffb300 !important; background-color: #fdfcf3!important; }
    .ks-projects-kanban-board .ks-wrapper .dragColumnAreaTarget.ks-wrapper > div.ks-danger{ border-top:4px solid #ef5350 !important; background-color: #fef7f6!important; }

    .ks-projects-kanban-board span.ks-wrapper{
        display: flex!important;
    }

    .ks-projects-kanban-board .ks-wrapper div.ks-column{
        width: 265px!important;
        min-width: 265px!important;
        border-radius: 2px!important;
        margin-right: 30px!important;
        align-self: flex-start!important;
        height: auto!important;
        padding: 20px!important;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-cards{
        margin-top: 18px!important;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-header{
        display: flex!important;;
        -webkit-box-pack: justify!important;;
        justify-content: space-between!important;;
        -webkit-box-align: center!important;;
        align-items: center!important;;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-header .ks-name{
        font-size: 14px!important;
        font-weight: 500!important;
        cursor: pointer!important;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-header > .ks-control > .btn-link{
        height: auto!important;
        margin: 0!important;
        width: auto!important;
        color: #333!important;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-header > .ks-control > .btn-link.ks-no-text > .ks-icon{
        height: auto!important;
        width: auto!important;
        padding: 0!important;
        font-size: 24px!important;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column.ks-primary > .ks-cards > .card.ks-drop-or-add{border-color: #b0b9d7!important;}
    .ks-projects-kanban-board span.ks-wrapper .ks-column.ks-success > .ks-cards > .card.ks-drop-or-add{border-color: #abebc6!important;}
    .ks-projects-kanban-board span.ks-wrapper .ks-column.ks-info    > .ks-cards > .card.ks-drop-or-add{border-color: #a6dbf9!important;}
    .ks-projects-kanban-board span.ks-wrapper .ks-column.ks-purple  > .ks-cards > .card.ks-drop-or-add{border-color: #edb6ec!important;}
    .ks-projects-kanban-board span.ks-wrapper .ks-column.ks-warning > .ks-cards > .card.ks-drop-or-add{border-color: #f2e49e!important;}
    .ks-projects-kanban-board span.ks-wrapper .ks-column.ks-danger  > .ks-cards > .card.ks-drop-or-add{border-color: #f7c1b7!important;}

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-cards > .card.ks-drop-or-add{
        display: none!important;
        text-align: center!important;
        background: transparent!important;
        padding: 15px!important;
        border-style: dashed!important;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-cards > .card.ks-drop-or-add > a{
        color: #333;
        font-weight: 500;
    }

    .ks-projects-kanban-board span.ks-wrapper .ks-column > .ks-cards > .card{
        margin: 0 0 12px 0!important;
        border: 1px solid #e1e5f0!important;
    }

    /************************************************************/
    .ks-form-box{
        margin-top:24px!important;
    }
    .ks-edit-box{
        justify-content: space-between;
        display: flex;
        -webkit-box-pack: justify;
    }
    .ks-edit-color-text{
        margin-top: 15px!important;
    }
    .ks-edit-color{
        position: relative;
        display: inline-block;
        margin-top: 12px;
    }

    .edit-form-control{
        height:26px!important;
    }
    .ks-page-content-body{
        padding-top: 0px!important;
        margin-top: 0px!important;
    }
    .developers{
        transition: all 250ms !important;
        margin-top: 10px!important;
    }
    .projects{
        cursor: move;
    }
    .dragAreaTarget{
        min-height:173px!important;
        display:block;
        position:relative;
        cursor:grab;
    }
    .la-angle-down{
        font-size:11px!important;
        height: 15px!important;
        width: 100px!important;
    }
    .transition-enter-active{
        transition: 500ms !important;
    }
    .dev-group-leave-active{
        display:none!important;
    }

    /** Color Selection positioning and fixes **/
    .ks-radio.ks-as-checkbox.ks-lg > .custom-control-label{
        left:3px!important;
    }
    .custom-control-label::before{
        left:0px!important;
    }
    .ks-radio.ks-as-checkbox > .custom-control-input:checked ~ .custom-control-label:before{
        z-index:1!important;
        top:-2px!important;
    }
    .ks-radio.ks-as-checkbox.ks-lg > .custom-control-input:checked ~ .custom-control-label:before{
        left:-3px!important;
    }
    .custom-radio > .custom-control-input:checked ~ .custom-control-label:after{
        position:relative!important;
        display:block!important;
        position:absolute!important;
        top:0px!important;
        left:0px!important;
    }
    .custom-control-label{
        cursor:pointer;
    }
</style>

<script>
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import AlertMixin from '@common/mixin/AlertMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import Draggable from 'vuedraggable';
    import jQuery from 'jquery';

    export default {
        data(){
            return {
                title: 'Resource Allocation',
                pageClass: 'ks-profile',
                newproject: {
                    enabled: false,
                    name: '',
                    placeholder: 'Project name...',
                    colors: [
                        {id: 'c1', value: 'primary'},
                        {id: 'c2', value: 'success'},
                        {id: 'c3', value: 'info'},
                        {id: 'c4', value: 'purple'},
                        {id: 'c5', value: 'warning'},
                        {id: 'c6', value: 'danger'}
                    ],
                    selected: ''
                },
                projects: [
                    {
                        projectid: 'resources',
                        projectname: 'Available Resources',
                        projectcolor: 'success',
                        editmode: false,
                        assigned: [
                            {
                                id: "employee1",
                                class: "developers",
                                name: "Elmo Ranolo",
                                time: "00:00 / 24:00",
                                progressbar: "20",
                                progress: "1/5",
                                comments: 5,
                                date: "Sept 26",
                                amount: 2,
                                editmode: false
                            },
                            {
                                id: "employee2",
                                class: "developers",
                                name: "Michael Absin",
                                time: "00:00 / 24:00",
                                progressbar: "20",
                                progress: "1/5",
                                comments: 5,
                                date: "Sept 26",
                                amount: 2
                            },
                            {
                                id: "employee3",
                                class: "developers",
                                name: "Alvin Espejo",
                                time: "00:00 / 24:00",
                                progressbar: "20",
                                progress: "1/5",
                                comments: 5,
                                date: "Sept 26",
                                amount: 2
                            },
                            {
                                id: "employee4",
                                class: "developers",
                                name: "Ryan Isaac",
                                time: "00:00 / 24:00",
                                progressbar: "20",
                                progress: "1/5",
                                comments: 5,
                                date: "Sept 26",
                                amount: 2
                            }
                        ],
                    },
                    {
                        projectid: 'project2',
                        projectname: 'FullScale-PRJ01',
                        projectcolor: 'purple',
                        editmode: false,
                        assigned: [
                            {
                                id: "employee5",
                                class: "developers",
                                name: "Raymund Ylaya",
                                time: "00:00 / 24:00",
                                progressbar: "20",
                                progress: "1/5",
                                comments: 5,
                                date: "Sept 26",
                                amount: 2
                            },
                            {
                                id: "employee6",
                                class: "developers",
                                name: "Julimar Tumulak",
                                time: "00:00 / 24:00",
                                progressbar: "20",
                                progress: "1/5",
                                comments: 5,
                                date: "Sept 26",
                                amount: 2
                            }
                        ]
                    },
                    {
                        projectid: 'project3',
                        projectname: 'Stackify-PRJ03',
                        projectcolor: 'danger',
                        editmode: false,
                        assigned: [
                            {
                                id: "employee7",
                                class: "developers",
                                name: "John Baguio",
                                time: "00:00 / 24:00",
                                progressbar: "20",
                                progress: "1/5",
                                comments: 5,
                                date: "Sept 26",
                                amount: 2
                            }
                        ]
                    },
                    {
                        projectid: 'project4',
                        projectname: 'Gigabook-PRJ01',
                        projectcolor: 'warning',
                        editmode: false,
                        assigned: []
                    }
                ],
                default_project: 'resources',
                edit_name_focus: false,
                edit_color_focus: false
            }
        },
        computed: {
            valid: function() {
                return  !this.isEmpty(this.newproject.name) && !this.isEmpty(this.newproject.selected);
            }
        },
        created() {
            this.initForm();
        },
        methods: {
            showForm(flag){
                this.newproject.enabled=flag;
                this.newproject.name='';
                this.newproject.selected='';
                let $ = jQuery;
                if(flag){
                    setTimeout(function(){
                        let leftval = $("form.ks-column").position().left;
                        $('html, body').animate({ scrollLeft: leftval }, 700);
                    },50);
                }
            },
            initForm(){
                let $ = jQuery;
                $(document).ready(function(){
                    $("form .custom-control > .custom-control-label").each(function(){
                        $(this).click(function(){
                            let color = $(this).parent().find("input").val();
                            $("form.ks-new-list").attr('class','ks-column ks-new-list ks-'+color);
                        });
                    });
                });
            },
            addNewProject(){
                let projectId = 'project'+(new Date().getTime());
                let projectName = this.newproject.name;
                let colorSelected = this.newproject.selected;
                let data = {
                    projectid: projectId,
                    projectname: projectName,
                    projectcolor: colorSelected,
                    editmode: false,
                    assigned: []
                };
                this.projects.push(data);
                this.showForm(false);
            },
            deleteProject(project_id,project_name){
                //We don't want to remove the resources column.
                if(project_id==this.default_project)return;

                let self = this;
                this.confirmDialog("Removing Project...", "Are you sure you want to remove the project \""+project_name+"\"?", "Yes", "Cancel", "sm").then((res)=>{
                    if(res.ok){
                        let thereIs = false;
                        let data = [];
                        let assigned = [];
                        self.projects.forEach((obj)=>{
                            if(obj.projectid!=project_id){
                                data.push(obj);
                            }else{
                                assigned = obj.assigned;
                                thereIs  = true;
                            }
                        });
                        if(thereIs){
                            self.projects = data;
                            assigned.forEach((obj)=>{
                                self.projects[0].assigned.push(obj);
                            });
                        }
                    }
                });
            },
            forceFocus(id){
                let $ = jQuery;
                setTimeout(function(){
                    $("#"+id).select();
                },50);
            },
            controlEdit(obj){
                let self = this;
                setTimeout(function(){
                    if(!self.edit_name_focus && !self.edit_color_focus){
                        obj.editmode=false;
                    }
                },100);
            },
            cancelDrag: function(evt){
                return evt.draggedContext.element.projectid != this.default_project && evt.relatedContext.element.projectid != this.default_project;
            }
        },
        components: {
            PageHeader,
            PageContent,
            Draggable
        },
        mixins:[
            AlertMixin,
            StringHelperMixin
        ]
    }
</script>