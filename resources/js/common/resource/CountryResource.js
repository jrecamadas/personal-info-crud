import { BaseResource } from '@common/resource/BaseResource';

class CountryResource extends BaseResource {
    constructor() {
        let options = {
            url: '/countries/:id'
        };

        super(options);
    }
}

export default new CountryResource();
