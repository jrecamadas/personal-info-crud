import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [
        {value: 'Pending', label: 'Pending'},
        {value: 'Approved', label: 'Approved'},
        {value: 'Cancelled', label: 'Cancelled'},
        {value: 'Disapproved', label: 'Disapproved'}
    ],
    formatted: [
        {id: 'Pending', text: 'Pending'},
        {id: 'Approved', text: 'Approved'},
        {id: 'Cancelled', text: 'Cancelled'},
        {id: 'Disapproved', text: 'Disapproved'}
    ],
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
