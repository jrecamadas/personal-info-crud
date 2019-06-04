import { BaseResource } from '@common/resource/BaseResource';

class JobPositionResource extends BaseResource {
    constructor() {
        let options = {
            url: '/job-positions/:id'
        };

        super(options);
    }
}

export  default new JobPositionResource();
