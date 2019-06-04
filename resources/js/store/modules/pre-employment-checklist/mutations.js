import _ from 'lodash';

const PRE_EMPLOYMENT_CHECKLISTS_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            item_no: row.item_no,
            name: row.item,
        }, payload.extra);

        state.formatted.push(obj);
    });
}

const PRE_EMPLOYMENT_CHECKLIST_UPDATED = (state, data) => {
    state.single = null;
    state.single = data;
};

const META_SET = (state, meta) => {
    state.meta = meta;
};

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formattd = [];
    state.meta = {};
    state.single = null;
};

const CLEAR_STATE_AT = (state, {key, value}) => {
    state[key] = value;
};

export {
    PRE_EMPLOYMENT_CHECKLISTS_UPDATED,
    PRE_EMPLOYMENT_CHECKLIST_UPDATED,
    META_SET,
    CLEAR_STATES,
    CLEAR_STATE_AT
}