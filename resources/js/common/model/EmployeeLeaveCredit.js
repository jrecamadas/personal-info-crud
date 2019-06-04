import { BaseModel } from '@common/model/BaseModel';
import EmployeeLeaveCreditResource from '@common/resource/EmployeeLeaveCreditResource';

export class EmployeeLeaveCredit extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeLeaveCredit
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeLeaveCreditResource;
    }
}
