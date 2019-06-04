import _ from 'lodash';

const EMPLOYEE_SKILLS_UPDATED = (state, payload) => {
    state.skills = payload.data;
}

const DELETE_EMPLOYEE_SKILL = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.skills = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    EMPLOYEE_SKILLS_UPDATED,
    DELETE_EMPLOYEE_SKILL,
    CLEAR_STATES,
    SAVE_META
}
