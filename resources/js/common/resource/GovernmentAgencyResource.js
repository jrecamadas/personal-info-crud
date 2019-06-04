import { BaseResource } from '@common/resource/BaseResource';

class GovernmentAgencyResource extends BaseResource {
    constructor() {
        let options = {
            url: '/government-agencies/:id'
        };

        super(options);
    }
}

export default new GovernmentAgencyResource();
