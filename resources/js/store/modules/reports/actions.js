 import { Report } from '@common/model/Report';

const getReports = (context, payload) => {
    return Report.get(payload).then((res) => {
        context.commit('REPORT_LIST', {data: res.data, extra: payload.extra});
    });
};

export {
	getReports
}
