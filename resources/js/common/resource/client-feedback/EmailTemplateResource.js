import { BaseResource } from '@common/resource/BaseResource';

class EmailTemplateResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/email-templates/:id',
        };

        super(options);
    }
}

export default new EmailTemplateResource();
