import { Country } from '@common/model/Country';

const getCountries = (context, payload) => {
    return Country.get(payload.query).then((res) => {
        context.commit('COUNTRIES_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('COUNTRIES_READY');
    })
};

const setDefaultVal = (context, defaultVal) => {
    context.commit('COUNTRIES_DEFAULT_SET', defaultVal);
};

const resetCountries = (context) => {
    context.commit('COUNTRIES_CLEAR');
}

export {
    getCountries,
    setDefaultVal,
    resetCountries
}
