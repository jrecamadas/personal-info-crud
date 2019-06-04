import { BaseModel } from '@common/model/BaseModel';
import EmployeeInterestResource from '@common/resource/EmployeeInterestResource';

export class EmployeeInterest extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeInterest
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeInterestResource;
    }
}
