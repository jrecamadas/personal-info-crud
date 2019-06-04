import { BaseModel } from '@common/model/BaseModel';
import EmployeeLeaveCreditHistoryResource from '@common/resource/EmployeeLeaveCreditHistoryResource';

export class EmployeeLeaveCreditHistory extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeLeaveCreditHistory
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeLeaveCreditHistoryResource;
    }
}
