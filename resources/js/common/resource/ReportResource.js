import { BaseResource } from '@common/resource/BaseResource';

class ReportResource extends BaseResource {
    constructor() {
        let options = {
            url: '/reports/:id'
        };

        super(options);
    }
}

export default new ReportResource();
