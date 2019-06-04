import { BaseResource } from '@common/resource/BaseResource';

class WorkLocationResource extends BaseResource {
    constructor() {
        let options = {
            url: '/work-location/:id'
        };

        super(options);
    }
}

export default new WorkLocationResource();
