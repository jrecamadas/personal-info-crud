const data = state => state.data;
const single = state => state.single;
const user = state => state.user;
const formatted = state => state.formatted;
const meta = state => state.meta;
const formatted_with_department = state => state.formatted_with_department;
const logged_in_employee = state => state.logged_in_employee;
const formatted_with_id = state => state.formatted_with_id;
const formatted_with_name = state => state.formatted_with_name;

export {
    data,
    formatted,
    formatted_with_department,
    formatted_with_id,
    formatted_with_name,
    single,
    meta,
    logged_in_employee,
    user,
}
