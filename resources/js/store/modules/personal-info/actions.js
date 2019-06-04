import { Personal_Info } from '@common/model/Personal_Info';

const getPersonalInfo = (context, payload) => {
    return Personal_Info.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('PERSONAL_INFO_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
};



const savePersonalInfo = (context, payload) => {
    const id    = payload.id;
    const data  = {
        name:payload.name, 
        address:payload.address, 
        birthday:payload.birthday,
        phone_number:payload.phone_number,
        email:payload.email
    };
    const personalInfo = (id != "" && id > 0) ? new Personal_Info({id:id}) : new Personal_Info();
    return personalInfo.save(data);

};

const deletPersonalInfo = (context, id) => {
    const personalInfo = new Personal_Info({id: id});
    return personalInfo.delete().then((res) => {
        context.commit('DELETE_PERSONAL_INFO');
    });
};

const getInfo = (context, id) => {
    console.log(id,'getInfo DATA');
    const personalInfo = new Personal_Info({id:id});
    console.log(personalInfo,'personalInfo DATA');
    return personalInfo.get({id:id}).then((res) => {
        context.commit('GET_PERSONAL_INFO', res.data);
    }).catch((e) => {
        throw new Error('Can\'t find Information!');
    })
}


const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

const searchPersonalInfo = (context, name) => {
    return Personal_Info.get({name: name, withTrashed: true}).then((res) => {
        context.commit('EDIT_DELETE_PERSONAL', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find skill!');
    })
}

export {
    saveMeta,
    deletPersonalInfo,
    savePersonalInfo,
    getPersonalInfo,
    searchPersonalInfo,
    getInfo
}