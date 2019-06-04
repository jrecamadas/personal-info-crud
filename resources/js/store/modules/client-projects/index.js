import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [],
    formatted: [],
    formatted_with_name: [],
    meta: {},
    project: {}
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
