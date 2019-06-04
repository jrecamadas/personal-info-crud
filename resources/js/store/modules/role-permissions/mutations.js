import _ from 'lodash';

const GET_PERMISSIONS = (state, payload) => {
    state.data = payload.data;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.meta = {};
    state.role_permission = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    GET_PERMISSIONS,
    CLEAR_STATES,
    //DELETE_ROLE,
    //EDIT_ROLE,
    SAVE_META
}
