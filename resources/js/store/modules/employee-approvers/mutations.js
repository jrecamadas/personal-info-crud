import _ from 'lodash';

const UPDATE_EMPLOYEE_APPROVERS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            leave_approver_id: row.leave_approver_id,
            employee_id: row.employee_id
        }, payload.extra);

        state.formatted.push(obj);
    });
};

const UPDATE_EMPLOYEE_APPROVER = (state, payload) => {
    state.employeeApprovers = payload.data
}

const CLEAR_EMPLOYEE_APPROVERS = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
};

const CLEAR_EMPLOYEE_APPROVERS_ALL = (state) => {
    state.employeeApproversAll = [];
};

const DELETE_EMPLOYEE_APPROVER = (state) => {};

const META_SET = (state, meta) => {
    state.meta = meta;
}

const UPDATE_EMPLOYEE_APPROVERS_ALL = (state, payload) => {
    state.employeeApproversAll = payload.data;
}

export {
    META_SET,
    DELETE_EMPLOYEE_APPROVER,
    CLEAR_EMPLOYEE_APPROVERS,
    UPDATE_EMPLOYEE_APPROVERS,
    UPDATE_EMPLOYEE_APPROVER,
    UPDATE_EMPLOYEE_APPROVERS_ALL,
    CLEAR_EMPLOYEE_APPROVERS_ALL
}
