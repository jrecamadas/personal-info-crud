<template>
    <modal-dialog v-show="openModal" :title="'Interests'" @close="closeModal" :options="option">
        <template slot="button">
            <save-button :loading="loading" :disabled="!interests.length && !deletedInterests.length" @action="save">Save</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group" :class="{'has-error': tagExist.is}">
                        <vue-tags-input
                            v-model="interest"
                            :allow-edit-tags="true"
                            :tags="interests"
                            :maxlength="maxLimit"
                            @tags-changed="newInterest => interests = newInterest"
                            @before-adding-tag="addTagInterest"
                            @before-deleting-tag="deleteInterest"
                        />
                        <span v-show="tagExist.is" class="help-block form-error">{{ tagExist.message }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tags-wrapper">
                        <a href="#" v-for="(interest, index) in deletedInterests" :key="interest.text + index" @click="removeFromDeletedInterests(index); addInterest(interest)">{{ interest.text }}</a>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
.row {
    margin-top: 0;
}
.tags-wrapper {
    max-width: 100%;
    flex-wrap: wrap;
    padding: 0 5px;
    display: flex;
    flex-direction: row;
    a {
        display: inline-block;
        color: #fff;
        background-color: #ef5350;
        padding: 2px 10px;
        margin-right: 3px;
        margin: 2px;
        &:last-child {
            margin-right: 0;
        }
    }
}
</style>

<script>
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import { EmployeeInterest } from '@common/model/EmployeeInterest';
import VueTagsInput from '@johmun/vue-tags-input';
import _ from 'lodash';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            maxLimit: 30,
            loading: false,
            interest: '',
            interests: [],
            deletedInterests: [],
            tagExist: {
                is: false,
                message: '',
                ignore: false
            },
            option: {
                width: '800px'
            }
        }
    },
    created() {
        this.loadInterests();
    },
    components: {
        SaveButton,
        ModalDialog,
        VueTagsInput
    },
    mixins: [
        ModalDialogMixin,
        AlertMixin
    ],
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        })
    },
    watch: {
        employee: function() {
            this.loadInterests();
            this.deletedInterests = [];
        }
    },
    methods: {
        loadInterests() {
            this.interests = [];

            _.each(this.employee.interests.data, (({id, interest}) => {
                this.interests.push({
                    id: id,
                    text: interest
                });
            }));
        },
        save() {
            this.loading = true;

            let promises = [];

            _.each(this.interests, (interest) => {
                const DAL = interest.id ? new EmployeeInterest({id: interest.id}) : new EmployeeInterest();

                promises.push(DAL.save({
                    employee_id: this.employee.id,
                    interest: interest.text
                }));
            });

            // deleted queue
            _.each(this.deletedInterests, (q) => {
                if (q.id) {
                    const DAL = new EmployeeInterest({id: q.id});

                    promises.push(DAL.delete());
                }
            })

            Promise.all(promises).then((res) => {
                this.$emit('success');
                this.loading = false;
                this.notifyDialog('success', 'Successfully saved!');
            });
        },
        addTagInterest(interest) {
            let exist = false;

            if (!this.tagExist.ignore) {
                // check from interests list
                exist = (this.interests.filter(i => new RegExp(interest.tag.text, 'i').test(i.text))).length > 0;

                if (!exist) {
                    // check from deleted interests
                    exist = (this.deletedInterests.filter(i => new RegExp(interest.tag.text, 'i').test(i.text))).length > 0;
                    this.tagExist.message = 'Ooops! Interest found in deleted interest. You may re-add it by clicking on it.';
                } else {
                    this.tagExist.message = 'Ooops! Interest already added.';
                }
            }

            if (exist) {
                this.tagExist.is = true;

                setTimeout(() => {
                    this.tagExist.is = false;
                }, 3000);
            } else {
                interest.addTag();
                this.tagExist.is = false;
                this.tagExist.message = '';
                this.tagExist.ignore = false;
            }
        },
        deleteInterest(interest) {
            this.deletedInterests.push(interest.tag);
            interest.deleteTag();
        },
        removeFromDeletedInterests(index) {
            this.deletedInterests.splice(index, 1);
        },
        addInterest(interest) {
            this.tagExist.ignore = true;
            this.interests.push(interest);
        }
    }
}
</script>
