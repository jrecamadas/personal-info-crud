import { EmployeeWorkShift } from '@common/model/EmployeeWorkShift';

const getEmployeeWorkShift = (context, id) => {
    return EmployeeWorkShift.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_WORK_SHIFT_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find employee work shift!');
    })
}

const saveEmployeeWorkShift = (context, payload) => {
    const id = payload.id;
    const instance = (id != null && id != "" && id > 0) ? new EmployeeWorkShift({id:id}) : new EmployeeWorkShift();
    return instance.save(payload).then( (res) => {
        context.commit('EMPLOYEE_WORK_SHIFT_UPDATED', {data: res.data});
    });
}

const deleteEmployeeWorkShift = (context, id) => {
    const employeeSkill = new EmployeeSkill({id: id});
    return employeeSkill.delete().then((res) => {
        context.commit('DELETE_EMPLOYEE_WORK_SHIFT');
    });
};

export {
    getEmployeeWorkShift,
    saveEmployeeWorkShift,
    deleteEmployeeWorkShift
}
