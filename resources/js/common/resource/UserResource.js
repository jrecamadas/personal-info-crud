import { BaseResource } from '@common/resource/BaseResource';

class UserResource extends BaseResource {
    constructor() {
        let options = {
            url: '/users/:id'
        };

        super(options);
    }
}

export  default new UserResource();
