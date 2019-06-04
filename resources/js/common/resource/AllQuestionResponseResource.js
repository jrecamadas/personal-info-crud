import { BaseResource } from "@common/resource/BaseResource";

class AllQuestionResponseResource extends BaseResource {
    constructor() {
        let options = {
            url: "/all-responses/:id"
        };

        super(options);
    }
}

export default new AllQuestionResponseResource();
