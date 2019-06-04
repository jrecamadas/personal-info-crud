import { Language } from '@common/model/Language';

const getLanguages = (context, payload) => {
    return Language.get(payload.query).then((res) => {
        context.commit('LANGUAGES_UPDATED', {data: res.data, extra: payload.extra});
    })
};

export {
    getLanguages
}
