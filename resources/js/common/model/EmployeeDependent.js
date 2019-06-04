import { BaseModel } from '@common/model/BaseModel';
import EmployeeDependentResource from '@common/resource/EmployeeDependentResource';

export class EmployeeDependent extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeDependent
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeDependentResource;
    }
}
