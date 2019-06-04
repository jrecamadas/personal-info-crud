import { LeaveApprover } from '@common/model/LeaveApprover';

const getApprovers = (context, payload) => {
    return LeaveApprover.get(payload.query).then((res) => {
        context.commit('CLEAR_APPROVERS');
        context.commit('UPDATE_APPROVERS', {data: res.data, extra: payload.extra});
        context.commit('META_SET', res.meta);
    });
};

const getApprover = (context, payload) => {
    return LeaveApprover.get(payload).then((res) => {
        context.commit('UPDATE_APPROVER', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find approver!');
    });
}

const getApproversAll = (context, payload) => {
    return LeaveApprover.get(payload.query).then((res) => {
        context.commit('CLEAR_APPROVERS_ALL');
        context.commit('UPDATE_APPROVERS_ALL', {data: res.data, extra: payload.extra});
    });
}

const saveApprover = (context, payload) => {
    const id    = payload.id;
    const data  = {
        'approver_id': payload.approver_id,
        'oic_id': payload.oic_id
    };
    const approver = (id != '' && id > 0) ? new LeaveApprover({id:id}) : new LeaveApprover();
    return approver.save(data);
}

const clearApprovers = (context) => {
    context.commit('CLEAR_APPROVERS');
};

const deleteApprover = (context, id) => {
    const approver = new LeaveApprover({id: id});
    return approver.delete().then((res) => {
        context.commit('DELETE_APPROVER');
    });
};

const saveMeta = (context, meta) => {
    context.commit('META_SET', meta);
};

export {
    saveMeta,
    getApprovers,
    getApproversAll,
    getApprover,
    clearApprovers,
    deleteApprover,
    saveApprover
}