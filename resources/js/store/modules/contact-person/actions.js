import { ContactPerson } from '@common/model/ContactPerson';

const getContactPerson = (context, id) => {
    return ContactPerson.get({id:id}).then((res) => {
        context.commit('CONTACT_PERSON_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find contact person!');
    })
}

const saveContactPerson = (context, payload) => {
    const id = payload.id;
    const contactPerson = (id != null && id != "" && id > 0) ? new ContactPerson({id:id}) : new ContactPerson();
    return contactPerson.save(payload).then( (res) => {
        context.commit('CONTACT_PERSON_UPDATED', {data: res.data});
    });
}

const deleteContactPerson = (context, id) => {
    const contactPerson = new ContactPerson({id: id});
    return contactPerson.delete().then((res) => {
        context.commit('DELETE_CONTACT_PERSON');
    });
};

export {
    getContactPerson,
    saveContactPerson,
    deleteContactPerson
}
