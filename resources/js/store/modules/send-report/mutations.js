import _ from 'lodash';

const SEND_REPORT = (state, payload) => {
    state.data = payload;
    state.formatted = [];
}

export {
    SEND_REPORT
}
