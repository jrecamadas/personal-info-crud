import { BaseModel } from '@common/model/BaseModel';
import EmployeeOtherDetailResource from '@common/resource/EmployeeOtherDetailResource';

export class EmployeeOtherDetail extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeOtherDetail
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeOtherDetailResource;
    }
}
