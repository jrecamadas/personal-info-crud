import { BaseResource } from '@common/resource/BaseResource';

class ResourceRolePermissionResource extends BaseResource {
    constructor() {
        let options = {
            url: '/role-permissions/:id'
        };

        super(options);
    }
}

export default new ResourceRolePermissionResource();
