import { GovernmentAgency } from '@common/model/GovernmentAgency';

const getAgencies = (context, payload) => {
    return GovernmentAgency.get(payload.query).then((res) => {
        context.commit('AGENCIES_UPDATED', {data: res.data, extra: payload.extra});
    })
};

export {
    getAgencies
}
