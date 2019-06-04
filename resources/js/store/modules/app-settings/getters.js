const getFullNameText = (state, payload) => {
    return state.fullNameText
};

const getFullNameTextAllCaps = (state, payload) => {
    return state.fullNameText.toUpperCase()
};

const getShortNameText = (state, payload) => {
    return state.shortNameText
};

const getShortNameTextAllCaps = (state, payload) => {
    return state.shortNameText.toUpperCase()
};

const getFullScaleLogo = (state, payload) => {
    return state.fullScaleLogo;
};

const defaultVal = (state, payload) => {
    return state.shortNameText
};

export {
    getFullNameText,
    getFullNameTextAllCaps,
    getShortNameText,
    getShortNameTextAllCaps,
    getFullScaleLogo,
    defaultVal
}
