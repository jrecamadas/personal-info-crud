import { BaseModel } from '@common/model/BaseModel';
import WorkFromHomeRequestResource from '@common/resource/WorkFromHomeRequestResource';

export class WorkFromHomeRequest extends BaseModel {
    constructor(data) {
        let relations = {
            'data': WorkFromHomeRequest
        };

        super(data, relations);
    }

    static get resource() {
        return WorkFromHomeRequestResource;
    }
}
