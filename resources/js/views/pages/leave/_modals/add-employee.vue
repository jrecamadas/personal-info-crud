<template>
    <modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal">
        <template slot="button">
            <save-button :loading="loading" :options="button" @action="save" :disabled="!isValid">Add Employee</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group" :class="{'has-error': errors.has('searchValue') || hasSSerror}">
                                <div class="row">
                                    <div class="col-sm-2 text-center">
                                        <label>Search<span class="error">*</span></label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            v-model="searchValue">
                                        <span 
                                            v-show="errors.has('searchValue')" 
                                            class="help-block form-error">
                                            {{ errors.first('searchValue') }}
                                        </span>
                                        <span 
                                            v-show="hasSSerror" 
                                            class="help-block form-error">
                                            {{ ssError }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2 text-center">
                                    <label>Filter<span class="error">*</span></label>
                                </div>
                                <div class="col-sm-5">
                                    <select3
                                        :options="searchData.departmentOptions"
                                        :value="searchData.department"
                                        v-validate="'required'"
                                        data-vv-name="department"
                                        name="department"
                                        @select="setDepartment">
                                    </select3>
                                </div>
                                <div class="col-sm-5">
                                    <select3
                                        :options="searchData.projectOptions"
                                        :value="searchData.project"
                                        v-validate="'required'"
                                        data-vv-name="project"
                                        name="project"
                                        @select="setProject">
                                    </select3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div v-if="employees" class="padded-select-all">
                                <input type="checkbox" v-model="selectAllEmployees"> Select All
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="employee-selection-area">
                                <ul>
                                    <li v-for="employee in filtered_employees" :key="employee.id">
                                        <input 
                                            type="checkbox" 
                                            :id="employee.id"
                                            v-model="selected_employee_ids"
                                            :value="employee.id">
                                        <label for="employee.id">{{ employee.name }}</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
    .text-center {
        text-align:center;
    }
    .employee-selection-area {
        overflow-y: scroll;
        height: 200px;
        border: 1px solid grey;
        border-radius: 2px;
        ul {
            -webkit-column-count: 2;
            -moz-column-count: 2;
            column-count: 2;
            margin: 0.5rem 0;
            padding-left: 10px;
            li {
                list-style: none;
            }
        }
    }
    .padded-select-all {
        padding: 5px 10px 0;
    }
    input[type="checkbox"] {
        vertical-align: text-bottom;
    }
</style>

<script>
    import _ from 'lodash';

    //Components
    import GenerateButton from '@components/form/button.vue';
    import SaveButton from '@components/form/button.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import Select3 from '@components/select3.vue';

    import DataTableMixin from '@common/mixin/DataTableMixin'
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import StringHelperMixin from '@common/mixin/StringHelperMixin';

    import { mapActions, mapGetters } from 'vuex';

    export default {
        props: {
            info: { type: Object, required: true}
        },
        data() {
            return {
                valid:false,
                option: { height: 'auto', width: '700px', bottom: 'auto' },
                button: { class: 'btn btn-primary', type: 'button' },
                loading: false,
                manualInput : false,
                selected_employee_ids: [],
                searchValue: '',
                searchData: {
                    department: -1,
                    departmentOptions: [],
                    project: -1,
                    projectOptions: []
                },
                validation: [
                    {
                        path: 'employee_id', 
                        name: 'employee_id', 
                        rule: 'required', 
                        msg: {
                            required: 'The Employees field is required'
                        } 
                    },
                ],
                searchResults: [],
                hasSSerror: false,
                ssError: null,
                selectAllEmployees: false,
                filtered_employees: [],
                employee_ids: [],
                project_list: [],
                project_to_employee: {},
                department_to_employee: {}
            }
        },
        computed: {
            ...mapGetters({
                approver: 'leaveApprovers/approver',
                employees: 'employees/data',
                departments: 'departments/formatted',
                clients: 'clients/formatted',
                employeeApprovers: 'employeeApprovers/data',
                employeeApproversAll: 'employeeApprovers/employeeApproversAll'
            }),
            isValid() {
                return this.selected_employee_ids.length > 0; 
            }
        },
        async created() {
            let _this = this;
            this.searchData.projectOptions.push({id:-1, text:'--All Projects--'});
            this.searchData.departmentOptions.push({id:-1, text:'--All Departments--'});
            this.filtered_employees = this.employees;
            _.each(this.employees, (emp) => {
                //adding entries for department to employees
                _this.employee_ids.push(emp.id);
                if (!(emp.department in _this.department_to_employee)) {
                    _this.department_to_employee[emp.department] = [];    
                }
                _this.department_to_employee[emp.department].push(emp);
                
                //adding entries for project to employees
                if (emp.projects) {
                    _.each(emp.projects.data, (proj) => {
                        let id = proj.client_project_id;
                        if (!(id in this.project_to_employee)) {
                            this.project_to_employee[id] = [];
                        }
                        this.project_to_employee[id].push(proj.employee.data);
                    });
                }
            });

            //adding options for department dropdown
            this.departments.forEach((department) => {
                this.searchData.departmentOptions.push({
                    id: department.id,
                    text: department.text
                });
            });
            //adding options for project dropdown
            _.each(this.clients, (client) => {
                _.each(client.projects.data, (project) => {
                    if(this.project_list.indexOf(project.project_name) == -1) {
                        this.searchData.projectOptions.push({
                            id: project.id,
                            text: project.project_name
                        });
                        this.project_list.push(project.project_name);
                    }
                });
            });

            //Applying the checked employees
            await this.removeEmployeeApproversFromOptions();
        },
        methods: {
            ...mapActions({
                saveEmployeeApprover: 'employeeApprovers/saveEmployeeApprover',
            }),
            save() {
                this.loading = true;
                _.each(this.selected_employee_ids, (id) => {
                    let data = {
                        employee_id: id,
                        leave_approver_id: this.approver.id
                    }
                    this.saveEmployeeApprover(data).then(() => {
                        this.$emit('success');
                        setTimeout(() => {
                            this.removeEmployeeApproversFromOptions();
                            this.closeModal();
                            this.selected_employee_ids = [];
                        }, 150)
                    }).catch((e) => {
                        this.loading = false;
                        this.hasSSerror = true;
                        this.ssError = e.response.data.message;
                    });
                })
            },
            filteredResources: function(searchValue) {
                return this.filtered_employees.filter(s => new RegExp(searchValue, 'i').test(s.name));
            },
            removeEmployeeApproversFromOptions: function() {
                let _this = this;
                _.each(this.employeeApproversAll, (emp) => {
                    _this.employee_ids = _.filter(_this.employee_ids, (emp_ids) => { return emp_ids != emp.employee_id; });
                    _this.filtered_employees = _.filter(_this.filtered_employees, (filtered_emp) => emp.employee_id != filtered_emp.id);
                });
                //removing the approver
                _this.employee_ids = _.filter(_this.employee_ids, (emp_ids) => { return emp_ids != _this.approver.approver_id; });
                // _this.employee_ids = _.remove(_this.employee_ids, _this.approver.approver_id);
                _this.filtered_employees = _.filter(_this.filtered_employees, (filtered_emp) => _this.approver.approver_id != filtered_emp.id);
            },
            setDepartment: function(value) {
                let _this = this;
                this.searchData.department = value;
                let projectHasValue = this.searchData.project > -1;
                if (this.searchData.project == -1 && value == -1) {
                    this.filtered_employees = this.employees;
                    this.removeEmployeeApproversFromOptions();
                    return;
                }
                if (value != -1 && !this.department_to_employee[value]) {
                    this.filtered_employees = [];
                    return;
                }
                this.filtered_employees = [];
                this.employee_ids = [];
                _.each(this.department_to_employee[value], (emp) => {
                    if (projectHasValue) {
                        let project_ids = [];
                        _.each(emp.projects.data, (proj) => {
                            let id = proj.client_project_id;
                            let flagFound = false;
                            if ((!flagFound && id == _this.searchData.project) || value == -1) {
                                _this.filtered_employees.push(emp);
                                _this.employee_ids.push(emp.id);
                                flagFound = true;
                            }
                        });
                    }
                    else {
                        _this.filtered_employees.push(emp);
                        _this.employee_ids.push(emp.id);
                    }
                });
                this.removeEmployeeApproversFromOptions();
            },
            setProject: function(value) {
                let _this = this;
                this.searchData.project = value;
                let departmentHasValue = this.searchData.department > -1;
                if (this.searchData.department == -1 && value == -1) {
                    this.filtered_employees = this.employees;
                    this.removeEmployeeApproversFromOptions();
                    return;
                }
                if (value != -1 && !this.project_to_employee[value]) {
                    this.filtered_employees = [];
                    return;
                }
                this.filtered_employees = [];
                this.employee_ids = [];
                _.each(this.project_to_employee[value], (emp) => {
                    if (departmentHasValue) {
                        if ((emp.department == _this.searchData.department) || value == -1) {
                            _this.filtered_employees.push(emp);
                            _this.employee_ids.push(emp.id);
                        }
                    }
                    else {
                        _this.filtered_employees.push(emp);
                        _this.employee_ids.push(emp.id);
                    }
                });
                this.removeEmployeeApproversFromOptions();
            }
        },
        watch: {
            selectAllEmployees: function(val) {
                this.selected_employee_ids = (val) ? this.employee_ids : [];
            },
            searchValue: function(value) {
                this.filtered_employees = this.employees;
                this.removeEmployeeApproversFromOptions();
                this.filtered_employees = this.filteredResources(value);
            },
            filtered_employees: function(value) {
                this.selectAllEmployees = false;
                this.employee_ids = !_.isEmpty(value) && _.map(value, emp => emp.id);
            }
        },
        components: {
            GenerateButton,
            SaveButton,
            ModalDialog,
            Select3
        },
        mixins: [
            DataTableMixin,
            ModalDialogMixin,
            StringHelperMixin
        ]
    }
</script>