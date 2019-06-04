import _ from 'lodash';

const GET_CLIENTS = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];
    state.formatted_with_name = [];
    _.each(state.data, (row) => {
        let obj = _.defaults({
            id: row.id,
            company: row.company,
            is_high_growth_client: row.is_high_growth_client,
            contract_signed: row.contract_signed,
            initial_deposit: row.initial_deposit,
            start_guide: row.start_guide,
            first_week_check_up: row.first_week_check_up,
            team_emails_sent: row.team_emails_sent,
            first_month_check_up: row.first_month_check_up,
            status: row.status,
            location: row.location,
            timezone: row.timezone,
            notes: row.notes,
            projects: row.projects
        }, payload.extra);
        let obj2 = _.defaults({
            client_id: row.id,
            text: row.company
        }, payload.extra);
        state.formatted.push(obj);
        state.formatted_with_name.push(obj2);
    });
};

const GET_CLIENT = (state, payload) => {
    state.client = payload.data;
};

const CLIENT_UPDATED = (state, payload) => {
    state.client = payload.data;
};

const EDIT_CLIENT = (state, payload) => {
    state.client = payload.data;
    try {
        state.contact = payload.data.contacts.data[0];
    } catch (e) {
        state.contact = {};
    }
};

const DELETE_CLIENT = state => {};

const CLEAR_STATES = state => {
    state.data = [];
    state.formatted = [];
    state.client = {};
    state.contact = {};
};

const SAVE_META = (state, meta) => {
    state.meta = meta;
};

export { GET_CLIENTS, GET_CLIENT, CLIENT_UPDATED, DELETE_CLIENT, EDIT_CLIENT, CLEAR_STATES, SAVE_META };
