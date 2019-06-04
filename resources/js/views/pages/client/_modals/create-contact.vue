<template>
    <modal-dialog v-show="openModal" :options="option" :title="title" @close="closeModal" style="margin-top: 7rem;">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!valid" >{{ modal_save }}</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group" :class="{ 'has-error': errors.has('name') }">
                                <label>Contact Name<span class="error">*</span></label>
                                <input type="text" v-validate="'required|alpha_spaces'" ref="contactName" name="name" class="form-control" v-model="contact.name" />
                                <span v-show="errors.has('name')" class="help-block form-error">{{ replaceText(errors.first('name'), 'name', 'Contact Name') }}</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group" :class="{ 'has-error': errors.has('email') || duplicateEmail }">
                                <label>Contact Email<span class="error">*</span></label>
                                <input type="text" @input="duplicateEmail = false;" v-validate="'required|email'" ref="contactEmail" name="email" class="form-control" v-model="contact.email" />
                                <span v-show="errors.has('email')" class="help-block form-error">{{ replaceText(errors.first('email'), 'email', 'Contact Email') }}</span>
                                <span v-show="duplicateEmail"  class="help-block form-error">Email already Exist.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group" :class="{ 'has-error': errors.has('contact_no') }">
                                <label>Contact Number<span class="error">*</span></label>
                                <input type="text" v-validate="{ required: true }" v-on:keypress="numericSpecialonly($event)"  maxlength="20" ref="contactNumber" name="contact_no" class="form-control" v-model="contact.contact_no" />
                                <span v-show="errors.has('contact_no')" class="help-block form-error">{{ replaceText(errors.first('contact_no'), 'contact_no', 'Contact Number') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<script type="text/javascript">
import _ from 'lodash';

//Components
import GenerateButton from '@components/form/button.vue';
import SaveButton from '@components/form/button.vue';
import ModalDialog from '@components/modal-dialog.vue';

//Mixins
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
import AlertMixin from '@common/mixin/AlertMixin';

import { mapActions, mapGetters } from 'vuex';

export default {
    components: {
        GenerateButton,
        SaveButton,
        ModalDialog,
    },
    mixins: [
        StringHelperMixin,
        ModalDialogMixin,
        AlertMixin
    ],
    props: {
		info: { type: Object, required: true}
    },
    data() {
        return {
            option: {
                width: '800px'
            },
            modal_save: 'Create',
            loading: false,
            button: {
                class: 'btn btn-primary',
                type: 'button'
            },
            title: 'Add Contact',
            duplicateEmail: false,
            contact: {
                client_id: this.info.client_id,
                name: '',
                email: '',
                contact_no: ''
            },
            validation: [
                {path: 'contact_no', name: 'contact_no', rule: 'required'}
            ],
            email_regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            alpha_space: /^[a-zA-Z][a-zA-Z\s ]+$/
        }
    },
    async created () {
        if(this.info.id != "" && this.info.id > 0) {
            await this.getContact(this.info.id);
            this.contact = this.contact_details;
            this.$set(this.contact,'client_id',this.info.client_id);
            this.title = 'Update Contact';
            this.modal_save = 'Update';
        }
        this.loading = false;
    },
    computed: {
        ...mapGetters({
            contact_details: 'clientContacts/contact',
            contacts: 'clientContacts/formatted',
            client: 'clients/client'
        }),
        valid: function() {
                let valid = true;

                // check validation form validation set rule
                _.each(this.validation, (form) => {
                    // break validation rule
                    let rules = form.rule.split('|');

                    // validate accordingly
                    _.each(rules, (rule) => {
                        if (rule == 'required') {
                            if (this.isEmpty(_.get(this.contact, form.path))) {
                                valid = false;
                                return;
                            }
                        }
                    });
                    if (!valid) return;
                });

                // Check email patterns
                if(this.contact.email == '' || !this.email_regex.test(this.contact.email)){ valid = false; }
                if(this.duplicateEmail){ valid = false; }
                // Check if contact name is blank
                valid = !this.contact.name ? false : valid;
                // check for alpha chars in contact name input
                if(this.contact.name.match(this.alpha_space) == null){ valid = false; }
                // Check if contact number is blank
                valid = !this.contact.contact_no ? false : valid;

                // this line enables the create button on create, so comment out
                // valid = !this.contacts.length;

                return valid;
            }

    },
    methods : {
        ...mapActions({
            getContact: 'clientContacts/getContact',
            fetchContacts: 'clientContacts/getContacts',
            saveContact: 'clientContacts/saveContact'
        }),
        async checkEmail() {
            this.duplicateEmail = false;
            let newEmail = this.contact.email;
            if(this.info.id != "" && this.info.id > 0){
                await this.fetchContacts({query: {client_id: this.info.client_id, email: newEmail, current_id: this.info.id}});
            }else{
                await this.fetchContacts({query: {client_id: this.info.client_id, email: newEmail}});
            }

            if(this.contacts.length){
                this.duplicateEmail = true;
            }
        },
        numericSpecialonly($event) {
             const regex = new RegExp("^[0-9-+) (/]"); //inside [] is where you determine what characters are allowed in this function
             const key = String.fromCharCode(event.charCode ? event.which : event.charCode);
             if (!regex.test(key)) {
        event.preventDefault();
        return false;
            }
        },
        replaceText(str, look, replace){
            if(str!=null && str!=''){
                return str.replace(look,replace);
            } return "";
        },
        async save() {
            this.loading = true;
            await this.checkEmail();
            if(!this.duplicateEmail){
                this.saveContact(this.contact).then((res) => {
                    this.$emit('success');
                    setTimeout(() => {
                        this.closeModal();
                        this.loading = false;
                        this.notifyDialog('success', 'Successfully saved!');
                    },150);
                });
            } else {
                this.loading = false;
            }
        }
    }
}
</script>
