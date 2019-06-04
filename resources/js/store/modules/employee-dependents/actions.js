import { EmployeeDependent } from '@common/model/EmployeeDependent';

const getEmployeeDependents = (context, payload) => {
    return EmployeeDependent.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_EMPLOYEE_DEPENDENTS', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
}

const getEmployeeDependent = (context, id) => {
    return EmployeeDependent.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_DEPENDENT_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find dependent!');
    })
}

const saveEmployeeDependent = (context, payload) => {
    const id = payload.id;
    const employeeDependent = (id != null && id != "" && id > 0) ? new EmployeeDependent({id:id}) : new EmployeeDependent();
    return employeeDependent.save(payload).then( (res) => {
        context.commit('EMPLOYEE_DEPENDENT_UPDATED', {data: res.data});
    });
}

const deleteEmployeeDependent = (context, id) => {
    const employeeDependent = new EmployeeDependent({id: id});
    return employeeDependent.delete().then((res) => {
        context.commit('DELETE_EMPLOYEE_DEPENDENT');
    });
};

export {
    getEmployeeDependents,
    getEmployeeDependent,
    saveEmployeeDependent,
    deleteEmployeeDependent
}
