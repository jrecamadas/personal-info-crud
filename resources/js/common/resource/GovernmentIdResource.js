import { BaseResource } from '@common/resource/BaseResource';

class GovernmentIdResource extends BaseResource {
    constructor() {
        let options = {
            url: '/government-ids/:id'
        };

        super(options);
    }
}

export  default new GovernmentIdResource();
