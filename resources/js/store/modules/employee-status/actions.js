import { EmployeeStatus } from '@common/model/EmployeeStatus';

const getEmployeeStatuses = (context, query) => {
    return EmployeeStatus.get(query).then((res) => {
        context.commit('GET_EMP_STATUSES', res);
    });
}

const saveEmployeeStatus = (context, payload) => {
    const data = {
        employee_id: payload.employee_id,
        status_id: payload.status_id,
        user_id: payload.user_id
    };
    const empStatus = new EmployeeStatus();
    return empStatus.save(data);
};

export {
    getEmployeeStatuses,
    saveEmployeeStatus
}
