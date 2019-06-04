import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [
        {value: 'Male', label: 'Male'},
        {value: 'Female', label: 'Female'}
    ],
    formatted: [
        {id: 'Male', text: 'Male'},
        {id: 'Female', text: 'Female'}
    ],
    defaultVal: ['Male']
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
