import { BaseModel } from '@common/model/BaseModel';
import EmployeeStatusResource from '@common/resource/EmployeeStatusResource';

export class EmployeeStatus extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeStatus
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeStatusResource;
    }
}
