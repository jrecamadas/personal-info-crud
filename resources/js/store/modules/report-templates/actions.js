import { ReportTemplate } from '@common/model/ReportTemplate';

const getReportTemplates = (context, payload) => {
    return ReportTemplate.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('REPORT_TEMPLATE_LIST', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
};

const getReportTemplatesWithFilter = (context, payload) => {
    return ReportTemplate.get(payload).then((res) => {
        context.commit('REPORT_TEMPLATES_FILTER', {data: res.data});
    });
};

const getReportTemplate = (context, id) => {
    return ReportTemplate.get({id:id}).then((res) => {
        context.commit('REPORT_TEMPLATE', {data: res.data});
    });
}

const saveReportTemplate = (context, payload) => {
    const id    = payload.id;
    const data  = {
        report_id:  payload.report_id ? payload.report_id : payload.report.data.id, 
        name:       payload.name,
        view_file:  payload.view_file, 
        default:    payload.default
    };
    const report = (id != "" && id > 0) ? new ReportTemplate({id:id}) : new ReportTemplate();
    return report.save(data);

};

const deleteReportTemplate = (context, id) => {
    const report = new ReportTemplate({id: id});
    return report.delete().then((res) => {
        context.commit('DELETE_REPORT_TEMPLATE');
    });
};

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

export {
    getReportTemplates,
    getReportTemplate,
    saveReportTemplate,
    deleteReportTemplate,
    getReportTemplatesWithFilter,
    saveMeta
}
