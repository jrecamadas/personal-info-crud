import _ from 'lodash';

const PERSONAL_INFO_UPDATED = (state, payload) => {
    state.data = payload.data
    state.formatted = [];

    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.name
        }, payload.extra);

        state.formatted.push(obj);
    });
}
const EDIT_PERSONAL_INFO = (state, payload) => {
    state.info = payload.data
}

const DELETE_PERSONAL_INFO = (state) => {}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.skill = {};
}



export {
    PERSONAL_INFO_UPDATED,
    SAVE_META,
    DELETE_PERSONAL_INFO,
    EDIT_PERSONAL_INFO,
    CLEAR_STATES
}
