import { BaseResource } from '@common/resource/BaseResource';

class ClientResource extends BaseResource {
    constructor() {
        let options = {
            url: '/clients/:id'
        };

        super(options);
    }
}

export default new ClientResource();
