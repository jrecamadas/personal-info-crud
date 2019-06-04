import _ from 'lodash';

const GET_CLIENT_CONTACTS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            email: row.email
        }, payload.extra);
        
        state.formatted.push(obj);
    });
}

const GET_CLIENT_CONTACT = (state, payload) => {
    state.data = payload.data
    state.formatted = [];
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            client_id: row.client_id,
            name: row.name,
            email: row.email,
            contact_no: row.contact_no
        }, payload.extra);
        
        state.formatted.push(obj);
    });
}

const CLIENT_CONTACT_UPDATED = (state, payload) => {
    state.contact = payload.data
}

const DELETE_CLIENT_CONTACTS = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.contact = [];
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    GET_CLIENT_CONTACTS,
    GET_CLIENT_CONTACT,
    CLIENT_CONTACT_UPDATED,
    DELETE_CLIENT_CONTACTS,
    CLEAR_STATES,
    SAVE_META
}
