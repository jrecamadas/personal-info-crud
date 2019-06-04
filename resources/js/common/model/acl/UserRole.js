import { BaseModel } from '@common/model/BaseModel';
import UserRoleResource from '@common/resource/acl/UserRoleResource';

export class UserRole extends BaseModel {
    constructor(data) {
        let relations = {
            'data': UserRole
        };

        super(data, relations);
    }

    static get resource() {
        return UserRoleResource;
    }
}
