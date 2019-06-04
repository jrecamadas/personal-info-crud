import { BaseResource } from "@common/resource/BaseResource";

class TimezoneResource extends BaseResource {
    constructor() {
        let options = {
            url: "/timezone"
        };

        super(options);
    }
}

export default new TimezoneResource();
