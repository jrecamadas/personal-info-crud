import { EmployeeEducation } from '@common/model/EmployeeEducation';

const reOrder = (context, employee) => {
    let employeeEducation = new EmployeeEducation({id: employee.id});

    return employeeEducation.save({order: employee.order}).then(() => {
        context.commit('EDUCATIONS_UPDATED');
    });
};

const getEducation = (context, id) => {
    return EmployeeEducation.get({id:id}).then((res) => {
        context.commit('EDUCATIONS_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find education!');
    })
}

const saveEducation = (context, payload) => {
    const id = payload.id;
    const instance = (id != null && id != "" && id > 0) ? new EmployeeEducation({id:id}) : new EmployeeEducation();
    return instance.save(payload).then( (res) => {
        context.commit('EDUCATIONS_UPDATED', {data: res.data});
    });
}

const deleteEducation = (context, id) => {
    const instance = new EmployeeEducation({id: id});
    return instance.delete().then((res) => {
        context.commit('DELETE_EDUCATION');
    });
};

export {
    reOrder,
    getEducation,
    saveEducation,
    deleteEducation
}
