import { BaseResource } from '@common/resource/BaseResource';

class ContactResource extends BaseResource {
    constructor() {
        let options = {
            url: '/contacts/:id'
        };

        super(options);
    }
}

export default new ContactResource();
