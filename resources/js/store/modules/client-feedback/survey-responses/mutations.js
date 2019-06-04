/* eslint-disable no-param-reassign */
import _ from 'lodash';

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.surveyResponse = {};
};

const SURVEY_RESPONSES_UPDATED = (state, payload) => {
    state.surveyResponse = payload.data;
};

const GET_SURVEY_RESPONSES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    _.each(state.data, (row) => {
        const obj = _.defaults(
            {
                id: row.id,
                surveySentId: row.surveySentId,
                questionCategory: row.questionCategory,
                questionCategorySequence: row.questionCategorySequence,
                question: row.question,
                questionSequence: row.questionSequence,
                response: row.response,
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
    CLEAR_STATES, SAVE_META, GET_SURVEY_RESPONSES, SURVEY_RESPONSES_UPDATED,
};
