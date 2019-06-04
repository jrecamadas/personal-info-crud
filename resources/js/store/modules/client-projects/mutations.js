import _ from 'lodash';

const GET_CLIENT_PROJECTS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
    state.formatted_with_name = [];
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.project_name
        }, payload.extra);
        let obj2 = _.defaults({
            project_id: row.id,
            text: row.project_name
        }, payload.extra);
        
        state.formatted.push(obj);
        state.formatted_with_name.push(obj2);
    });
}

const GET_CLIENT_PROJECTSTATUSES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.name
        }, payload.extra);
        
        state.formatted.push(obj);
    });
}

const CLIENT_PROJECT_UPDATED = (state, payload) => {
    state.project = payload.data
}

const DELETE_CLIENT_PROJECT = (state) => {}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    GET_CLIENT_PROJECTS,
    GET_CLIENT_PROJECTSTATUSES,
    CLIENT_PROJECT_UPDATED,
    DELETE_CLIENT_PROJECT,
    CLEAR_STATES,
    SAVE_META
}
