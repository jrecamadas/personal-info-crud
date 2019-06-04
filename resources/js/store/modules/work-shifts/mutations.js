import _ from 'lodash';

const WORK_SHIFTS_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            text: `${row.shift} (${row.start_time} - ${row.end_time})`
        }, payload.extra);

        state.formatted.push(obj);
    });
}

const CLEAR_ITEMS = (state) => {
    state.data = [];
    state.formatted = [];
}

export {
    WORK_SHIFTS_UPDATED,
    CLEAR_ITEMS
}
