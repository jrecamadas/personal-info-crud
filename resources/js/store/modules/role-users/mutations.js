import _ from 'lodash';

const GET_USER_ROLE = (state, payload) => {
    state.data = payload.data;
}

const USER_ROLE_UPDATED = (state, payload) => {
    state.role = payload.data;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.role = {};
}

export {
    GET_USER_ROLE,
    USER_ROLE_UPDATED,
    CLEAR_STATES
}
