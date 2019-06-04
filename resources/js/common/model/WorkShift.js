import { BaseModel } from '@common/model/BaseModel';
import WorkShiftResource from '@common/resource/WorkShiftResource';

export class WorkShift extends BaseModel {
    constructor(data) {
        let relations = {
            'data': WorkShift
        };

        super(data, relations);
    }

    static get resource() {
        return WorkShiftResource;
    }
}
