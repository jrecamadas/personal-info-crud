<template>
    <modal-dialog v-show="openModal" :options="{width: '800px', height: '430px'}" :title="'Profile Photo'" @close="closeModal">
        <template slot="button">
            <button type="button" class="btn btn-info" @click="selectFile">Select File </button>
            <save-button :loading="loading" :disabled="!show" @action="save">Save</save-button>
        </template>
        <template slot="body">
            <div class="image-wrapper">
                <div class="row" v-show="show">
                    <div class="col-md-6">
                        <vue-avatar
                            :image="profile.medium"
                            :width=400
                            :height=400
                            :rotation="rotation"
                            :scale="scale"
                            :borderRadius="borderRadius"
                            ref="vueavatar"
                            @vue-avatar-editor:image-ready="onImageReady"
                            id="avatar"
                        >
                        </vue-avatar>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Zoom : {{scale}}x</label>
                            <br>
                            <input
                                type="range"
                                min=1
                                max=3
                                step=0.02
                                v-model.number='scale'
                            />
                        </div>
                        <div class="form-group">
                            <label>Rotation : {{rotation}}°</label>
                            <br>
                            <input
                                type="range"
                                min=0
                                max=360
                                step=1
                                v-model.number="rotation"
                            />
                        </div>
                        <div class="form-group">
                            <label>Radius : {{borderRadius}}px</label>
                            <br>
                            <input
                                type="range"
                                min=0
                                max=200
                                step=1
                                v-model.number="borderRadius"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script>
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import VueAvatarMixin from '@common/mixin/VueAvatarMixin';
import { mapGetters } from 'vuex';
import { Asset } from '@common/model/Asset';
import { VueAvatar } from 'vue-avatar-editor-improved'

export default {
    props: {
        photo: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            loading: false,
            show: false,
            profile: {
                folder: 'profile-photo',
                assetable_id: '',
                assetable_type: 'employees',
                medium: null,
                medium_type: 'image'
            }
        }
    },
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        })
    },
    created() {
        this.profile.assetable_id = this.employee.id;

        // load initial image
        this.profile.medium = this.photo;
    },
    components: {
        SaveButton,
        ModalDialog,
        VueAvatar
    },
    mixins: [
        ModalDialogMixin,
        VueAvatarMixin
    ],
    methods: {
        save() {
            this.loading = true;

            const asset = new Asset();
            const img = this.$refs.vueavatar.getImageScaled();

            this.profile.medium = img.toDataURL();

            asset.save(this.profile).then(() => {
                this.loading = false;
                this.$emit('success');
            });
        },
        selectFile() {
            $("#avatar input").click();
        },
        onImageReady() {
            this.show = true;
        }
    }
}
</script>
