import _ from 'lodash';

const EMPLOYEE_REPORTS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
}

const EMPLOYEE_REPORT = (state, payload) => {
    state.employeeReport = payload.data;
    state.formatted = [];
}

const EMPLOYEE_REPORT_UPDATED = (state, payload) => {
    state.employeeReport = payload.data
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = [];
    state.employeeReport = [];
}

export {
    EMPLOYEE_REPORTS,
    EMPLOYEE_REPORT,
    EMPLOYEE_REPORT_UPDATED,
    SAVE_META,
    CLEAR_STATES
}
