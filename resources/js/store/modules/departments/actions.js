import { Department } from '@common/model/Department';

const getDepartments = (context, payload) => {
    return Department.get(payload.query).then((res) => {
        context.commit('DEPARTMENTS_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('DEPARTMENTS_READY');
    })
};

const setDefaultVal = (context, defaultVal) => {
    context.commit('DEPARTMENTS_DEFAULT_SET', defaultVal);
};

const clearDepartment = (context) => {
    context.commit('CLEAR_DEPARTMENT');
}

export {
    getDepartments,
    setDefaultVal,
    clearDepartment
}
