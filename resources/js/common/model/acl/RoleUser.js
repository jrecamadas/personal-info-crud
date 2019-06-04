import { BaseModel } from '@common/model/BaseModel';
import RoleUserResource from '@common/resource/acl/RoleUserResource';

export class RoleUser extends BaseModel {
    constructor(data) {
        let relations = {
            'data': RoleUser
        };

        super(data, relations);
    }

    static get resource() {
        return RoleUserResource;
    }
}
