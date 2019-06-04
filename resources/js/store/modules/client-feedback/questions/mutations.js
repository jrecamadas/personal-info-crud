/* eslint-disable no-param-reassign */
import _ from 'lodash';

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.question = {};
};

const QUESTIONS_UPDATED = (state, payload) => {
    state.question = payload.data;
};

const GET_QUESTIONS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    _.each(state.data, (row) => {
        const obj = _.defaults(
            {
                id: row.id,
                question: row.question,
                displaySequence: row.displaySequence,
                isActive: row.isActive,
                questionCategoryId: row.category.data.id,
            },
            payload.extra,
        );

        state.formatted.push(obj);
    });
};

const SAVE_META = (state, meta) => {
    state.meta = meta;
};

export {
    CLEAR_STATES, SAVE_META, GET_QUESTIONS, QUESTIONS_UPDATED,
};
