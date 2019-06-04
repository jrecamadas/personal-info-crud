import { EmployeeSpouse } from '@common/model/EmployeeSpouse';

const getEmployeeSpouse = (context, id) => {
    return EmployeeSpouse.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_SPOUSE_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find spouse!');
    })
}

const saveEmployeeSpouse = (context, payload) => {
    const id = payload.id;
    const employeeSpouse = (id != null && id != "" && id > 0) ? new EmployeeSpouse({id:id}) : new EmployeeSpouse();
    return employeeSpouse.save(payload).then( (res) => {
        context.commit('EMPLOYEE_SPOUSE_UPDATED', {data: res.data});
    });
}

const deleteEmployeeSpouse = (context, id) => {
    const employeeSpouse = new EmployeeSpouse({id: id});
    return employeeSpouse.delete().then((res) => {
        context.commit('DELETE_EMPLOYEE_SPOUSE');
    });
};

export {
    getEmployeeSpouse,
    saveEmployeeSpouse,
    deleteEmployeeSpouse
}
