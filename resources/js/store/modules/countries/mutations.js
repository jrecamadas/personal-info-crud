import _ from 'lodash';

const COUNTRIES_UPDATED = (state, payload) => {
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

const COUNTRIES_DEFAULT_SET = (state, defaultVal) => {
    state.default = [defaultVal];
}

const COUNTRIES_READY = (state) => {
    state.ready = true;
}

const COUNTRIES_CLEAR = (state) => {
    state.ready = false;
    state.data = [];
    state.formatted = [];
    defaultVal: ['175'];
}

export {
    COUNTRIES_UPDATED,
    COUNTRIES_DEFAULT_SET,
    COUNTRIES_READY,
    COUNTRIES_CLEAR
}
