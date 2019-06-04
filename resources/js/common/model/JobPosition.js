import { BaseModel } from '@common/model/BaseModel';
import JobPositionResource from '@common/resource/JobPositionResource';

export class JobPosition extends BaseModel {
    constructor(data) {
        let relations = {
            'data':JobPosition
        };

        super(data, relations);
    }

    static get resource() {
        return JobPositionResource;
    }
}
