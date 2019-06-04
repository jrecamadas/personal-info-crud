import { EmployeeReport } from '@common/model/EmployeeReport';

const getEmployeeReports = (context, payload) => {
    return EmployeeReport.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('EMPLOYEE_REPORTS', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
};

const getEmployeeReport = (context, id) => {
    return EmployeeReport.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_REPORT', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find skill!');
    })
};

const saveEmployeeReport = (context, data) => {
    const id = data.id;
    const employeeReport = (id && id != "" && id > 0) ? new EmployeeReport({id:id}) : new EmployeeReport();
    return employeeReport.save(data).then( (res) => {
        context.commit('EMPLOYEE_REPORT_UPDATED', {data: res.data});
    });
}

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

export {
    getEmployeeReports,
    getEmployeeReport,
    saveEmployeeReport,
    saveMeta
}
