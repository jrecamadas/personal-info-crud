import { Resource } from '@common/model/acl/Resource';

const getResources = (context, payload) => {
    return Resource.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_RESOURCES', {data: res.data, extra: payload.extra});
    });
};

export {
    getResources
}
