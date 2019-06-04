import { WorkLog } from '@common/model/WorkLog'

const getParseHistory = (context, payload) => {
    return WorkLog.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES')
        context.commit('PARSE_HISTORY_UPDATED', {parseHistory: res.data, extra: payload.extra})
        context.commit('SAVE_META', res.meta)
    }).catch((e) => {
        throw new Error('Something went wrong: ' + e);
    })
}

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta)
}

export {
    getParseHistory,
    saveMeta,
}
