import _ from 'lodash';

const UPDATE_APPROVERS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            approver_id: row.approver_id,
            oic_id: row.oic_id
        }, payload.extra);

        state.formatted.push(obj);
    });
};

const UPDATE_APPROVERS_ALL = (state, payload) => {
    state.approversAll = payload.data;
};

const UPDATE_APPROVER = (state, payload) => {
    state.approver = payload.data
}

const CLEAR_APPROVERS = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
};

const CLEAR_APPROVERS_ALL = (state) => {
    state.approversAll = [];
};

const DELETE_APPROVER = (state) => {};

const META_SET = (state, meta) => {
    state.meta = meta;
}

export {
    META_SET,
    DELETE_APPROVER,
    CLEAR_APPROVERS,
    UPDATE_APPROVERS,
    UPDATE_APPROVER,
    UPDATE_APPROVERS_ALL,
    CLEAR_APPROVERS_ALL
}
