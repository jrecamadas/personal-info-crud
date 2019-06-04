import {LeaveType} from '@common/model/LeaveType';

//Read all Leave Credit Types and Save to Store
const getLeaveTypes = (context, payload) => {
    return LeaveType.get(payload.query).then((res) => {
    	context.commit('CLEAR_LEAVE_TYPES');
        context.commit('GET_LEAVE_TYPES', res);
        context.commit('SET_META', res.meta);
    })
}

//Read one Leave Credit Type
const getLeaveType = (context, id) => {
    return LeaveType.get({id:id}).then((res) => {
        context.commit('GET_LEAVE_TYPE', res.data);
    }).catch((e) => {
        throw new Error('Can\'t find Leave Credit Type!');
    })
}

//Create or Update Leave Credit Type
const saveLeaveType = (context, payload) => {
	const id    = payload.id;
    const data  = {
        name: payload.name,
        is_enabled: payload.is_enabled,
        leave_credit_type_id: payload.leave_credit_type_id
    };
    const leaveType = (id != "" && id > 0) ? new LeaveType({id:id}) : new LeaveType();
    return leaveType.save(data);
}

//Delete Leave Credit Type
const deleteLeaveType = (context, id) => {
    const leaveType = new LeaveType({id: id});
    return leaveType.delete().then((res) => {
        context.commit('DELETE_LEAVE_TYPE');
    });
};

//Clear State
const clearLeaveTypes = (context) => {
    context.commit('CLEAR_LEAVE_TYPES');
};

//Save Metadata
const saveMeta = (context, meta) => {
    context.commit('SET_META', meta);
};

export {
    getLeaveTypes,
    getLeaveType,
    deleteLeaveType,
    clearLeaveTypes,
    saveLeaveType,
    saveMeta,
}
