import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [
        { value: 0, label: 'Unpaid', isOn: false },
        { value: 1, label: 'Paid', isOn: true }

    ],
    formatted: [
        { value: 0, label: 'Unpaid', isOn: false },
        { value: 1, label: 'Paid', isOn: true }

    ],
    defaultVal: { value: 0, label: "Unpaid", isOn: false }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
