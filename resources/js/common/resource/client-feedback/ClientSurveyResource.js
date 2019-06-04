import { BaseResource } from '@common/resource/BaseResource';

class ClientSurveyResource extends BaseResource {
    constructor() {
        const options = {
            url: '/survey/:id',
            public: {
                get: true,
            },
        };

        super(options);
    }
}

export default new ClientSurveyResource();
