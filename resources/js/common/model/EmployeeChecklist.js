import { BaseModel } from '@common/model/BaseModel';
import EmployeeChecklistResource from '@common/resource/EmployeeChecklistResource';

export class EmployeeChecklist extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeChecklist
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeChecklistResource;
    }
}
