import { WorkLocation } from '@common/model/WorkLocation';

const getWorkLocation = (context, payload) => {
    return WorkLocation.get(payload.query).then((res) => {
        context.commit('WORK_LOCATIONS_UPDATED', {data: res.data, extra: payload.extra});
    })
};

const clearItems = (context) => {
    context.commit('CLEAR_ITEMS');
}

export {
    getWorkLocation,
    clearItems
}
