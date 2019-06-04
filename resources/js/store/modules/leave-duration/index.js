import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';

const state = {
    data: [
        { value: 'Whole Day', label: 'Wholeday', isOn: true },
        { value: 'Half Day', label: 'Halfday', isOn: false }

    ],
    formatted: [
        { value: 'Whole Day', label: 'Wholeday', isOn: true },
        { value: 'Half Day', label: 'Halfday', isOn: false }

    ],
    defaultVal: { value: 'Half Day', label: 'Halfday', isOn: false }

};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
