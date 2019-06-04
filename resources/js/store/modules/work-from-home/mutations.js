const PUSH_TO_WFH_REQUEST_LIST = (state, data) => {
    state.list.push(...data);
};

const CLEAR_WFH_REQUEST_LIST = (state, payload) => {
    state.list = [];
};

const SAVE_META = (state, meta) => {
    state.meta = meta;
};

export {
    PUSH_TO_WFH_REQUEST_LIST,
    CLEAR_WFH_REQUEST_LIST,
    SAVE_META,
};
