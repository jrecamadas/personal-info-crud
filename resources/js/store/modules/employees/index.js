import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [],
    meta: {},
    single: null,
    formatted: [],
    formatted_with_department: [],
    formatted_with_id: [],
    formatted_with_name: [],
    user: null,
    logged_in_employee: {},
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
