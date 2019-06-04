import _ from 'lodash';

const GET_RESOURCES = (state, payload) => {
    state.data = payload.data
}

const RESOURCE_UPDATED = (state, payload) => {
    state.resource = payload.data
}

const GET_RESOURCE_PROJECTS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.client_project_id,
            text: row.employee.data.name,
        }, payload.extra);

        state.formatted.push(obj);
    });
}

const DELETE_RESOURCE = (state) => {
    state.resource = '';
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
}

export {
    GET_RESOURCES,
    RESOURCE_UPDATED,
    GET_RESOURCE_PROJECTS,
    DELETE_RESOURCE,
    CLEAR_STATES
}
