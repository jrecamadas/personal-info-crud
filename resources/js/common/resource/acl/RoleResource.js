import { BaseResource } from '@common/resource/BaseResource';

class RoleResource extends BaseResource {
    constructor() {
        let options = {
            url: '/roles/:id'
        };

        super(options);
    }
}

export default new RoleResource();
