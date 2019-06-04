import _ from 'lodash';

const EMPLOYEE_SPOUSE_UPDATED = (state, payload) => {
    state.spouse = payload.data;
}

const DELETE_EMPLOYEE_SPOUSE = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.spouse = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    EMPLOYEE_SPOUSE_UPDATED,
    DELETE_EMPLOYEE_SPOUSE,
    CLEAR_STATES,
    SAVE_META
}
