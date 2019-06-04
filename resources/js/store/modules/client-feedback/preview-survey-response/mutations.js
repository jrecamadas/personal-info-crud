/* eslint-disable no-param-reassign */
/* eslint-disable no-unused-vars */
import _ from 'lodash';

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.surveyResponse = {};
};

const GET_SURVEY_RESPONSE = (state, payload) => {
    state.surveyResponse = payload.data;
};

const SAVE_META = (state, meta) => {
    state.meta = meta;
};

export { CLEAR_STATES, SAVE_META, GET_SURVEY_RESPONSE };
