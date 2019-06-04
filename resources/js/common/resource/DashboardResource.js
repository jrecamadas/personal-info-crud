import { BaseResource } from '@common/resource/BaseResource';

class DashboardResource extends BaseResource {
    constructor() {
        let options = {
            url: '/dashboard/:id'
        };

        super(options);
    }
}

export default new DashboardResource();