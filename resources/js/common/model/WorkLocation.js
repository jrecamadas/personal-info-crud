import { BaseModel } from '@common/model/BaseModel';
import WorkLocationResource from '@common/resource/WorkLocationResource';

export class WorkLocation extends BaseModel {
    constructor(data) {
        let relations = {
            'data': WorkLocation
        };

        super(data, relations);
    }

    static get resource() {
        return WorkLocationResource;
    }
}
