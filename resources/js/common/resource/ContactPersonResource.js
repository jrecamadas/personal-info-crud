import { BaseResource } from '@common/resource/BaseResource';

class ContactPersonResource extends BaseResource {
    constructor() {
        let options = {
            url: '/contact-persons/:id'
        };

        super(options);
    }
}

export default new ContactPersonResource();
