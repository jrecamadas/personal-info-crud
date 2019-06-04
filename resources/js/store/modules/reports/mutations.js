import _ from 'lodash';

const REPORT_LIST = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: row.type
        }, payload.extra);

        state.formatted.push(obj);
    });
}

export {
    REPORT_LIST
}
