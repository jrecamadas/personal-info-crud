import _ from 'lodash';

const GET_USER_ROLE_PERMISSIONS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
            let obj = _.defaults({
                id: row.id,
                text: row.display_name
            }, payload.extra);

            state.formatted.push(obj);
    });
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
}

export {
    GET_USER_ROLE_PERMISSIONS,
    CLEAR_STATES,
}
