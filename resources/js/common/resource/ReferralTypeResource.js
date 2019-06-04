import { BaseResource } from '@common/resource/BaseResource';

class ReferralTypeResource extends BaseResource {
    constructor() {
        let options = {
          url: '/referral-types/:id'  
        };

        super(options);
    }
}

export default new ReferralTypeResource();
