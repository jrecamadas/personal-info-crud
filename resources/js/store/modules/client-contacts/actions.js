import { ClientContact } from '@common/model/ClientContact';

const getContacts = (context, payload) => {
    return ClientContact.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_CLIENT_CONTACTS', {data: res.data});
        context.commit('SAVE_META', res.meta);
    });
}

const saveContact = (context, data) => {
    const id = data.id;
    const clientContact = (id && id != "" && id > 0) ? new ClientContact({id:id}) : new ClientContact();
    return clientContact.save(data).then( (res) => {
        context.commit('CLIENT_CONTACT_UPDATED', {data: res.data});
    });
}

const getContact = (context, id) => {
    return ClientContact.get({id:id}).then((res) => {
        context.commit('CLIENT_CONTACT_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find contact!');
    })
}

const deleteContact = (context, id) => {
    const contact = new ClientContact({id: id});
    return contact.delete().then((res) => {
        return (res) ? 0 : 1;
    });
};

export {
    getContacts,
    saveContact,
    deleteContact,
    getContact,
}
