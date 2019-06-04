    import _ from 'lodash';
const USER_LOGGED_IN_DATA = (state, payload) => {
    state.data = payload;
    state.formatted = [];
}

const GET_USER = (state, payload) => {
	state.user = payload.data;
}

const GET_USERS = (state, payload) => {
	state.data = payload.data;
	state.formatted = [];
}

const SAVE_META = (state, payload) => {
	state.meta = payload;
}

const DELETE_USER = (state, payload) => {}

const CLEAR_USER = (state) => {
    state.user = [];
}

const CLEAR_STATES = (state, payload) => {
 	state.data = [];
    state.formatted = [];
    state.meta = [];
    state.user = [];
}


export {
    USER_LOGGED_IN_DATA,
    GET_USERS,
    GET_USER,
    SAVE_META,
    DELETE_USER,
    CLEAR_STATES,
    CLEAR_USER
}
