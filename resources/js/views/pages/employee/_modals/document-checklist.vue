<template>
    <modal-dialog v-show="openModal" :options="option" :title="modal_title" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!valid">{{ modal_save }}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label>Upload Image File: </label>
                                        <a href="#" :href="document_path+'?'+(new Date().getTime())" target="_blank" v-if="fileUpload.medium==null && document_path!=''">Upload Image</a>
                                        <span v-if="fileUpload.medium!=null" class="ks-text file-selected-indicator">New File Selected</span>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="btn btn-primary ks-btn-file">
                                            <span class="la la-cloud-upload ks-icon"></span>
                                            <span class="ks-text">Choose file</span>
                                            <input type="file" name="checklistDocument" ref="files" id="checklistDocument" accept="image/x-png,image/gif,image/jpeg" @change="handleFileUpload($event)">
                                        </label>
                                        <div>&nbsp;</div>
                                        <label><i class="fa fa-info-circle" aria-hidden="true"></i> This document is proprietary and confidential. No part of this document may be disclosed in any manner to a third party without the prior written consent of {{ organizationFullName }}.</label>
                                    </div>
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
import GenerateButton from '@components/form/button.vue';
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import Select2 from '@components/select2.vue';
import VueTagsInput from '@johmun/vue-tags-input';

//Mixins
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import DateMixin from '@common/mixin/DateMixin';

//Models
import { EmployeeChecklist } from '@common/model/EmployeeChecklist';
import { Asset } from '@common/model/Asset';
import { mapGetters } from 'vuex';

import _ from 'lodash';

export default {
    data() {
        return {
            option: {
                width: '800px'
            },
            modal_title: 'Checklist Document',
            modal_save: 'Upload',
            loading: false,
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            fileUpload: {
                folder: 'employee-checklist',
                assetable_id: '',
                type: 4,
                assetable_type: 'employee-checklist',
                name:'',
                medium: null,
                medium_type: 'image',
            },
            // document_path: 'checklist',
            document_path: '',
        }
    },
    computed: {
        ...mapGetters({
            organizationFullName: 'appSettings/getFullNameText',
        }),
        valid: function() {
            let valid = true;
            if(this.document_path == '' && this.fileUpload.medium == null){ valid = false; }
            return valid;
        },
        ...mapGetters({
            organizationFullName: 'appSettings/getFullNameText',
        }),
    },
    
    methods : {
        async save() {
            const data = {};
            this.loading = true;
            this.$set(data,'id', this.$el.getAttribute('mid'));
            this.$set(data,'employee_id', this.$el.getAttribute('employee_id'));
            this.$set(data,'pre_employment_checklist_id', this.$el.getAttribute('pid'));
            this.saveDocument(data);
        },
        handleFileUpload(e) {
            let uploadedFiles = e.target.files || e.dataTransfer.files;
            if (!uploadedFiles.length){
                this.fileUpload.medium=null;
                return;
            }

            this.fileUpload.name = uploadedFiles[0].name;
            let reader = new FileReader();
            reader.onload = (e) => {
                this.fileUpload.medium = e.target.result;
            };
            reader.readAsDataURL(uploadedFiles[0]);
        },

        saveDocument(data) {
            let checklist = data.id
                ? new EmployeeChecklist({id: data.id})
                : new EmployeeChecklist();

            return checklist.save(data).then((res) => {
                let promises = [];
                if(this.fileUpload.medium!=null){
                    this.fileUpload.assetable_id = res.data.id;
                    promises.push(this.submitFile());
                }

                this.closeDialog();
            });
        },
        submitFile() {
            this.loading = true;
            let successful = false;
            const asset = new Asset();
            asset.save(this.fileUpload).then(() => {
                successful = true;
            });
            return successful;
        },
        checkSelectedFile() {
            if(this.fileUpload.name!=''){
                let extension = this.fileUpload.name.split('.');
                if(this.fileTypes.indexOf(extension[1].toUpperCase())>=0) {
                    return true;
                }
            }
            return false;
        },
        closeDialog(){
            this.loading = false;
            this.open = false;
            this.$emit("success");
        }
    },
    components: {
        GenerateButton,
        SaveButton,
        ModalDialog,
        Select2,
        VueTagsInput
    },
    mixins: [
        StringHelperMixin,
        ModalDialogMixin,
        DateMixin
    ]
}
</script>
