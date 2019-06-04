import { BaseResource } from '@common/resource/BaseResource';

class WorkFromHomeRequestResource extends BaseResource {
    constructor() {
        let options = {
            url: '/work-from-home/:id'
        };

        super(options);
    }
}

export default new WorkFromHomeRequestResource();
