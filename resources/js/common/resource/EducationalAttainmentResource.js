import { BaseResource } from '@common/resource/BaseResource';

class EducationalAttainmentResource extends BaseResource {
    constructor() {
        let options = {
            url: '/educational-attainments/:id'
        };

        super(options);
    }
}

export default new EducationalAttainmentResource();
