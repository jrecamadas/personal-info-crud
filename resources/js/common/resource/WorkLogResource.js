import { BaseResource } from '@common/resource/BaseResource';

class WorkLogResource extends BaseResource {
    constructor() {
        let options = {
            url: '/work-logs'
        };

        super(options);
    }
}

export default new WorkLogResource();
