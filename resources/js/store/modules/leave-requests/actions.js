import {LeaveRequest} from '@common/model/LeaveRequest';

const getLeaveRequestList = (context, payload) => {
    return LeaveRequest.get(payload.query).then((data) => {
        context.commit('PUSH_TO_LEAVE_REQUEST_LIST', data);
        return data;
    });
};

const getLeaveRequestPerEmployee = (context, payload) => {
    return LeaveRequest.get(payload.query).then((data) => {
        context.commit('UPDATE_LEAVE_REQUEST', data);
        return data;
    });
};

const clearLeaveRequestList = (context, payload) => {
    context.commit('CLEAR_LEAVE_REQUEST_LIST', {});
};

const saveLeaveRequest = (context, payload) => {
    const id = payload.id;
    const leaveRequest = (id !== '' && id > 0)
        ? new LeaveRequest({id: id})
        : new LeaveRequest();
    return leaveRequest.save(payload).then((res) => {

        context.commit('UPDATE_LEAVE_REQUEST', {data: res.data});
    });

};

const getLeaveRequest = (context, payload) => {
    return LeaveRequest.get(payload.query).then((res) => {
        context.commit('UPDATE_LEAVE_REQUEST', {data: res.data});
    });
};

export {
    getLeaveRequestList,
    getLeaveRequestPerEmployee,
    saveLeaveRequest,
    clearLeaveRequestList,
    getLeaveRequest
};
