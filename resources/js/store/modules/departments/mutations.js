import _ from 'lodash';

const DEPARTMENTS_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: `${row.name}`
        }, payload.extra);

        state.formatted.push(obj);
    });
}
const DEPARTMENTS_DEFAULT_SET = (state, defaultVal) => {
    state.default = [defaultVal];
}

const DEPARTMENTS_READY = (state) => {
    state.ready = true;
}

const CLEAR_DEPARTMENT = (state) => {
    state.ready = false;
    state.data = [];
    state.formatted = [];
}

export {
    DEPARTMENTS_UPDATED,
    DEPARTMENTS_DEFAULT_SET,
    DEPARTMENTS_READY,
    CLEAR_DEPARTMENT
}
