import { BaseResource } from '@common/resource/BaseResource';

class ClientResponseResouce extends BaseResource {
    constructor() {
        const options = {
            url: '/response/:id',
            public: {
                get: true,
            },
        };

        super(options);
    }
}

export default new ClientResponseResouce();
