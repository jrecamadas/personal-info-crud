import { Asset } from '@common/model/Asset';
import EDBMixin from "@common/mixin/EDBMixin";
import AlertMixin from "@common/mixin/AlertMixin";

export default {

    data() {
        return {
            ProfileCardMixin: {
                videoProfile: {
                    folder: 'profile-card',
                    assetable_id: '1',
                    type: 6,
                    assetable_type: 'profile-card',
                    name:'',
                    medium: null,
                    medium_type: 'video'
                },
                videoBanner: {
                    folder: 'profile-card',
                    assetable_id: '1',
                    type: 7,
                    assetable_type: 'profile-card',
                    name:'',
                    medium: null,
                    medium_type: 'video'
                },
                photoBanner: {
                    folder: 'profile-card',
                    assetable_id: '1',
                    type: 8,
                    assetable_type: 'profile-card',
                    name:'',
                    medium: null,
                    medium_type: 'image',
                    old_id: '',
                    old_cv: ''
                },
                fileTypes:['MP4', 'MPEG4', 'FLV', 'WAV', 'WMV', 'MOV'],
                loading6: 0,
                loading7: 0,
                loading8: 0
            }
        };
    },

    methods: {
        pcmHandleFileUpload(event, employeeId, type) {
            let uploadedFiles = event.target.files || event.dataTransfer.files;
            if (!uploadedFiles.length) {
                this.ProfileCardMixin[type].medium=null;
                return;
            } /*else if (!this.edbInArray(fname.split('.')[fname.length], this.ProfileCardMixin.fileTypes)) {
                // Prompt user that the file is invalid
                // We don't touch the medium, this is to protect what was already set during edit
                const title = 'Please select a video file with the following format [' + this.ProfileCardMixin.fileTypes.join(', ') + ']';
                const msg = `Selected: ${uploadedFiles[0].name}`;
                this.confirmDialog(title, msg, 'Close', '', 'sm');
                this.ProfileCardMixin.videoProfile.medium=null;
                event.target.value = '';
                return;
            } else if (uploadedFiles[0].size > 10485760) { // Public applicant form 10MB limit
                const title = 'File limit exceeded. Please select a resume file not more than 10MB in file size.';
                const msg = `Filename: ${uploadedFiles[0].name}`;
                this.confirmDialog(title, msg, 'Close', '', 'sm');
                this.fileUpload.medium=null;
                e.target.value = '';
                return;
            }*/

            this.ProfileCardMixin[type].name = uploadedFiles[0].name;
            this.ProfileCardMixin[type].medium = this.$refs[type].files[0];

            if(this.ProfileCardMixin[type].type == 8){
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.ProfileCardMixin[type].medium = event.target.result;
                };
                reader.readAsDataURL(uploadedFiles[0]);
            }

            let vm = this;
            setTimeout(function(){
                console.log(vm.ProfileCardMixin[type], "Data");
                vm.ProfileCardMixin['loading' + vm.ProfileCardMixin[type].type] = 1;
                vm.pcmSubmitFile(employeeId, type).then((res) => {
                    vm.ProfileCardMixin['loading' + vm.ProfileCardMixin[type].type] = 0;
                });
            }, 50);
        },
        pcmSubmitFile(returnedEmployeeId, type){

            let vm = this;
            return new Promise((resolve) => {
                vm.ProfileCardMixin[type].assetable_id = returnedEmployeeId;
                try{
                    let formData = new FormData();
                    formData.append('folder', 'profile-card');
                    formData.append('assetable_id', vm.ProfileCardMixin[type].assetable_id);
                    formData.append('type', vm.ProfileCardMixin[type].type);
                    formData.append('assetable_type', 'profile-card');
                    formData.append('name', vm.ProfileCardMixin[type].name);
                    formData.append('medium', vm.ProfileCardMixin[type].medium);
                    formData.append('medium_type', vm.ProfileCardMixin[type].medium_type);

                    let auth_token = "Bearer " + localStorage.getItem('auth_token');
                    axios.post('/api/assets',
                        formData, {
                            headers: {
                                    'Content-Type': 'multipart/form-data',
                                    'Authorization': auth_token
                                }
                        }
                    ).then((res) => {
                        console.log(res, "RESPONSE");
                        resolve(true);
                    });
                }catch(e){
                    const title = 'Error!';
                    const msg = 'An unexpected error has occurred while uploading the file. Please try again.';
                    vm.confirmDialog(title, msg, 'Close', '', 'sm');
                    resolve(false);
                }
            });
        }
    },
    components: {
        Asset
    },
    mixins: [
        EDBMixin,
        AlertMixin
    ]
}
