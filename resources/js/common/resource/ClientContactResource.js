import { BaseResource } from '@common/resource/BaseResource';

class ClientContactResource extends BaseResource {
    constructor() {
        let options = {
            url: '/client-contacts/:id'
        };

        super(options);
    }
}

export default new ClientContactResource();
