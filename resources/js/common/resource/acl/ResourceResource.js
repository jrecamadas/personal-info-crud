import { BaseResource } from '@common/resource/BaseResource';

class ResourceResource extends BaseResource {
    constructor() {
        let options = {
            url: '/resources/:id'
        };

        super(options);
    }
}

export default new ResourceResource();
