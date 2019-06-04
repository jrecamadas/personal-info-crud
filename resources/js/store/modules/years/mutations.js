const YEARS_UPDATED = (state, range) => {
    state.data = [];
    state.formatted = [];

    for (let i = range.max; i >= range.min; i--) {
        state.data.push({
            value: i,
            label: i
        });

        state.formatted.push({
            id: i,
            text: i
        });
    }
}

export {
    YEARS_UPDATED
}
