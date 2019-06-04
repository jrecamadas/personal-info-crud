import { BaseResource } from '@common/resource/BaseResource';

class StatusResource extends BaseResource {
    constructor() {
        let options = {
            url: '/status/:id'
        };

        super(options);
    }
}

export default new StatusResource();
