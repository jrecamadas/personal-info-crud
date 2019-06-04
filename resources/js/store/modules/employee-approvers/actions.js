import { EmployeeApprover } from '@common/model/EmployeeApprover';

const getEmployeeApprovers = (context, payload) => {
    return EmployeeApprover.get(payload.query).then((res) => {
        context.commit('CLEAR_EMPLOYEE_APPROVERS');
        context.commit('UPDATE_EMPLOYEE_APPROVERS', {data: res.data, extra: payload.extra});
        context.commit('META_SET', res.meta);
    });
};

const getEmployeeApproversAll = (context, payload) => {
    return EmployeeApprover.get(payload).then((res) => {
        context.commit('CLEAR_EMPLOYEE_APPROVERS_ALL');
        context.commit('UPDATE_EMPLOYEE_APPROVERS_ALL', {data: res.data, extra: payload.extra});
    });
};

const getEmployeeApprover = (context, id) => {
    return EmployeeApprover.get({id:id}).then((res) => {
        context.commit('UPDATE_EMPLOYEE_APPROVER', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find Employee Approver!');
    });
}

const saveEmployeeApprover = (context, payload) => {
    const id    = payload.id;
    const data  = {
        'leave_approver_id': payload.leave_approver_id,
        'employee_id': payload.employee_id
    };
    const employeeApprovers = (id != '' && id > 0) ? new EmployeeApprover({id:id}) : new EmployeeApprover();
    return employeeApprovers.save(data).then((res) => {
        context.commit('UPDATE_EMPLOYEE_APPROVER', {data: res.data});
    });
}

const clearEmployeeApprovers = (context) => {
    context.commit('CLEAR_EMPLOYEE_APPROVERS');
};

const deleteEmployeeApprover = (context, id) => {
    const employeeApprovers = new EmployeeApprover({id: id});
    return employeeApprovers.delete().then((res) => {
        context.commit('DELETE_EMPLOYEE_APPROVER');
    });
};

const saveMeta = (context, meta) => {
    context.commit('META_SET', meta);
};

export {
    saveMeta,
    getEmployeeApprovers,
    getEmployeeApprover,
    clearEmployeeApprovers,
    deleteEmployeeApprover,
    saveEmployeeApprover,
    getEmployeeApproversAll
}