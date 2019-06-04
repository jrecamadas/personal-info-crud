import _ from 'lodash';

const CONTACT_UPDATED = (state, payload) => {
    state.contact = payload.data;
}

const DELETE_CONTACT = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.contact = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    CONTACT_UPDATED,
    DELETE_CONTACT,
    CLEAR_STATES,
    SAVE_META
}
