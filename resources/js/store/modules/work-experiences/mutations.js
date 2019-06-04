import _ from 'lodash';

const WORK_EXPERIENCE_UPDATED = (state, payload) => {
    state.skills = payload.data;
}

const DELETE_WORK_EXPERIENCE = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.work_experience = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    WORK_EXPERIENCE_UPDATED,
    DELETE_WORK_EXPERIENCE,
    CLEAR_STATES,
    SAVE_META
}
