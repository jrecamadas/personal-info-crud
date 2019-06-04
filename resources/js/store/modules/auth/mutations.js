const AUTH_DATA_SET = (state, payload) => {
    state.data = payload;
}

const CLEAR_AUTH_DATA = (state) => {
    state.data = null;
}

export {
    AUTH_DATA_SET,
    CLEAR_AUTH_DATA
}
