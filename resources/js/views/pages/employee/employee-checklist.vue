<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title">
        </page-header>
        <!-- END PAGE HEADER -->        
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-default"> 
                        <div class="panel-heading">A. DOCUMENT(S) TO BE SUBMITTED (ON/BEFORE THE FIRST DAY OF WORK)</div> 
                        <table class="table group-a"> 
                            <thead> 
                                <tr> 
                                    <th>#</th> 
                                    <th>Document</th>
                                    <th>Status</th> 
                                    <th>Date</th>
                                    <th>Actions</th> 
                                </tr> 
                            </thead> 
                            <tbody> 
                                <tr v-for="(check, index) in checklist.data" v-if="check.group == 'A'">
                                    <th scope="row">
                                        <i class="fa fa-check-square-o" aria-hidden="true" v-if="eChecklist(check.eChecklist, 'id')"></i>
                                        <i class="fa fa-square-o" aria-hidden="true" v-else></i>
                                    </th>
                                    <td class="document">{{ check.document }}
                                        <br/><span v-if="check.description !== null" class="help-block">{{ check.description }}</span>
                                    </td>
                                    <td v-if="eChecklist(check.eChecklist, 'pre_employment_checklist_id')">Submitted</td>
                                    <td v-else class="text-gray">Pending</td>
                                    <td v-if="eChecklist(check.eChecklist, 'created_at')">{{ dateFormat(file_created_at) }}</td>
                                    <td v-else></td>
                                    <td>
                                        <a v-if="eChecklist(check.eChecklist, 'asset_path')" :href="eChecklist(check.eChecklist, 'asset_path')" target="_blank">View</a><span class="text-gray" v-else>View</span> 
                                        <Can I="update" a="employee_checklist">| <span class="default-active-text" @click="openModals(eChecklist(check.eChecklist, 'id'),check.id)">Upload</span ></Can>
                                        <Can I="delete" a="employee_checklist">| <span class="default-active-text" v-if="eChecklist(check.eChecklist, 'id')" @click="deleteDocument(check)">Delete</span><span class="text-gray" v-else >Delete</span></Can>
                                    </td>
                                </tr>
                            </tbody> 
                        </table> 
                    </div>   
                    <div>&nbsp;</div>
                    <div class="panel panel-default"> 
                        <div class="panel-heading">B. FORMS TO BE ACCOMPLISHED AND SUBMITTED DURING THE CONTRACT SIGNING</div> 
                        <table class="table group-a"> 
                            <thead> 
                                <tr> 
                                    <th>#</th> 
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th> 
                                </tr>
                            </thead> 
                            <tbody>
                                <tr v-for="(check, index) in checklist.data" v-if="check.group == 'B'">
                                    <th scope="row">
                                        <i class="fa fa-check-square-o" aria-hidden="true" v-if="eChecklist(check.eChecklist, 'id')"></i>
                                        <i class="fa fa-square-o" aria-hidden="true" v-else></i>
                                    </th>
                                    <td class="document">{{ check.document }}
                                        <br/><span v-if="check.description !== null" class="help-block">{{ check.description }}</span>
                                    </td>
                                    <td v-if="eChecklist(check.eChecklist, 'pre_employment_checklist_id')">Submitted</td>
                                    <td v-else class="text-gray">Pending</td>
                                    <td v-if="eChecklist(check.eChecklist, 'created_at')">{{ dateFormat(file_created_at) }}</td>
                                    <td v-else></td>
                                    <td>
                                        <a v-if="eChecklist(check.eChecklist, 'asset_path')" :href="eChecklist(check.eChecklist, 'asset_path')" target="_blank">View</a><span class="text-gray" v-else>View</span> 
                                        <Can I="update" a="employee_checklist">| <span class="default-active-text" @click="openModals(eChecklist(check.eChecklist, 'id'),check.id)">Upload</span ></Can>
                                        <Can I="delete" a="employee_checklist">| <span class="default-active-text" v-if="eChecklist(check.eChecklist, 'id')" @click="deleteDocument(check)">Delete</span><span class="text-gray" v-else >Delete</span></Can>
                                    </td>
                                </tr>
                            </tbody> 
                        </table> 
                    </div>  
                    <div>&nbsp;</div>
                    <div class="panel panel-default"> 
                        <div class="panel-heading">C. DOCUMENTS TO BE SUBMITTED AND ACCOMPLISHED BEFORE THE START DATE</div> 
                        <table class="table group-a"> 
                            <thead> 
                                <tr> 
                                    <th>#</th> 
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th> 
                                </tr> 
                            </thead> 
                            <tbody> 
                                <tr v-for="(check, index) in checklist.data" v-if="check.group == 'C'">
                                    <th scope="row">
                                        <i class="fa fa-check-square-o" aria-hidden="true" v-if="eChecklist(check.eChecklist, 'id')"></i>
                                        <i class="fa fa-square-o" aria-hidden="true" v-else></i>
                                    </th>
                                    <td class="document">{{ check.document }}
                                        <br/><span v-if="check.description !== null" class="help-block">{{ check.description }}</span>
                                    </td>
                                    <td v-if="eChecklist(check.eChecklist, 'pre_employment_checklist_id')">Submitted</td>
                                    <td v-else class="text-gray">Pending</td>
                                    <td v-if="eChecklist(check.eChecklist, 'created_at')">{{ dateFormat(file_created_at) }}</td>
                                    <td v-else></td>
                                    <td>
                                        <a v-if="eChecklist(check.eChecklist, 'asset_path')" :href="eChecklist(check.eChecklist, 'asset_path')" target="_blank">View</a><span class="text-gray" v-else>View</span> 
                                        <Can I="update" a="employee_checklist">| <span class="default-active-text" @click="openModals(eChecklist(check.eChecklist, 'id'),check.id)">Upload</span ></Can>
                                        <Can I="delete" a="employee_checklist">| <span class="default-active-text" v-if="eChecklist(check.eChecklist, 'id')" @click="deleteDocument(check)">Delete</span><span class="text-gray" v-else >Delete</span></Can>
                                    </td>
                                </tr>
                            </tbody> 
                        </table> 
                    </div>
                    <div>&nbsp;</div>                                                                      
                </div>
            </div>    
        </div>
        </page-content>

        <!-- BEGIN WORK DETAIL DIALOG -->
        <document-checklist-modal v-if="open" :mid="mid" :pid="pid" :employee_id="employee_id" :openModal="open" @success="updateEmployeeChecklist" @close="closeModal"></document-checklist-modal>
        <!-- END WORK DETAIL DIALOG -->        
    </div>
