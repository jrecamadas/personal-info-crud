import { BaseModel } from '@common/model/BaseModel';
import EmployeeEducationResource from '@common/resource/EmployeeEducationResource';

export class EmployeeEducation extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeEducation
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeEducationResource;
    }
}
