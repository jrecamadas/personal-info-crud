import { BaseModel } from '@common/model/BaseModel';
import EmployeeClientProjectResource from '@common/resource/EmployeeClientProjectResource';

export class EmployeeClientProject extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeClientProject
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeClientProjectResource;
    }
}
