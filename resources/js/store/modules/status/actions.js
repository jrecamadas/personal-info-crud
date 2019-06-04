import { Status } from '@common/model/Status';

const getStatuses = (context, payload) => {
    return Status.get(payload.query).then((res) => {
      context.commit('GET_STATUSES', res);
    //    context.commit('CLEAR_STATES');
    //    context.commit('STATUS_UPDATED', {data: res.data, extra: payload.extra});
       context.commit('SAVE_META', res.meta);
    })
};

const getStatus = (context, id) => {
    return Status.get({id:id}).then((res) => {
        context.commit('EDIT_STATUSES', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find status!');
    })
};

const saveStatus = (context, payload) => {
    const id    = payload.id;
    const data  = {name:payload.name, description:payload.description};
    const status = (id != "" && id > 0) ? new Status({id:id}) : new Status();
    return status.save(data);

};

const searchStatusByName = (context, name) => {
    return Status.get({search: name}).then((res) => {
        context.commit('EDIT_STATUS', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find status!');
    })
};

const deleteStatus = (context, id) => {
    const status = new Status({id: id});
    return status.delete().then((res) => {
        context.commit('DELETE_STATUS');
    });
};

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

const getEmployeeStatus = (context, payload) => {
    return Status.get(payload.query).then((res) => {
        context.commit('GET_EMPLOYEE_STATUSES', res);
    })
}
export {
    getStatuses,
    saveStatus,
    deleteStatus,
    searchStatusByName,
    saveMeta,
    getStatus,
    getEmployeeStatus
}
