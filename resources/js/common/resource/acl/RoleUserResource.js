import { BaseResource } from '@common/resource/BaseResource';

class RoleUserResource extends BaseResource {
    constructor() {
        let options = {
            url: '/role-users/:id'
        };

        super(options);
    }
}

export default new RoleUserResource();
