import { ClientProject } from '@common/model/ClientProject';
import { ClientProjectStatus } from '@common/model/ClientProjectStatus';

const saveProject = (context, data) => {
    const id = data.id;
    const clientProject = (id && id != "" && id > 0) ? new ClientProject({id:id}) : new ClientProject();
    return clientProject.save(data).then( (res) => {
        context.commit('CLIENT_PROJECT_UPDATED', {data: res.data});
    });
}

const getProject = (context, id) => {
    return ClientProject.get({id:id}).then((res) => {
        context.commit('CLIENT_PROJECT_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find project!');
    })
}

const getProjectStatuses = (context) => {
    return ClientProjectStatus.get().then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_CLIENT_PROJECTSTATUSES', {data: res.data});
    });
};

const getProjects = (context) => {
    return ClientProject.get().then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_CLIENT_PROJECTS', {data: res.data});
    });
};

const getClientProjects = (context, payload) => {
    return ClientProject.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_CLIENT_PROJECTS', {data: res.data});
        context.commit('SAVE_META', res.meta);
    });
};

const deleteProject = (context, id) => {
    const contact = new ClientProject({id: id});
    return contact.delete().then((res) => {
        context.commit('DELETE_CLIENT_PROJECT');
    });
};

export {
    getProjectStatuses,
    saveProject,
    getProject,
    deleteProject,
    getProjects,
    getClientProjects
}
