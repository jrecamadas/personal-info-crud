import { BaseResource } from '@common/resource/BaseResource';

class SendReportResource extends BaseResource {
    constructor() {
        let options = {
            url: '/preview'
        };

        super(options);
    }
}

export default new SendReportResource();
