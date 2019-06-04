import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    fullNameText: 'Gigabook Inc./Full Scale',
    shortNameText: 'Full Scale',
    fullScaleLogo: '/images/fs-logo-white.png'
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}