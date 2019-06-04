import { BaseModel } from '@common/model/BaseModel';
import GovernmentAgencyResource from '@common/resource/GovernmentAgencyResource';

export class GovernmentAgency extends BaseModel {
    constructor(data) {
        let relations = {
            'data': GovernmentAgency
        };

        super(data, relations);
    }

    static get resource() {
        return GovernmentAgencyResource;
    }
}
