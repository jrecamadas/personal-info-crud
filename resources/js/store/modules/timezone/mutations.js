import _ from "lodash";

const TIMEZONES_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, row => {
        let obj = _.defaults(
            {
                id: row.id,
                text: row.text
            },
            payload.extra
        );

        state.formatted.push(obj);
    });

    state.formatted.sort((a, b) => (a.text > b.text) ? 1 : -1)
};

const TIMEZONE_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    _.each(state.data, row => {
        let obj = _.defaults(
            {
                id: row.id,
                text: row.name
            },
            payload.extra
        );

        state.formatted.push(obj);
    });


};
const EDIT_TIMEZONE = (state, payload) => {
    state.timezone = payload.data;
};

const DELETE_TIMEZONE = state => {};

const SAVE_META = (state, meta) => {
    state.meta = meta;
};

const CLEAR_STATES = state => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.timezone = {};
};

export {
    TIMEZONES_UPDATED,
    TIMEZONE_UPDATED,
    SAVE_META,
    DELETE_TIMEZONE,
    EDIT_TIMEZONE,
    CLEAR_STATES
};