</template> 


<style>
.default-active-text { 
    color: #25628F;
    text-decoration: none;
    cursor: pointer;
}

td.document {
    width: 700px;
}

.help-block {
    font-size: 11px;
    color: #979292;
}
</style>

<script>

import PageHeader from '@components/page-header.vue';
import PageContent from '@components/page-content.vue';

//Components
import ModalDialog from '@components/modal-dialog.vue';
import DocumentChecklistModal from '@views/pages/employee/_modals/document-checklist.vue';

//Mixins
import AssetMixin from '@common/mixin/AssetMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import DataTableMixin from '@common/mixin/DataTableMixin';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

// Model
import { EmployeeChecklist } from '@common/model/EmployeeChecklist';

import { mapActions, mapGetters } from 'vuex';
import _ from 'lodash';   

export default {
    data() {
        return {
            title: 'Employee Checklist',
            pageClass: 'ks-checklist',
            open: false,
            employee_id: this.$route.params.id,
            modal: {
                width: '800px',
                height: '400px'
            },
        }
    },
    computed: {
        ...mapGetters({
            checklist: 'employeeChecklists/data'
        }),
    },
    methods: {
        ...mapActions({
            getEmployeeChecklist: 'employeeChecklists/getEmployeeChecklists',
        }),
        async getData() {
           await setTimeout(() => this.getEmployeeChecklist(this.$route.params.id), 1000);
        },
        randomNumber : function(){
          return Math.floor(Math.random() * (10 - 1 + 1)) + 1;
        },
        dateFormat: function(date) {
            return (!date) ? '' : moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        },
        updateEmployeeChecklist() {
            this.closeModal();
            this.getData();
        },        
        openModals(mid, pid) {
            this.open = true;
            this.mid = mid;
            this.pid = pid;
        },     
        closeModal(){
            this.open = false;
        }, 
        deleteDocument(check) {
            const title = 'Are you sure you want to delete the file of this document?';
            const msg = `${check.document}`;
            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                .then(({ok}) => {
                    if (ok) {
                        let del = new EmployeeChecklist({id: this.eChecklist(check.eChecklist, 'id')});
                        del.delete().then((res)=>{
                            this.getData();
                        });
                    }
                });
        },
        eChecklist(check, get) 
        {
            if (typeof check !== 'undefined') {
                switch(get) {
                    case 'id': 
                        return check.data.id;
                    case 'pre_employment_checklist_id': 
                        return check.data.pre_employment_checklist_id;
                    case 'created_at': 
                        return this.file_created_at = check.data.created_at.date;
                    case 'asset_path':
                        if (typeof check.data.asset !== 'undefined')
                            return this.getAssetPath(check.data.asset.data.path, true);
                        else return false;
                    default: 
                        return false;
                }
            }
        },        
    },     
    created() {
        this.getEmployeeChecklist(this.$route.params.id);
    },
    components: {
        PageHeader,
        PageContent,
        ModalDialog,
        DocumentChecklistModal,
        ModalDialogMixin
    },
    mixins: [
        AssetMixin,
        DataTableMixin,
        EmployeeMixin,
        ModalDialogMixin,
        AlertMixin
    ]        
}    
</script>