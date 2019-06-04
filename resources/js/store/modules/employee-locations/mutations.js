import _ from 'lodash';

const GET_EMPLOYEE_LOCATIONS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
    state.formatted_location = [];
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.address
        }, payload.extra);
        
        let obj2 = _.defaults({
            location_id: row.id,
            text: row.address
        }, payload.extra);
        state.formatted.push(obj);
        if(!state.formatted_location.some(elem => elem.text == row.address))
            state.formatted_location.push(obj2);
    });
}

const EMPLOYEE_LOCATION_UPDATED = (state, payload) => {
    state.location = payload.data;
}

const DELETE_EMPLOYEE_LOCATION = (state, payload) => {
    state.location = payload.data;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.location = {};
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    GET_EMPLOYEE_LOCATIONS,
    EMPLOYEE_LOCATION_UPDATED,
    DELETE_EMPLOYEE_LOCATION,
    CLEAR_STATES,
    SAVE_META
}
