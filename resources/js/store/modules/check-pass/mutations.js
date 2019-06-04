import _ from 'lodash';

const CHECK_PASS = (state, payload) => {
    state.data = payload;
    state.formatted = [];
}

export {
    CHECK_PASS
}
