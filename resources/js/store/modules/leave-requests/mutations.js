const PUSH_TO_LEAVE_REQUEST_LIST = (state, payload) => {
    state.list.push(...payload.data);
};

const CLEAR_LEAVE_REQUEST_LIST = (state, payload) => {
    state.list = [];
};

const UPDATE_LEAVE_REQUEST = (state, payload) => {
    state.single = payload.data;
};

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    PUSH_TO_LEAVE_REQUEST_LIST,
    UPDATE_LEAVE_REQUEST,
    CLEAR_LEAVE_REQUEST_LIST,
    SAVE_META
};




