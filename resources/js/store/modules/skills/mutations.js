import _ from 'lodash';

const SKILLS_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.name
        }, payload.extra);

        state.formatted.push(obj);
    });
}

const SKILL_UPDATED = (state, payload) => {
    state.data = payload.data
    state.formatted = [];

    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.name
        }, payload.extra);

        state.formatted.push(obj);
    });
}
const EDIT_SKILL = (state, payload) => {
    state.skill = payload.data
}

const DELETE_SKILL = (state) => {}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.skill = {};
}



export {
    SKILLS_UPDATED,
    SKILL_UPDATED,
    SAVE_META,
    DELETE_SKILL,
    EDIT_SKILL,
    CLEAR_STATES
}
