import { BaseModel } from '@common/model/BaseModel';
import DepartmentResource from '@common/resource/DepartmentResource';

export class Department extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Department
        };

        super(data, relations);
    }

    static get resource() {
        return DepartmentResource;
    }
}
