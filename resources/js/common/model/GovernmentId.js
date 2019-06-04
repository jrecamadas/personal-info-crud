import { BaseModel } from '@common/model/BaseModel';
import GovernmentIdResource from '@common/resource/GovernmentIdResource';

export class GovernmentId extends BaseModel {
    constructor(data) {
        let relations = {
            'data': GovernmentId
        };

        super(data, relations);
    }

    static get resource() {
        return GovernmentIdResource;
    }
}
