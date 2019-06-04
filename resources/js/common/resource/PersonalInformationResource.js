import { BaseResource } from '@common/resource/BaseResource';

class PersonalInformationResource extends BaseResource {
    constructor() {
        let options = {
            url: '/personal-info/:id'
        };

        super(options);
    }
}

export default new PersonalInformationResource();
