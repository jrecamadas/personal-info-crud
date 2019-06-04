import { BaseResource } from '@common/resource/BaseResource';

class ClientProjectResource extends BaseResource {
    constructor() {
        let options = {
            url: '/client-projects/:id'
        };
        super(options);
    }
}

export default new ClientProjectResource();
