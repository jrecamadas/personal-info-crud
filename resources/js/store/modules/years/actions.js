const getYears = (context, range) => {
    context.commit('YEARS_UPDATED', range);
}

export {
    getYears
}
