import { BaseModel } from '@common/model/BaseModel';
import EmployeeWorkShiftResource from '@common/resource/EmployeeWorkShiftResource';

export class EmployeeWorkShift extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeWorkShift
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeWorkShiftResource;
    }
}
