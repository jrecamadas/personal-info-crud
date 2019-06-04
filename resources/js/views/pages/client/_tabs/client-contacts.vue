<template>
    <div class="fs-accord">
        <div class="fs-field">
            <div class="card panel panel-default ks-information ks-light">
                <div class="card-header">
                    <div class="card-header-text">
                        <h4 class="ks-text">Contact Information</h4>
                    </div>
                    <div class="card-header-icon">
                        <a class="btn btn-outline-primary ks-light ks-no-text" @click="open = true">
                            <span class="la la-plus ks-icon"></span>
                        </a>
                    </div>
                </div>
                <div class="card-block" v-if="client.contacts">
                    <div v-for="(contact) in client.contacts.data" class="fs-card" v-bind:key="contact.id">
                        <div class="fs-card-block">
                            <div class="fs-card-info">
                                <span class="pull-left contact-icon la la-user"></span>
                                <p class="card-title">{{ contact.name }}</p>
                                <span class="pull-left contact-icon la la-envelope"></span>
                                <p class="card-text">{{ contact.email }}</p>
                                <span class="pull-left contact-icon la la-phone"></span>
                                <p class="card-text">{{ contact.contact_no }}</p>
                            </div>
                        </div>
                        <div class="fs-card-block-icon">
                            <a href="#contact" class="fs-button" @click="editData(contact.id)">
                                <span class="la la-pencil ks-icon"></span>
                            </a>
                            <a href="#contact" class="fs-button" @click="removeData(contact.id, contact.name)">
                                <span class="la la-trash-o ks-icon"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN MODAL -->
        <create-contact-modal 
            v-if="open"
            :info="form"
            :openModal="open"
            @success="updateData"
            @close="closeModal">
        </create-contact-modal>
        <!-- END MODAL -->
    </div>
</template>

<style lang="scss" scoped>
    .fs-card {
        word-break: break-word;
        &:last-child {
            padding-bottom: 0!important;
        }
        .fs-card-block{
            width: 80%;
        }
        .fs-card-info{
            min-width: 80%;        
        }
        .fs-card-block-icon{
            width: 20%;
            text-align: right;
        }
    }
    .card-header-text{
        width: 80%;
    }
    .card-header-icon{
        widows: 20%;
    }
    .depTable th, td {
        padding: 10px;
        text-align: left;
    }
    .contact-icon {
        font-size: 1.5em;
        padding-right: 0.5em;
        color: #25628f;
    }
    .card-title {
        font-size: 15px;
        font-weight: bold;
    }
    .card-header {
        padding: 10px!important;
    }
    .card-block {
        max-height: 160px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px!important;
    }
</style>

<script>
import CreateContactModal from '@views/pages/client/_modals/create-contact.vue';
import AlertMixin from '@common/mixin/AlertMixin';
import { mapGetters, mapActions } from 'vuex';

export default {
    components: {
        CreateContactModal
    },
    mixins: [
        AlertMixin
    ],
    props: {
		id: { type: String, required: true}
    },
    data() {
        return {
            open: false,
            form: {
                id: '',
                client_id: ''
            }
        }
    },
    async created() {
        this.form.client_id = this.id;
    },
    computed: {
        ...mapGetters({
            client:'clients/client'
        }),
    },
    methods: {
        ...mapActions({
            deleteContact: 'clientContacts/deleteContact',
            getClient: 'clients/getClient'
        }),
        removeData(id, contact) {
            const title = 'Are you sure you want to delete this contact?';
            const msg = `${contact} `;

            this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                .then(({ ok }) => {
                    if(ok) {
                        this.deleteContact(id).then((res) => {
                            if(res == 0) {
                                this.alertDialog('Contact cannot be deleted.', msg + 'was included to respond in a survey', 'Ok', 'sm');
                            }
                            else {
                                this.notifyDialog('error', 'Successfully deleted!');
                            }
                            this.updateData();
                        });
                    }
                });
        },
        editData(contact_id) {
            this.form.id = contact_id;
            this.form.client_id = this.id;
            this.open = true;
        },
        updateData() {
            this.getClient(this.id);
        },
        async closeModal(){
            this.form.id = '';
            this.open = false;
        },
    }
}
</script>
