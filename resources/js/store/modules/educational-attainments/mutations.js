import _ from 'lodash';

const EDUCATIONAL_ATTAINMENTS_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.attainment
        }, payload.extra);
        state.formatted.push(obj);
    });
};

const EDUCATIONAL_ATTAINMENTS_ACTIVE_UPDATED = (state, payload) => {
    state.active = [];
    state.active = payload.data;
};

export {
    EDUCATIONAL_ATTAINMENTS_UPDATED,
    EDUCATIONAL_ATTAINMENTS_ACTIVE_UPDATED
}
