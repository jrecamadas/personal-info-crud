import { BaseResource } from '@common/resource/BaseResource';

class UserRoleResource extends BaseResource {
    constructor() {
        let options = {
            url: '/user-roles/:id'
        };

        super(options);
    }
}

export default new UserRoleResource();
