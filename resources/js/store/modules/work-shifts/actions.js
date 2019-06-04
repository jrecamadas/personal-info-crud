import { WorkShift } from '@common/model/WorkShift';

const getWorkShifts = (context, payload) => {
    return WorkShift.get(payload.query).then((res) => {
        context.commit('WORK_SHIFTS_UPDATED', {data: res.data, extra: payload.extra});
    })
};

const clearItems = (context) => {
    context.commit('CLEAR_ITEMS');
}

export {
    getWorkShifts,
    clearItems
}
