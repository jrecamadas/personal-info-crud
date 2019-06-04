import { BaseResource } from '@common/resource/BaseResource';

class EmployeeProfileResource extends BaseResource {
    constructor() {
        let options = {
            url: '/profile/:username',
            public: {
                get: true
            }

        };

        super(options);
    }
}

export  default new EmployeeProfileResource();
