import { BaseResource } from "@common/resource/BaseResource";

class AllQuestionResource extends BaseResource {
    constructor() {
        let options = {
            url: "/all-questions/:id"
        };

        super(options);
    }
}

export default new AllQuestionResource();
