import _ from 'lodash';

const SMARTTEAMBUILDERS_UPDATED = (state, payload) => {
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

const SMARTTEAMBUILDER_UPDATED = (state, payload) => {
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
const EDIT_SMARTTEAMBUILDER = (state, payload) => {
    state.smartTeamBuilder = payload.data
}

const DELETE_SMARTTEAMBUILDER = (state) => {}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

const CLEAR_STATES = (state) => {
    state.data = [];
    state.formatted = [];
    state.meta = {};
    state.smartTeamBuilder = {};
}



export {
    SMARTTEAMBUILDERS_UPDATED,
    SMARTTEAMBUILDER_UPDATED,
    SAVE_META,
    DELETE_SMARTTEAMBUILDER,
    EDIT_SMARTTEAMBUILDER,
    CLEAR_STATES
}
