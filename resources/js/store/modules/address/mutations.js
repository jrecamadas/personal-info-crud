import _ from 'lodash';

const GET_ADDRESSES = (state, payload) => {
    state.data = payload.data;
}

const ADDRESS_UPDATED = (state, payload) => {
    state.address = payload.data;
}

const DELETE_ADDRESS = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.address = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    GET_ADDRESSES,
    ADDRESS_UPDATED,
    DELETE_ADDRESS,
    CLEAR_STATES,
    SAVE_META
}
