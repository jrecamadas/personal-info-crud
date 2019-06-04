import _ from 'lodash';

const EMPLOYEE_OTHER_DETAIL_UPDATED = (state, payload) => {
    state.other_detail = payload.data;
}

const DELETE_EMPLOYEE_OTHER_DETAIL = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.other_detail = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    EMPLOYEE_OTHER_DETAIL_UPDATED,
    DELETE_EMPLOYEE_OTHER_DETAIL,
    CLEAR_STATES,
    SAVE_META
}
