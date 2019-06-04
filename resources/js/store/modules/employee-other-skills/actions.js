import { EmployeeOtherSkill } from '@common/model/EmployeeOtherSkill';

const getEmployeeOtherSkill = (context, id) => {
    return EmployeeOtherSkill.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_OTHER_SKILL_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find other skill!');
    })
}

const saveEmployeeOtherSkill = (context, payload) => {
    const id = payload.id;
    const employeeOtherSkill = (id != null && id != "" && id > 0) ? new EmployeeOtherSkill({id:id}) : new EmployeeOtherSkill();
    return employeeOtherSkill.save(payload).then( (res) => {
        context.commit('EMPLOYEE_OTHER_SKILL_UPDATED', {data: res.data});
    });
}

const deleteEmployeeOtherSkill = (context, id) => {
    const employeeOtherSkill = new EmployeeOtherSkill({id: id});
    return employeeOtherSkill.delete().then((res) => {
        context.commit('DELETE_EMPLOYEE_OTHER_SKILL');
    });
};

export {
    getEmployeeOtherSkill,
    saveEmployeeOtherSkill,
    deleteEmployeeOtherSkill
}
