import { BaseModel } from '@common/model/BaseModel';
import EmployeeApproverResource from '@common/resource/EmployeeApproverResource';

export class EmployeeApprover extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeApprover
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeApproverResource;
    }
}
