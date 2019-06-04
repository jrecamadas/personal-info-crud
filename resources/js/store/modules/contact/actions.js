import { Contact } from '@common/model/Contact';

const getContact = (context, id) => {
    return Contact.get({id:id}).then((res) => {
        context.commit('CONTACT_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find contact!');
    })
}

const saveContact = (context, payload) => {
    const id = payload.id;
    const contact = (id != null && id != "" && id > 0) ? new Contact({id:id}) : new Contact();
    return contact.save(payload).then( (res) => {
        context.commit('CONTACT_UPDATED', {data: res.data});
    });
}

const deleteContact = (context, id) => {
    const contact = new Contact({id: id});
    return contact.delete().then((res) => {
        context.commit('DELETE_CONTACT');
    });
};

export {
    getContact,
    saveContact,
    deleteContact
}
