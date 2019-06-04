import { Dashboard } from '@common/model/Dashboard';

const getDashboard = (context, payload) => {
    return Dashboard.get(payload.query).then((res) => {
        context.commit('DASHBOARD_UPDATED', {data: res.data, extra: payload.extra});
    })
};

export {
    getDashboard,
}