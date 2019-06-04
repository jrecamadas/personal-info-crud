import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    ready: false,
    data: [],
    formatted: [],
    defaultVal: ['175']
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
