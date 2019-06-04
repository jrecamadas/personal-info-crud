import { SmartTeamBuilder } from '@common/model/SmartTeamBuilder';

const getSmartTeamBuilders = (context, payload) => {
    return SmartTeamBuilder.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('SMARTTEAMBUILDERS_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
};

const saveSmartTeamBuilder = (context, payload) => {
    const id = payload.id;
    const smartTeamBuilder = (id != "" && id > 0) ? new SmartTeamBuilder({id:id}) : new SmartTeamBuilder();
    return smartTeamBuilder.save(payload).then( (res) => {
        context.commit('EDIT_SMARTTEAMBUILDER', {data: res.data});
    });

};

const deleteSmartTeamBuilder = (context, id) => {
    const smartTeamBuilder = new SmartTeamBuilder({id: id});
    return smartTeamBuilder.delete().then((res) => {
    });
};

const getSmartTeamBuilder = (context, id) => {
    return SmartTeamBuilder.get({id:id}).then((res) => {
        context.commit('EDIT_SMARTTEAMBUILDER', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find skill!');
    })
}

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

export {
    getSmartTeamBuilders,
    getSmartTeamBuilder,
    saveSmartTeamBuilder,
    saveMeta,
    deleteSmartTeamBuilder,
}
