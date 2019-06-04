import { EmployeeLocation } from '@common/model/EmployeeLocation';

const getEmployeeLocations = (context, payload) => {
    return EmployeeLocation.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_EMPLOYEE_LOCATIONS', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
}

const getEmployeeLocation = (context, id) => {
    return EmployeeLocation.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_LOCATION_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find employee location!');
    })
}

const getEmployeeLocationByEmployeeID = (context, payload) => {
    return EmployeeLocation.get(payload.query).then((res) => {
        context.commit('EMPLOYEE_LOCATION_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find employee location!');
    })
}

const saveEmployeeLocation = (context, payload) => {
    const id = payload.id;
    const employeeLocation = (id != null && id != "" && id > 0) ? new EmployeeLocation({id:id}) : new EmployeeLocation();
    return employeeLocation.save(payload).then( (res) => {
        context.commit('EMPLOYEE_LOCATION_UPDATED', {data: res.data});
    });
}

const deleteEmployeeLocation = (context, id) => {
    const employeeLocation = new EmployeeLocation({id: id});
    return employeeLocation.delete().then(() => {
        context.commit('DELETE_EMPLOYEE_LOCATION');
    });
};

export {
    getEmployeeLocations,
    getEmployeeLocation,
    getEmployeeLocationByEmployeeID,
    saveEmployeeLocation,
    deleteEmployeeLocation
}