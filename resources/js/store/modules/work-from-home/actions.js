import { WorkFromHomeRequest } from '@common/model/WorkFromHomeRequest';

const saveRequest = (context, payload) => {
    const id = payload.id;
    const request = (id !== '' && id > 0)
        ? new WorkFromHomeRequest({ id: id })
        : new WorkFromHomeRequest();

    return request.save(payload);
};

const getWfhList = (context, payload) => {
    return WorkFromHomeRequest.get(payload).then((res) => {
        context.commit('CLEAR_WFH_REQUEST_LIST');
        context.commit('PUSH_TO_WFH_REQUEST_LIST', res.data);
        context.commit('SAVE_META', res.meta);
    });
};

export {
    saveRequest,
    getWfhList,
}
