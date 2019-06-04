import { BaseModel } from '@common/model/BaseModel';
import EmployeeReportResource from '@common/resource/EmployeeReportResource';

export class EmployeeReport extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeReport
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeReportResource;
    }
}
