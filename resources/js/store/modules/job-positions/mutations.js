import _ from 'lodash';

const JOB_POSITIONS_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.job_title
        }, payload.extra);

        state.formatted.push(obj);
    });
};

const JOB_POSITION_UPDATED = (state, payload) => {
    state.position = payload.data
}

const CLEAR_JOB_POSITIONS = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
};

const DELETE_JOB_POSITION = (state) => {};

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    SAVE_META,
    DELETE_JOB_POSITION,
    CLEAR_JOB_POSITIONS,
    JOB_POSITIONS_UPDATED,
    JOB_POSITION_UPDATED
}
