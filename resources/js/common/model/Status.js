import { BaseModel } from '@common/model/BaseModel';
import StatusResource from '@common/resource/StatusResource';

export class Status extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Status
        };

        super(data, relations);
    }

    static get resource() {
        return StatusResource;
    }
}
