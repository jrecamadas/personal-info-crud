import { BaseModel } from '@common/model/BaseModel';
import EmployeeSpouseResource from '@common/resource/EmployeeSpouseResource';

export class EmployeeSpouse extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeSpouse
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeSpouseResource;
    }
}
