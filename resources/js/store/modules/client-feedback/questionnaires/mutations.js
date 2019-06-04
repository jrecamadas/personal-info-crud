/* eslint-disable no-param-reassign */
// eslint-disable-next-line no-unused-vars
import _ from 'lodash';

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.questionnaire = {};
};

const GET_QUESTIONNAIRE = (state, payload) => {
    state.questionnaire = payload.data;
};

const SAVE_META = (state, meta) => {
    state.meta = meta;
};

export { CLEAR_STATES, SAVE_META, GET_QUESTIONNAIRE };
