import { BaseResource } from '@common/resource/BaseResource';

class ClientProjectStatusResource extends BaseResource {
    constructor() {
        let options = {
            url: '/client-project-status/:id'
        };
        super(options);
    }
}
export default new ClientProjectStatusResource();
