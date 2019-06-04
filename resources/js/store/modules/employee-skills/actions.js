import { EmployeeSkill } from '@common/model/EmployeeSkill';

const getEmployeeSkill = (context, id) => {
    return EmployeeSkill.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_SKILLS_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find skill!');
    })
}

const saveEmployeeSkill = (context, payload) => {
    const id = payload.id;
    const employeeSkill = (id != null && id != "" && id > 0) ? new EmployeeSkill({id:id}) : new EmployeeSkill();
    return employeeSkill.save(payload).then( (res) => {
        context.commit('EMPLOYEE_SKILLS_UPDATED', {data: res.data});
    });
}

const deleteEmployeeSkill = (context, id) => {
    const employeeSkill = new EmployeeSkill({id: id});
    return employeeSkill.delete().then((res) => {
        context.commit('DELETE_EMPLOYEE_SKILL');
    });
};

export {
    getEmployeeSkill,
    saveEmployeeSkill,
    deleteEmployeeSkill
}
