import { BaseModel } from '@common/model/BaseModel';
import RoleResource from '@common/resource/acl/RoleResource';

export class Role extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Role
        };

        super(data, relations);
    }

    static get resource() {
        return RoleResource;
    }
}
