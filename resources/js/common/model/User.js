import { BaseModel } from '@common/model/BaseModel';
import UserResource from '@common/resource/UserResource';

export class User extends BaseModel {
    constructor(data) {
        let relations = {
            'data': User
        };

        super(data, relations);
    }

    static get resource() {
        return UserResource;
    }

    static me(refresh) {
        if (!this._me || refresh) {
            let data = {
                id: 'me',
                include: 'roles.role,roles.permissions, roles.permissions.resource, roles.role.permissions.resource, employeeId'
            }

            this._me = this.get(data);
        }

        return this._me;
    }
}
