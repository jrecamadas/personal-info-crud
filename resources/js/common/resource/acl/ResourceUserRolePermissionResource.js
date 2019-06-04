import { BaseResource } from '@common/resource/BaseResource';

class ResourceUserRolePermissionResource extends BaseResource {
    constructor() {
        let options = {
            url: '/user-role-permissions/:id'
        };

        super(options);
    }
}

export default new ResourceUserRolePermissionResource();
