import _ from 'lodash';

const GET_LEAVE_CREDIT_TYPES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // Format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.name
        }, payload.extra);

        state.formatted.push(obj);
    });
}

const GET_LEAVE_CREDIT_TYPE = (state, data) => {
    state.single = null;
    state.single = data;
};

const DELETE_LEAVE_CREDIT_TYPE = (state) => {};

const CLEAR_LEAVE_CREDIT_TYPES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
};
const SET_META = (state, meta) => {
    state.meta = meta;
}

export {
   GET_LEAVE_CREDIT_TYPES,
   GET_LEAVE_CREDIT_TYPE,
   CLEAR_LEAVE_CREDIT_TYPES,
   DELETE_LEAVE_CREDIT_TYPE,
   SET_META,
}
