<template>
    <modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!valid">{{ modal_save }}</save-button>
        </template>
        <template slot="body">
            <div class="s-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                <ul class="nav ks-nav-tabs">
                    <li class="nav-item" :style="getNavItemCSS('basic')">
                        <a 
                            href="javascript:;"
                            class="nav-link active"
                            data-toggle="tab"
                            data-target="#basic"
                            aria-expanded="true"
                            @click="setNavItemSelected('basic')">
                            General
                        </a>
                    </li>
                    <li class="nav-item" :style="getNavItemCSS('contact')">
                        <a
                            href="javascript:;"
                            class="nav-link"
                            data-toggle="tab"
                            data-target="#contact"
                            aria-expanded="false"
                            @click="setNavItemSelected('contact')">
                            Contacts
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- -------------------------- BASIC --------------------------- -->
                    <div class="tab-pane active" id="basic" role="tabpanel" aria-expanded="false">
                        <div class="row padding-row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group" :class="{ 'has-error': errors.has('company') }">
                                            <label>Company Name<span class="error">*</span></label>
                                            <input type="text" ref="company" name="company" class="form-control" v-model="clientData.company" @keyup="checkCompanyName"/>
                                            <span v-show="errors.has('company')" class="help-block form-error">{{ replaceText(errors.first('company'), 'company', 'Company Name') }}</span>
                                            <span v-show="isCompanyTaken" class="help-block form-error">{{ companyTakenMsg }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group" :class="{ 'has-error': errors.has('status') }">
                                            <label>Company Status<span class="error">*</span></label>
                                            <select2
                                                :disabled="!this.info.id" name="status"
                                                :options="status.options"
                                                :value="clientData.status"
                                                @select="clientData.status = $event">
                                            </select2>
                                            <span v-show="errors.has('status')" class="help-block form-error">{{ errors.first('status') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" ref="location" name="location" class="form-control" v-model="clientData.location" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>Time Zone</label>
                                            <select2
                                                name="status"
                                                :options="timezones"
                                                :value="clientData.timezone"
                                                @select="clientData.timezone = $event">
                                            </select2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group" :class="{'has-error': errors.has('is_high_growth_client')}">
                                            <label>Is High Growth Client?<span class="error">*</span></label>
                                            <select2
                                                name="is_high_growth_client"
                                                :options="logic.options"
                                                :value="clientData.is_high_growth_client"
                                                @select="clientData.is_high_growth_client = $event">
                                            </select2>
                                            <span v-show="errors.has('is_high_growth_client')" class="help-block form-error">{{ errors.first('is_high_growth_client') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <flat-pickr
                                                v-model="clientData.start_date"
                                                :config="getConfig(true, false, { minDate: 'today', allowInput: false })"
                                                placeholder="Select start date"
                                                name="start_date"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="contact" role="tabpanel" aria-expanded="false">
                        <div class="row padding-row">
                            <div class="col-lg-12 ">
                                <button class="btn btn-success" @click="addNewContactForm">Add Contact</button>
                                <div class="form-group contact-scroll">
                                    <div class="card mt-2" v-for="(contact, i) in contactData" :key="i">
                                        <div class="card-body">
                                            <Can I="delete" a="client_contact">
                                                <span class="float-right" style="cursor:pointer" @click="deleteContact(i, contact.id )">X</span>
                                            </Can>
                                            <h5 class="card-title mb-0">Contact {{ i + 1 }}</h5>
                                        </div>
                                        <div class="contacts-form">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4">
                                                    <div class="form-group" :class="{ 'has-error': errors.has('name_ '+ i) }">
                                                        <input type="text" v-validate="{ required: true, regex: /^[A-Za-z.&quot; ]*$/ }" ref="contactName" :name="'name_' + i" class="form-control" v-model="contact.name" placeholder="Name"/>
                                                        <span v-show="errors.has('name_' + i)" class="help-block form-error">{{ replaceText(errors.first('name_' + i), 'name_' + i, 'Contact Name') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <div class="form-group" :class="{ 'has-error': errors.has('email_' + i) }">
                                                        <input type="text" @input="isEmailDuplicate = false;" v-validate="'required|email'" ref="contactEmail" :name="'email_' + i" class="form-control" v-model="contact.email" placeholder="Email"/>
                                                        <span v-show="errors.has('email_' + i)" class="help-block form-error">{{ replaceText(errors.first('email_' + i), 'email_' + i, 'Contact Email') }}</span>
                                                        <span v-show="contact.is_email_taken" class="help-block form-error">Email is already taken.</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <div class="form-group" :class="{ 'has-error': errors.has('number_' + i) }">
                                                        <input type="text" v-validate="{ required: true, regex: /^[0-9+-]*$/ }" ref="contactNumber" :name="'number_' + i" class="form-control" v-model="contact.contact_no" placeholder="Contact No."/>
                                                        <span v-show="errors.has('number_' + i)" class="help-block form-error">{{ replaceText(errors.first('number_' + i), 'number_' + i, 'Contact Number') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

<style scoped>
    .form-error {
        color: red;
    }
    .v-dialog.active, .v-dialog:target {
        z-index: 10000 !important;
    }
    .padding-row{
        padding-top: 15px;
    }
    .contact-scroll {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>

<script type="text/javascript">
    import _ from 'lodash';
    
    //Components
    import GenerateButton from '@components/form/button.vue';
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import FlatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    //Mixins
    import StringHelperMixin from '@common/mixin/StringHelperMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import ApplicantMixin from '@common/mixin/ApplicantMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import DatePickerMixin from '@common/mixin/DatePicker';
    import DateMixin from '@common/mixin/DateMixin';

    //Modal
    import { Client } from '@common/model/Client';
    import { Timezone } from '@common/model/Timezone';

    import Select2 from '@components/select2.vue';
    import { mapActions, mapGetters } from 'vuex';

    export default {
        components: {
            GenerateButton,
            SaveButton,
            ModalDialog,
            Select2,
            FlatPickr
        },
        mixins: [
            StringHelperMixin,
            ModalDialogMixin,
            ApplicantMixin,
            AlertMixin,
            DatePickerMixin,
            DateMixin
        ],
        props: {
            info: { type: Object, required: false}
        },
        data() {
            return {
                option: {
                    width: '800px'
                },
                contactData: [],
                clientData: {
                    id: '',
                    company: '',
                    is_high_growth_client: '1',
                    status: '1',
                    location: '',
                    timezone: '',
                    start_date: ''
                },
                title: '',
                modal_save : 'Create Client',
                logic: {
                    options: [
                        {id: 1, text: "No"},
                        {id: 2, text: "Yes"},
                    ]
                },
                status: {
                    options: [
                        {id: 1, text: "Active"},
                        {id: 2, text: "End of Contract"},
                        {id: 3, text: "Prospect"},
                    ]
                },
                button: {
                    class: 'btn btn-primary',
                    type: 'button'
                },
                loading: false,
                validation: [
                    {path: 'company', name: 'company', rule: 'required', msg: {required: 'Company Name is required'}}
                ],
                email_regex: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                alpha_space: /^[a-zA-Z][a-zA-Z\s ]+$/,
                isCompanyTaken: false,
                companyTakenMsg: '',
                isEmailDuplicate: false,
                oldEmails: []
            }
        },
        computed: {
            ...mapGetters({
                contact: 'clients/contact',
                client:'clients/client',
                meta:'clients/meta',
                formatted: 'clients/formatted',
                timezones: 'timezones/formatted',
                contacts: 'clientContacts/data',
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
                            if (this.isEmpty(_.get(this.clientData, form.path))) {
                                valid = false;
                                return;
                            }
                        }
                    });
                    if (!valid) return;
                });

                if(this.errors.items.length) {
                    valid = false;
                }

                if(this.isCompanyTaken) {
                    valid = false;
                }

                _.each(this.contactData, (contact) => {
                    if((contact.name && contact.name.trim()) == '' || (contact.email && contact.email.trim()) == '' || (contact.contact_no && contact.contact_no.trim()) == ''){
                        valid = false;
                    }
                    
                    contact.is_email_taken = false;
                    if(contact.email && (this.contactData.filter((obj) => obj.email === contact.email).length > 1)){
                        this.isEmailDuplicate = true;
                        contact.is_email_taken = true;
                    }
                });

                if(this.isEmailDuplicate){
                    valid = false;
                }
                // Check email patterns
                // if(this.clientData.contactEmail === '' || !this.email_regex.test(this.clientData.contactEmail)){ valid = false; }
                // if(isNaN(this.clientData.contactNumber)) { valid = false; }
                //if(this.clientData.clientName.match(this.alpha_space) == null){ valid = false; } //Remove Alpha and Space Validation for Company Name
                // if(this.clientData.contactName.match(this.alpha_space) == null){ valid = false; }

                return valid;
            },
        },
        async created() {
            await this.getTimezones({query:{take:10000}});
            if(this.info.id) {
                await this.fetchClient(this.info.id);
                await this.getContacts({query: {client: this.info.id}});
                this.modal_save = 'Update';
                this.contactData = this.contacts;
                this.oldEmails = this.contacts.map(a => a.email);
                this.clientData = this.client;
                this.clientData.status = this.getSelect2Value(this.clientData.status);
                this.clientData.is_high_growth_client = this.getSelect2Value(this.clientData.is_high_growth_client);
                let capturedTimezone = this.timezones.filter(e => {return this.info.timezone==e.text})[0]
                this.clientData.timezone = capturedTimezone ? capturedTimezone.id : 1
            }
        },
        methods : {
            ...mapActions({
                saveClient: 'clients/saveClient',
                fetchClient: 'clients/getClient',
                getSpecificClient: 'clients/getSpecificClient',
                getContacts: 'clientContacts/getContacts',
                saveContact: 'clientContacts/saveContact',
                getTimezones: 'timezones/getTimezones',
                removeContact: 'clientContacts/deleteContact'
            }),
            async save() {
                this.loading = true;
                await this.checkEmail();

                if(!this.isEmailDuplicate){
                    delete this.clientData['contacts'];
                    delete this.clientData['projects_count'];
                    delete this.clientData['resources_count'];
                    delete this.clientData['photo'];
                    delete this.clientData['projects'];
                    this.clientData.status = this.getActualValue(this.clientData.status);
                    this.clientData.is_high_growth_client = this.getActualValue(this.clientData.is_high_growth_client);
                    this.saveClient(this.clientData).then((res) => {
                        let promises = [];
                        this.contactData.forEach((contact) => {
                            delete contact['is_email_taken'];
                            contact.client_id = this.client.id;
                            promises.push(this.saveContact(contact));
                        });

                        Promise.all(promises).then((res3) => {
                            this.$emit('success');
                            this.close();
                            this.loading = false;
					        this.notifyDialog('success', 'Successfully saved!');
                        });
                    });
                } else {
                    this.loading = false;
                }
            },
            close() {
                this.closeModal();
                this.clientData = {};
            },
            getSelect2Value(obj) {
                return isNaN(obj) ? 1 : (parseInt(obj) + 1);
            },
            getActualValue(obj) {
                return isNaN(obj) ? 0 : (parseInt(obj) - 1);
            },
            replaceText(str,look,replace) {
                if(str!=null && str!='') {
                    return str.replace(look,replace);
                } return "";
            },
            addNewContactForm() {
                this.contactData.push({
                    id: null,
                    client_id: null,
                    name: '',
                    email: '',
                    contact_no: '',
                });
            },
            deleteContact(i,id) {
                this.confirmDialog("Removing Contact...", "Are you sure you want to delete?", "Yes", "Cancel", "sm").then((res)=>{
                    if(res.ok) {
                        if(id) {
                            this.removeContact(id).then(() => {
                                this.contactData.splice(i,1);
                                if(this.info.id){
                                    this.getContacts({query: {client_id: this.info.id}}).then(() => {
                                        this.oldEmails = this.contacts.map(a => a.email);
                                        this.isEmailDuplicate = false;
                                    });
                                }
                            });
                        } else {
                            this.contactData.splice(i,1);
                        }
                        this.isEmailDuplicate = false;
                    }
                });
            },
            async checkCompanyName(){
                this.isCompanyTaken = false;
                this.companyTakenMsg = '';
                let company = this.clientData.company.trim();
                if(company != ''){
                    await this.getSpecificClient({query: { company: this.clientData.company}});
                    if(this.client.length){
                        this.isCompanyTaken = true;
                        this.companyTakenMsg = 'Company Name is already taken.';
                    }
                }
            },
            async checkEmail(){
                if(this.info.id) {
                    let newEmails = this.contactData.map(a => a.email);
                    let diffEmails = [];

                    for(let c = 0; c < newEmails.length ; c++){
                        if(this.oldEmails[c] == undefined || this.oldEmails[c] != newEmails[c]){
                            diffEmails.push(newEmails[c]);
                        }
                    }
                    if(diffEmails.length){
                        await this.getContacts({query: {client_id: this.info.id, emails: diffEmails.join('@@')}});
                        if(this.contacts.length){
                            this.isEmailDuplicate = true;
                        }
                    }
                }

            }
        }
    }
</script>
