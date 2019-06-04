import _ from 'lodash';

const GET_ROLES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        if(row.display_name != "User")
        {            
            let obj = _.defaults({
                id: row.id,
                text: row.display_name
            }, payload.extra);

            state.formatted.push(obj);
        }
    });
}

const GET_ROLE = (state, payload) => {
    state.role = payload;
    state.formatted = [];
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.role = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

const EDIT_ROLE = (state, payload) => {
    state.role = payload.data
}

const DELETE_ROLE = (state) => {}

export {
    GET_ROLES,
    GET_ROLE,
    CLEAR_STATES,
    DELETE_ROLE,
    EDIT_ROLE,
    SAVE_META
}
