import { BaseResource } from '@common/resource/BaseResource';

class WorkExperienceResource extends BaseResource {
    constructor() {
        let options = {
            url: '/work-experience/:id'
        };

        super(options);
    }
}

export default new WorkExperienceResource();
