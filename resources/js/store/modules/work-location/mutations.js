import _ from 'lodash';

const WORK_LOCATIONS_UPDATED = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let roomNumber = row.room_number ? 'Rm. ' + row.room_number + ', ' : '';
        let floor = row.floor && row.floor !== ' ' ? row.floor + ' floor, ' : '';
        let building = row.building && row.building !== ' ' ? row.building + ', ' : '';

        const obj = _.defaults({
            id: row.id,
            text: `${roomNumber} ${floor} ${building} ${row.city}, ${row.country_code}`
        }, payload.extra);

        state.formatted.push(obj);
    });
}

const CLEAR_ITEMS = (state) => {
    state.data = [];
    state.formatted = [];
}

export {
    WORK_LOCATIONS_UPDATED,
    CLEAR_ITEMS
}
