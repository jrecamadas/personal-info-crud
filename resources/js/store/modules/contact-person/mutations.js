import _ from 'lodash';

const CONTACT_PERSON_UPDATED = (state, payload) => {
    state.contactperson = payload.data;
}

const DELETE_CONTACT_PERSON = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.contactperson = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    CONTACT_PERSON_UPDATED,
    DELETE_CONTACT_PERSON,
    CLEAR_STATES,
    SAVE_META
}
