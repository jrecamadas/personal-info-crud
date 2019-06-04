import { BaseResource } from '@common/resource/BaseResource';

class SendManualResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/project-surveys/:id/manual-send',
        };

        super(options);
    }
}

export default new SendManualResource();
