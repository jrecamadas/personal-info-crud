const GET_EMP_STATUSES = (state, payload) => {
    state.data = payload.data;
    state.formatted = [];

    // format data for use with the component
    _.each(state.data, (row) => {
        let obj = _.defaults({

        }, payload.extra);
    
        state.formatted.push(obj);
    });
}

export {
    GET_EMP_STATUSES
}
