import { EmployeeLeaveCredit } from '@common/model/EmployeeLeaveCredit';

const getEmployeeLeaveCredits = (context, payload) => {
    return EmployeeLeaveCredit.get(payload.query).then((res) => {
        context.commit('UPDATE_EMPLOYEE_LEAVE_CREDITS', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find resource!');
    })
};

const saveEmployeeLeaveCredit = (context, payload) => {
    const id = payload.id;
    const employeeLeaveCredit = (id !== "" && id > 0) ? new EmployeeLeaveCredit({id:id}) : new EmployeeLeaveCredit();
    return employeeLeaveCredit.save(payload).then( (res) => {
        context.commit('UPDATE_EMPLOYEE_LEAVE_CREDITS', {data: res.data});
    });

};

export {
    getEmployeeLeaveCredits,
    saveEmployeeLeaveCredit
}
