import _ from 'lodash';

const EMPLOYEES_UPDATED = (state, payload) => {
    state.data = payload.data;
}

const GET_EMPLOYEES = (state, payload) => {
    state.formatted = [];
    state.formatted_with_id = [];

    // format data for use with the component
    _.each(payload.data, (row) => {
        let obj = _.defaults({
            employee_id: row.id,
            text: row.name,
        }, payload.extra);
        let obj2 = _.defaults({
            employee_id: row.id,
            text: row.employee_no,
        }, payload.extra);
        state.formatted.push(obj);
        state.formatted_with_id.push(obj2);
    });
}

const EMPLOYEES_WITH_DEPARTMENT_FORMAT = (state, payload) => {
    state.data = payload.data;
    state.formatted_with_department = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            employee_id: row.id,
            department: row.department,
        }, payload.extra);

        state.formatted_with_department.push(obj);
    });
}

const EMPLOYEE_UPDATED = (state, data) => {
    state.single = null;
    state.single = data;
};

const USER_EMPLOYEE_UPDATED = (state, data) => {
    state.user = null;
    state.user = data;
};

const META_SET = (state, meta) => {
    state.meta = meta;
};

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formattd = [];
    state.meta = {};
    state.single = null;
};

const CLEAR_STATE_AT = (state, {key, value}) => {
    state[key] = value;
};

const UPDATE_LOGGED_IN_EMPLOYEE = (state, data) => {
    state.logged_in_employee = {};
    state.logged_in_employee = data[0] || data;
}

export {
    EMPLOYEES_UPDATED,
    EMPLOYEE_UPDATED,
    EMPLOYEES_WITH_DEPARTMENT_FORMAT,
    USER_EMPLOYEE_UPDATED,
    META_SET,
    CLEAR_STATES,
    CLEAR_STATE_AT,
    GET_EMPLOYEES,
    UPDATE_LOGGED_IN_EMPLOYEE
}
