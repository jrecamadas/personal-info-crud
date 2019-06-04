import { BaseModel } from '@common/model/BaseModel';
import EmployeeJobPositionResource from '@common/resource/EmployeeJobPositionResource';

export class EmployeeJobPosition extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeJobPosition
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeJobPositionResource;
    }
}
