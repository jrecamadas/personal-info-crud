import _ from 'lodash';
const GET_STATUSES = (state, payload) => {
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
};

const EDIT_STATUS = (state, payload) => {
    state.status = payload.data
};
const EDIT_STATUSES = (state, payload) => {
    state.status = payload.data
}

const DELETE_STATUS = (state) => {};


const SAVE_META = (state, meta) => {
    state.meta = meta;
}

const GET_EMPLOYEE_STATUSES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        if(row.name == "Assigned" || row.name == "Available")
        {
            let obj = _.defaults({
                id: row.id,
                text: row.name
            }, payload.extra);

            state.formatted.push(obj);
        }
    });
}

export {
    GET_STATUSES,
    GET_EMPLOYEE_STATUSES,
    SAVE_META,
    DELETE_STATUS,
    EDIT_STATUS,
    EDIT_STATUSES
    //STATUS_UPDATED
}
