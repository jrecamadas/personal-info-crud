const setAuthData = (context, payload) => {
    context.commit('AUTH_DATA_SET', payload);
}

export {
    setAuthData
}
