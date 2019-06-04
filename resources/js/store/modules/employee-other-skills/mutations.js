import _ from 'lodash';

const EMPLOYEE_OTHER_SKILL_UPDATED = (state, payload) => {
    state.other_skill = payload.data;
}

const DELETE_EMPLOYEE_OTHER_SKILL = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.other_skill = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    EMPLOYEE_OTHER_SKILL_UPDATED,
    DELETE_EMPLOYEE_OTHER_SKILL,
    CLEAR_STATES,
    SAVE_META
}
