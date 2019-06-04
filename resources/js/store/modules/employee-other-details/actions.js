import { EmployeeOtherDetail } from '@common/model/EmployeeOtherDetail';

const getEmployeeOtherDetail = (context, id) => {
    return EmployeeOtherDetail.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_OTHER_DETAIL_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find other detail!');
    })
}

const saveEmployeeOtherDetail = (context, payload) => {
    const id = payload.id;
    const employeeOtherDetail = (id != null && id != "" && id > 0) ? new EmployeeOtherDetail({id:id}) : new EmployeeOtherDetail();
    return employeeOtherDetail.save(payload).then( (res) => {
        context.commit('EMPLOYEE_OTHER_DETAIL_UPDATED', {data: res.data});
        return true;
    });
}

const deleteEmployeeOtherDetail = (context, id) => {
    const employeeOtherDetail = new EmployeeOtherDetail({id: id});
    return employeeOtherDetail.delete().then((res) => {
        context.commit('DELETE_EMPLOYEE_OTHER_DETAIL');
    });
};

export {
    getEmployeeOtherDetail,
    saveEmployeeOtherDetail,
    deleteEmployeeOtherDetail
}
