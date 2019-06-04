/* eslint-disable no-param-reassign */
import _ from 'lodash';

const GET_EMAIL_TEMPLATES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
    _.each(state.data, (row) => {
        const obj = _.defaults(
            {
                id: row.id,
                templateName: row.templateName,
                emailSubject: row.emailSubject,
                emailBody: row.emailBody,
                isActive: row.isActive,
                createdAt: row.createdAt,
                updatedAt: row.updatedAt,
            },
            payload.extra,
        );

        state.formatted.push(obj);
    });
};

const CUSTOM_EMAIL = (state, payload) => {
    state.custom = payload.data;
};

const CLEAR_CUSTOM_EMAIL = (state) => {
    state.custom = {};
    state.email = {};
};

const GET_EMAIL_TEMPLATE = (state, payload) => {
    state.emails = [];
    if (Array.isArray(payload)) {
        _.each(payload, (row) => {
            const obj = _.defaults({
                id: row.id,
                templateName: row.templateName,
                emailSubject: row.emailSubject,
                emailBody: row.emailBody
            });

            state.emails.push(obj);
        })
    } else {
        state.email = payload;
    }
};

const EDIT_EMAIL_TEMPLATE = (state, payload) => {
    state.email = payload;
};

const CLEAR_EDIT_EMAIL = (state) => {
    state.email = {};
};

const EMAIL_TEMPLATES_UPDATED = (state, payload) => {
    state.data = payload;
};

const DELETE_EMAIL_TEMPLATE = () => {};

const META_SET = (state, meta) => {
    state.meta = meta;
};

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.email = {};
};

export {
    GET_EMAIL_TEMPLATES,
    GET_EMAIL_TEMPLATE,
    EMAIL_TEMPLATES_UPDATED,
    EDIT_EMAIL_TEMPLATE,
    DELETE_EMAIL_TEMPLATE,
    CLEAR_EDIT_EMAIL,
    CLEAR_CUSTOM_EMAIL,
    CLEAR_STATES,
    CUSTOM_EMAIL,
    META_SET,
};
