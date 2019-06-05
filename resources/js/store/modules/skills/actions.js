import { Skill } from '@common/model/Skill';

const getSkills = (context, payload) => {
    return Skill.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('SKILLS_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
};

const saveSkill = (context, payload) => {
    const id    = payload.id;
    const data  = {name:payload.name, description:payload.description};
    const skill = (id != "" && id > 0) ? new Skill({id:id}) : new Skill();
    return skill.save(data);

};

const deleteSkill = (context, id) => {
    const skill = new Skill({id: id});
    return skill.delete().then((res) => {
        context.commit('DELETE_SKILL');
    });
};

const getSkill = (context, id) => {
    return Skill.get({id:id}).then((res) => {
        context.commit('EDIT_SKILL', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find skill!');
    })
}

const searchSkillByName = (context, name) => {
    return Skill.get({name: name, withTrashed: true}).then((res) => {
        context.commit('EDIT_SKILL', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find skill!');
    })
}

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

export {
    getSkills,
    getSkill,
    saveSkill,
    saveMeta,
    deleteSkill,
    searchSkillByName
}
