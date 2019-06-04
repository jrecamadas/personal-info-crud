import _ from 'lodash';

const EMPLOYEE_WORK_SHIFT_UPDATED = (state, payload) => {
    state.employee_work_shift = payload.data;
}

const DELETE_EMPLOYEE_WORK_SHIFT = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.employee_work_shift = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    EMPLOYEE_WORK_SHIFT_UPDATED,
    DELETE_EMPLOYEE_WORK_SHIFT,
    CLEAR_STATES,
    SAVE_META
}
