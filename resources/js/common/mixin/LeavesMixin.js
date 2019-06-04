// Libraries
import _ from "lodash";

export default {
    data() {
        return {
            leaveCreditTypeNameForPTO: [
                "PTO",
                "Paid Time Off"
            ]
        };
    },
    computed: {
    },
    methods: {
        //This function is affected by the Employee Search issue.
        //Ignore the Console Error regarding undefined 'data'
        positionTextDisplay(positionsData) {
            let pos = (positionsData && positionsData.data.length) ? positionsData.data : [];
            let position = [];

            _.each(pos, (p) => {
                let temp = [];

                if (p.level) {
                    temp.push(p.level);
                }

                temp.push(p.job_title);
                position.push(temp.join(' '));
            });

            return position.length ? position.join(' / ') : 'Unassigned';
        },
        //This function is affected by the Employee Search issue.
        //Ignore the Console Error regarding undefined 'data'
        projectsTextDisplay(projectsData) {
            let projectNamesString = [];
            if (projectsData) {
                if (projectsData.data) {
                    _.each(projectsData.data, (project) => {
                        if (project.clientProject && project.clientProject.data) {
                            projectNamesString.push(
                                project.clientProject.data.project_name
                            );
                        }
                    });
                }
            }
            return projectNamesString.length
                ? projectNamesString.join(", ")
                : "Unassigned";
        },
        //This function is affected by the Employee Search issue.
        //Ignore the Console Error regarding undefined 'data'
        departmentTextDisplay(departmentData) {
            if (departmentData) {
                if (typeof departmentData == 'object' && departmentData.data) {
                    return departmentData.data.name;
                }
                else if (typeof departmentData == 'integer') {
                    return departmentData;
                }
            }
            return "Unassigned";
        },
        //This function is affected by the Employee Search issue.
        //Ignore the Console Error regarding undefined 'data'
        employeeAvailablePTOCreditDisplay(employeeLeaveCreditsData, leaveCreditTypesList) {
            let balance = 0.00;
            if (employeeLeaveCreditsData && employeeLeaveCreditsData.data) {
                _.each(this.findPTOLeaveCreditTypeID(leaveCreditTypesList), (idPTOLeaveCreditType) => {
                    let eLCD = _.filter(employeeLeaveCreditsData.data, ['leave_credit_type_id', idPTOLeaveCreditType]);
                    _.each(eLCD, (leaveCredits) => {
                        if (leaveCredits.leave_credit_type_id === idPTOLeaveCreditType) {
                            balance = balance + parseFloat(leaveCredits.balance);
                        }
                    });
                });
            }

            return balance.toLocaleString(undefined,
                {minimumFractionDigits: 2, maximumFractionDigits: 2});
        },
        //Yearly Total Used PTO Credits, between Previous Regularization Anniversary to the Next
        employeeTotalUsedPTOCreditsDisplay(employeeLeaveRequestsData, leaveTypesList, leaveCreditTypesList) {
            let total = 0.00;
            let ptoLeaveTypeIDs = [];

            if (employeeLeaveRequestsData && employeeLeaveRequestsData.data) {
                //Filter Paid Leaves Only
                let employeeLeaveRequestsArray = _.filter(employeeLeaveRequestsData.data, 'is_paid');
                //Filter Approved Leaves Only
                employeeLeaveRequestsArray = _.filter(employeeLeaveRequestsArray, ['status', 'Approved']);
                //Filter PTO-based Leaves Only
                ptoLeaveTypeIDs = this.findPTOLeaveTypes(
                    leaveTypesList,
                    this.findPTOLeaveCreditTypeID(leaveCreditTypesList)
                );

                employeeLeaveRequestsArray = _.filter(employeeLeaveRequestsArray, (leaveRequest) => {
                    return (leaveRequest.leave_type_id in ptoLeaveTypeIDs) &&
                        (moment(leaveRequest.start_date, 'YYYY-MM-DD').year() == moment().year());
                });
                //Get Total for Half Day/Whole Day
                total = employeeLeaveRequestsArray.map(function(leaveRequest) {
                    return (leaveRequest.duration === 'Half Day')? 0.5 : 1;
                }).reduce(function (total, num) {
                    return total + num;
                }, 0);
            }
            return total.toLocaleString(undefined,
                {minimumFractionDigits: 2, maximumFractionDigits: 2});
        },
        findPTOLeaveCreditTypeID(leaveCreditTypesList) {
            let idPTOLeaveCreditType = [];
            _.each(leaveCreditTypesList, (leaveCreditType) => {
                _.each(this.leaveCreditTypeNameForPTO, (nameForPTO) => {
                    if (leaveCreditType.text === nameForPTO)
                        idPTOLeaveCreditType.push(leaveCreditType.id);
                });
            });

            return idPTOLeaveCreditType;
        },
        findPTOLeaveTypes(leaveTypesList, idPTOLeaveCreditType) {
            let idleaveTypesList = [];
            _.each(idPTOLeaveCreditType, (value) => {
                leaveTypesList = _.filter(leaveTypesList, ['leave_credit_type_id', value]);
                _.each(leaveTypesList, (leaveType) => {
                    idleaveTypesList.push(leaveType.id);
                })
            });
            return idleaveTypesList
        },
        //This function is affected by the Employee Search issue
        //Ignore the Console Error regarding undefined 'data'
        employeeStatusDisplay(employeeStatusesData) {
            let statusDisplay =  "----";
            if (employeeStatusesData && employeeStatusesData.data && employeeStatusesData.data.length) {
                statusDisplay = _.last(employeeStatusesData.data).status.name;
            }
            return statusDisplay;
        },
        getApproverNameFromEmployeeID : function (employeeID, employeeList) {
            let employeeName = "Employee Not Found";
            if (employeeID != null && employeeID) {
                employeeName = _.find(employeeList, ['employee_id', employeeID]).text;
            }
            return employeeName;
        },
    }
}
