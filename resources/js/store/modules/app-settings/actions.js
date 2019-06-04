const setDefaultVal = (context, defaultVal) => {
    context.commit('ORGANIZATION_NAME_DEFAULT_SET', defaultVal);
};

export {
    setDefaultVal
}
