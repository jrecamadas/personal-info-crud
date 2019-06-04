import _ from 'lodash';

const AGENCIES_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.name
        }, payload.extra);

        state.formatted.push(obj);
    });
}

export {
    AGENCIES_UPDATED
}
