/* eslint-disable no-param-reassign */
/* eslint-disable no-unused-vars */
import _ from 'lodash';

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.surveyMeta = {};
    state.survey = {};
    state.surveyData = {};
};

const GET_SURVEYS = (state, payload) => {
    state.data = payload.data;
};

const EDIT_SURVEY = (state, payload) => {
    state.surveyData = payload.data;
};

const CLEAR_SURVEY_DATA = (state) => {
    state.surveyData = {};
};

const SAVE_META = (state, meta) => {
    state.surveyMeta = meta;
};

const DELETE_SURVEYS = (state) => {};

export {
    CLEAR_STATES,
    SAVE_META,
    GET_SURVEYS,
    DELETE_SURVEYS,
    EDIT_SURVEY,
    CLEAR_SURVEY_DATA,
};
