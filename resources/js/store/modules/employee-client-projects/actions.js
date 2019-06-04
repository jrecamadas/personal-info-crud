import { EmployeeClientProject } from '@common/model/EmployeeClientProject';

const saveResource = (context, data) => {
    const id = data.id;
    const employeeClientProject = (id != null && id != '') ? new EmployeeClientProject({id:id}) : new EmployeeClientProject();
    return employeeClientProject.save(data).then( (res) => {
        context.commit('RESOURCE_UPDATED', {data: res.data});
    });
}

const getResource = (context, id) => {
    return EmployeeClientProject.get({id:id}).then((res) => {
        context.commit('RESOURCE_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find resource!');
    })
}

const searchResource = (context, id) => {
    return EmployeeClientProject.get({employee_id: id, query: {}}).then((res) => {
        context.commit('RESOURCE_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find resource! -- ');
    })
}

const getProjectsOfResource = (context, payload) => {
    return EmployeeClientProject.get(payload).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_RESOURCE_PROJECTS', {data: res.data});
    });
}

const getResourcesByProject = (context, payload) => {
    return EmployeeClientProject.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_RESOURCES', {data: res.data});
    });
}

const getResources = (context) => {
    return EmployeeClientProject.get().then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_RESOURCES', {data: res.data});
    });
};

const deleteResource = (context, id) => {
    const resource = new EmployeeClientProject({id: id});
    return resource.delete().then(() => {
        context.commit('DELETE_RESOURCE');
    });
};

export {
    getResource,
    saveResource,
    getResources,
    searchResource,
    deleteResource,
    getResourcesByProject,
    getProjectsOfResource
}

