import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [],
    formatted: [],
    formatted_location: [],
    location: {}
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
