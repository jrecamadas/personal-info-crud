/* eslint-disable no-param-reassign */
import _ from 'lodash';

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.surveySent = {};
};

const SURVEY_SENT_UPDATED = (state, payload) => {
    state.surveySent = payload.data;
};

const GET_SURVEY_SENT = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    _.each(state.data, (row) => {
        const obj = _.defaults(
            {
                id: row.id,
                projectSurveyId: row.projectSurveyId,
                surveyLink: row.surveyLink,
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
    CLEAR_STATES, SAVE_META, GET_SURVEY_SENT, SURVEY_SENT_UPDATED,
};
