const GET_LEAVE_REQUESTS = (state, payload) => {
    state.data = payload.data;
}

const LEAVE_REQUEST_UPDATED = (state, payload) => {
    state.single = payload.data;
}

export {
    GET_LEAVE_REQUESTS,
    LEAVE_REQUEST_UPDATED
}
