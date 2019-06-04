/* eslint-disable no-param-reassign */
import _ from 'lodash';

const GET_CATEGORIES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    _.each(state.data, (row) => {
        const obj = _.defaults(
            {
                id: row.id,
                text: row.name,
            },
            payload.extra,
        );

        state.formatted.push(obj);
    });
};

const CATEGORIES_UPDATED = (state, payload) => {
    state.categories = payload.data;
};

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.categories = {};
};

const SAVE_META = (state, meta) => {
    state.meta = meta;
};

export {
    GET_CATEGORIES, CATEGORIES_UPDATED, CLEAR_STATES, SAVE_META,
};
