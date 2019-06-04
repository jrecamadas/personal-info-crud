<template>
    <modal-dialog v-show="openModal" :title="'Government No'" @close="closeModal" :options="option">
        <template slot="button">
            <save-button :loading="loading" :disabled="errors.count() > 0" @action="save">Save</save-button>
        </template>
        <template v-if="this.agencies" slot="body">
            <div class="row">
                <div v-for="(model, index) in formData" :key="index" class="col-sm-12 col-md-6">
                    <div class="form-group" :class="{'has-error': errors.has(model.name)}">
                        <label>{{ model.label }}</label>
                        <input 
                            v-validate="'length:' + model.mask.length" 
                            v-model="model.value" 
                            v-mask="model.mask" 
                            :name="model.name" 
                            :placeholder="model.placeholder" 
                            :maxlength="model.mask.length" 
                            type="tel" 
                            class="form-control" />
                        <span v-show="errors.has(model.name)" class="help-block form-error">
                            Invalid ID. {{ 
                                replaceText(
                                    replaceText(errors.first(model.name), String(model.mask.length), validLength(model.mask)),
                                    model.name,
                                    model.label + " ID"
                                ) 
                            }} 
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script>
import ModalDialog from '@components/modal-dialog.vue';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import SaveButton from '@components/form/button.vue';
import { GovernmentId } from '@common/model/GovernmentId';
import { mapActions, mapGetters } from 'vuex';
import _ from 'lodash'
import { mask } from 'vue-the-mask';

export default {
    directives: {
        mask
    },
    data() {
        return {
            loading: false,
            formData: [],
            option: {
                width: '800px'
            }
        }
    },
    watch: {
        employee: function(value) {
            this.buildFormData();
        },
        openModal: function(value) {
            if (value == false) {
                this.buildFormData();
            }
        }
    },
    async created() {
        await this.getAgencies({query: {take: 9999, orderBy: 'name|asc'}});
        this.buildFormData();
    },
    components: {
        ModalDialog,
        SaveButton
    },
    mixins: [
        ModalDialogMixin,
        StringHelperMixin,
        AlertMixin
    ],
    computed: {
        ...mapGetters({
            agencies: 'governmentAgencies/data',
            employee: 'employees/single'
        })
    },
    methods: {
        ...mapActions({
            getAgencies: 'governmentAgencies/getAgencies'
        }),
        buildFormData() {
            this.formData = [];

            _.each(this.agencies, (agency) => {
                let model = {
                    agencyId: agency.id,
                    name: this.slugify(agency.name),
                    label: agency.name,
                    value: '',
                    mask: agency.mask,
                    placeholder: agency.placeholder
                };

                const val = this.getValue(agency.id);

                if (val.length) {
                    model['id'] = val[0].id;
                    model['value'] = val[0].id_number;
                }

                this.formData.push(model);
            });
        },
        save() {
            this.loading = true;

            let promises = [];

            _.each(this.formData, (form) => {
                if (!this.isEmpty(form.value)) {
                let governmentId = form.id ? new GovernmentId({id: form.id}) : new GovernmentId();
                    let data = {
                        agency_id: form.agencyId,
                        employee_id: this.employee.id,
                        value: form.value
                    };

                    promises.push(governmentId.save(data));
                }
            });

            Promise.all(promises).then((res) => {
                this.$emit('success');
                this.loading = false;
                this.notifyDialog('success', 'Successfully saved!');
            });
        },
        getValue(agencyId) {
            return this.employee.governmentIds.data.filter((d) => d.agency_id == agencyId);
        },
        validLength(string) {
            return  (string.length - (string.split("-").length - 1));
        },
        replaceText(str,look,replace){
            if(str!=null && str!='') {
                return str.replace(look,replace);
            } 
            return "";
        }
    }
}
</script>
