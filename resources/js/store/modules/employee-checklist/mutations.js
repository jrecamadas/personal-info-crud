import _ from 'lodash';

const EMPLOYEE_CHECKLIST_UPDATED = (state, data) => {
    state.single = null;
    state.data = data;
};

export {
    EMPLOYEE_CHECKLIST_UPDATED,
}