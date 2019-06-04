import { Address } from '@common/model/Address';

const getAddresses = (context, payload) => {
    return Address.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_ADDRESSES', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
};

const getAddress = (context, id) => {
    return Address.get({id:id}).then((res) => {
        context.commit('ADDRESS_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find address!');
    })
}

const saveAddress = (context, payload) => {
    const id = payload.id;
    const address = (id != null && id != "" && id > 0) ? new Address({id:id}) : new Address();
    return address.save(payload).then( (res) => {
        context.commit('ADDRESS_UPDATED', {data: res.data});
    });
};

const deleteAddress = (context, id) => {
    const address = new Address({id: id});
    return address.delete().then((res) => {
        context.commit('DELETE_ADDRESS');
    });
};

export {
    getAddresses,
    getAddress,
    saveAddress,
    deleteAddress
}
