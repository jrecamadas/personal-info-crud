import _ from 'lodash';

const GET_USER_ROLE = (state, payload) => {
    state.data = payload.data;
}

const GET_USER = (state, payload) => {
	state.role = payload;
}

const USER_ROLE_UPDATED = (state, payload) => {
    state.role = payload.data;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
}

const DELETE_USER_ROLE = (state) => {}

export {
    GET_USER_ROLE,
    USER_ROLE_UPDATED,
    CLEAR_STATES,
    GET_USER,
    DELETE_USER_ROLE
}
