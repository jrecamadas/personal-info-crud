import { Client } from '@common/model/Client';

const getClients = (context, payload) => {
    return Client.get(payload.query).then(res => {
        context.commit('CLEAR_STATES');
        context.commit('GET_CLIENTS', { data: res.data, extra: payload.extra });
        context.commit('SAVE_META', res.meta);
    });
};

const getClient = (context, id) => {
    return Client.get({id}).then((res) => {
            context.commit('EDIT_CLIENT', { data: res.data });
        })
        .catch(e => {
            throw new Error("Can't find client!");
        });
};

const getSpecificClient = (context, payload) => {
    return Client.get(payload.query).then(res => {
        context.commit('GET_CLIENT', { data: res.data });
    });
};

const saveClient = (context, payload) => {
    const id = payload.id;
    const client = (id != "" && id > 0) ? new Client({id:id}) : new Client();
    return client.save(payload).then( (res) => {
        context.commit('CLIENT_UPDATED', {data: res.data});
    });
};

const deleteClient = (context, id) => {
    const client = new Client({id});
    return client.delete().then(res => {
        context.commit('DELETE_CLIENT');
    });
};

export { saveClient, getClients, getSpecificClient, deleteClient, getClient };
