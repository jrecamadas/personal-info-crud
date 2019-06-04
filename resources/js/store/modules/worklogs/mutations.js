import _ from 'lodash'


const CLEAR_STATES = (state) => {
    state.parseHistory = []
    state.formatted = []
    state.dropdownIndeces = {}
    state.meta = {}
}

const PARSE_HISTORY_UPDATED = (state, payload) => {
    state.parseHistory = payload.parseHistory
    let tempObjc = {};
    let ctr = 0;

    for (let index = state.parseHistory.length - 1; index >= 0; index--) {
        let exists = !!tempObjc[state.parseHistory[index]['batchGroupId']]
        if (exists) {
            tempObjc[state.parseHistory[index]['batchGroupId']].push(state.parseHistory[index])
        } else {
            tempObjc[state.parseHistory[index]['batchGroupId']] = [state.parseHistory[index]]
            state.formatted.push(tempObjc[state.parseHistory[index]['batchGroupId']])
            state.dropdownIndeces[ctr] = 0
            ctr++;
        }
    }
}

const SAVE_META = (state, meta) => {
    state.meta = meta;
}

export {
    CLEAR_STATES,
    PARSE_HISTORY_UPDATED,
    SAVE_META,
}
