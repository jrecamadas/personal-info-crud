import { WorkExperience } from '@common/model/WorkExperience';

const getWorkExperience = (context, id) => {
    return WorkExperience.get({id:id}).then((res) => {
        context.commit('WORK_EXPERIENCE_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find Work Experience!');
    })
}

const saveWorkExperience = (context, payload) => {
    const id = payload.id;
    const workExperience = (id != null && id != "" && id > 0) ? new WorkExperience({id:id}) : new WorkExperience();
    return workExperience.save(payload).then( (res) => {
        context.commit('WORK_EXPERIENCE_UPDATED', {data: res.data});
    });
}

const deleteWorkExperience = (context, id) => {
    const workExperience = new WorkExperience({id: id});
    return workExperience.delete().then((res) => {
        context.commit('DELETE_WORK_EXPERIENCE');
    });
};

export {
    getWorkExperience,
    saveWorkExperience,
    deleteWorkExperience
}
