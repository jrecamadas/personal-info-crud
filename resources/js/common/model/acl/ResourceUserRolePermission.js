import { BaseModel } from '@common/model/BaseModel';
import ResourceUserRolePermissionResource from '@common/resource/acl/ResourceUserRolePermissionResource';

export class ResourceUserRolePermission extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ResourceUserRolePermission
        };

        super(data, relations);
    }

    static get resource() {
        return ResourceUserRolePermissionResource;
    }
}
