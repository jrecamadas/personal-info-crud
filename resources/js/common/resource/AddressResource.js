import { BaseResource } from "@common/resource/BaseResource";

class AddressResource extends BaseResource {
    constructor() {
        let options = {
            url: "/addresses/:id"
        };

        super(options);
    }
}

export default new AddressResource();
