import { BaseResource } from '@common/resource/BaseResource';

class ApplicantResource extends BaseResource {
    constructor() {
        let options = {
            url: '/applicants/:id'
        };

        super(options);
    }
}

export default new ApplicantResource();
