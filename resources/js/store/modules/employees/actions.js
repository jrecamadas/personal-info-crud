import { Employee } from '@common/model/Employee';
import { BaseResource } from '@common/resource/BaseResource';

// get all employees
const getEmployees = (context, payload) => {
    return Employee.get(payload.query).then((res) => {
        context.commit('EMPLOYEES_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('EMPLOYEES_WITH_DEPARTMENT_FORMAT', {data: res.data, extra: payload.extra});
        context.commit('META_SET', res.meta);
    });
};

// get all employee names
const getEmployeeNames = (context, payload) => {
    return Employee.get(payload.query).then((res) => {
        context.commit('GET_EMPLOYEES', {data: res.data});
        context.commit('META_SET', res.meta);
    });
};

// get single employee specified by id
const getEmployee = (context, query) => {
    return Employee.get(query).then((res) => {
        context.commit('EMPLOYEE_UPDATED', res.data);
    })
        .catch((e) => {
            throw new Error('Can\'t find employee');
        });
}

// get user that's also employee specified by id
const getUserEmployee = (context, query) => {
    return Employee.get(query).then((res) => {
        context.commit('USER_EMPLOYEE_UPDATED', res.data);
    }).catch((e) => {
        throw new Error('Can\'t find employee');
    });
}

// delete an employee
const deleteEmployee = (context, id) => {
    const employee = new Employee({id: id});
    return employee.delete();
}

// check employee no. if exists
const checkEmployeeNoIfExists = (context, payload) => {
    return Employee.get(payload);
}

// do advance search
const advanceSearch = (context, payload) => {
    let resource = new BaseResource({url: `/employees/advance-search`})
    return resource.get(payload.query).then((res) => {
        res = res.data;
        context.commit('EMPLOYEES_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('EMPLOYEES_WITH_DEPARTMENT_FORMAT', {data: res.data, extra: payload.extra});
        context.commit('META_SET', res.meta);
    });
}

/**
* `getLoggedInEmployee`
* gets the employee object of the logged in user.
* this is ONLY USED during successful login process.
*
* @params {context}
* @params {query} object                     - this is an object which has keys from the database columns and value of anything.
*
* @return {object} Employee Object           - Employee Object
*/
const getLoggedInEmployee = (context, query) => {
    return Employee.get(query).then((res) => {
        context.commit('UPDATE_LOGGED_IN_EMPLOYEE', res.data);
    }).catch((e) => {
        throw new Error('Can\'t find employee');
    });
};

export {
    getEmployees,
    getEmployeeNames,
    getEmployee,
    getUserEmployee,
    deleteEmployee,
    checkEmployeeNoIfExists,
    getLoggedInEmployee,
    advanceSearch
}
