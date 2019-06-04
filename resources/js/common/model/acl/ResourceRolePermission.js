import { BaseModel } from '@common/model/BaseModel';
import ResourceRolePermissionResource from '@common/resource/acl/ResourceRolePermissionResource';

export class ResourceRolePermission extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ResourceRolePermission
        };

        super(data, relations);
    }

    static get resource() {
        return ResourceRolePermissionResource;
    }
}
