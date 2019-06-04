import { BaseResource } from '@common/resource/BaseResource';

class DepartmentResource extends BaseResource {
    constructor() {
        let options = {
            url: '/departments/:id'
        };

        super(options);
    }
}

export default new DepartmentResource();
