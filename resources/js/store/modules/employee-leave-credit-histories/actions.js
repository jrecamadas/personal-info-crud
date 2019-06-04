import { EmployeeLeaveCreditHistory } from '@common/model/EmployeeLeaveCreditHistory';

const saveEmployeeLeaveCreditHistory = (context, payload) => {
  const id = payload.id;
  const employeeLeaveCreditHistory = (id !== "" && id > 0) ? new EmployeeLeaveCreditHistory({id:id}) : new EmployeeLeaveCreditHistory();
  return employeeLeaveCreditHistory.save(payload).then( (res) => {
    context.commit('EMPLOYEE_LEAVE_CREDIT_HISTORY_UPDATED', {data: res.data});
  });

};

export {
  saveEmployeeLeaveCreditHistory
}
