import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [
        {value: 'Single', label: 'Single'},
        {value: 'Married', label: 'Married'},
        {value: 'Separated', label: 'Separated'},
        {value: 'Divorced', label: 'Divorced'},
        {value: 'Widowed', label: 'Widowed'}
    ],
    formatted: [
        {id: 'Single', text: 'Single'},
        {id: 'Married', text: 'Married'},
        {id: 'Separated', text: 'Separated'},
        {id: 'Divorced', text: 'Divorced'},
        {id: 'Widowed', text: 'Widowed'}
    ],
    defaultVal: ['Single']
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
