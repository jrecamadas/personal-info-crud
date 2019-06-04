import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [
        {value: 1, label: 'Junior'},
        {value: 2, label: 'Mid'},
        {value: 3, label: 'Senior'}
    ],
    formatted: [
        {id: 1, text: 'Junior'},
        {id: 2, text: 'Mid'},
        {id: 3, text: 'Senior'}
    ],
    defaultVal: '0'
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
