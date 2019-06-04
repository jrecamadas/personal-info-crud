import { LeaveCreditType } from '@common/model/LeaveCreditType';

//Read all Leave Credit Types and Save to Store
const getLeaveCreditTypes = (context, payload) => {
    return LeaveCreditType.get(payload.query).then((res) => {
    	context.commit('CLEAR_LEAVE_CREDIT_TYPES');
        context.commit('GET_LEAVE_CREDIT_TYPES', res);
        context.commit('SET_META', res.meta);
    })
}

//Read one Leave Credit Type
const getLeaveCreditType = (context, id) => {
    return LeaveCreditType.get({id:id}).then((res) => {
        context.commit('GET_LEAVE_CREDIT_TYPE', res.data);
    }).catch((e) => {
        throw new Error('Can\'t find Leave Credit Type!');
    })
}

//Create or Update Leave Credit Type
const saveLeaveCreditType = (context, payload) => {
	const id    = payload.id;
    const data  = {name: payload.name, limit: payload.limit};
    const leaveCreditType = (id != "" && id > 0) ? new LeaveCreditType({id:id}) : new LeaveCreditType();
    return leaveCreditType.save(data);
}

//Delete Leave Credit Type
const deleteLeaveCreditType = (context, id) => {
    const leaveCreditType = new LeaveCreditType({id: id});
    return leaveCreditType.delete().then((res) => {
        context.commit('DELETE_LEAVE_CREDIT_TYPE');
    });
};

//Clear State
const clearLeaveCreditTypes = (context) => {
    context.commit('CLEAR_LEAVE_CREDIT_TYPES');
};

//Save Metadata
const saveMeta = (context, meta) => {
    context.commit('SET_META', meta);
};

export {
    getLeaveCreditTypes,
    getLeaveCreditType,
    deleteLeaveCreditType,
    clearLeaveCreditTypes,
    saveLeaveCreditType,
    saveMeta,
}
