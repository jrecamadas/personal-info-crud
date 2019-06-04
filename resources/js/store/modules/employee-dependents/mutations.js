import _ from 'lodash';

const GET_EMPLOYEE_DEPENDENTS = (state, payload) => {
    state.data = payload.data;
}

const EMPLOYEE_DEPENDENT_UPDATED = (state, payload) => {
    state.dependent = payload.data;
}

const DELETE_EMPLOYEE_DEPENDENT = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.dependent = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    GET_EMPLOYEE_DEPENDENTS,
    EMPLOYEE_DEPENDENT_UPDATED,
    DELETE_EMPLOYEE_DEPENDENT,
    CLEAR_STATES,
    SAVE_META
}
