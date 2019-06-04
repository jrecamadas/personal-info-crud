import { BaseModel } from '@common/model/BaseModel';
import EmployeeLocationResource from '@common/resource/EmployeeLocationResource';

export class EmployeeLocation extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeLocation
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeLocationResource;
    }
}
