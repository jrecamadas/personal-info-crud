import _ from 'lodash';

const REPORT_TEMPLATE_LIST = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
}

const REPORT_TEMPLATES_FILTER = (state, payload) => {
    state.reportTemplateFilter = payload.data;
    state.formatted = [];

    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.name
        }, payload.extra);
        
        state.formatted.push(obj);
    });
}

const REPORT_TEMPLATE = (state, payload) => {
    state.reportTemplate = payload.data
    state.formatted = [];
}
const EDIT_REPORT_TEMPLATE = (state, payload) => {
    state.reportTemplate = payload.data
}

const DELETE_REPORT_TEMPLATE = (state) => {}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.reportTemplate = {};
}

export {
    REPORT_TEMPLATE_LIST,
    REPORT_TEMPLATES_FILTER,
    REPORT_TEMPLATE,
    SAVE_META,
    DELETE_REPORT_TEMPLATE,
    EDIT_REPORT_TEMPLATE,
    CLEAR_STATES
}
