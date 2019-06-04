import { EmployeeChecklist } from '@common/model/EmployeeChecklist';

// get all employee checklist
const getEmployeeChecklists = (context, eid) => {
    return EmployeeChecklist.get({eid}).then((res) => {
        context.commit('EMPLOYEE_CHECKLIST_UPDATED', {data: res.data});
    });
};

// get specific checklist
const getEmployeeChecklist = (context, id) => {
    return EmployeeChecklist.get({id:id}).then((res) => {
        context.commit('EMPLOYEE_CHECKLIST_UPDATED', {data: res});
    })
}

// delete an employee checklist
const deleteEmployeeChecklist = (context, id) => {
    const employeeChecklist = new EmployeeChecklist({id: id});
    return employeeChecklist.delete();
}

export {
    getEmployeeChecklists,
    getEmployeeChecklist,
    deleteEmployeeChecklist,
}

