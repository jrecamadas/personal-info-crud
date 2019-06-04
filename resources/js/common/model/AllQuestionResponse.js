import { BaseModel } from "@common/model/BaseModel";
import AllQuestionResponseResource from "@common/resource/AllQuestionResponseResource";

export class AllQuestionResponse extends BaseModel {
    constructor(data) {
        let relations = {
            data: AllQuestionResponse
        };

        super(data, relations);
    }

    static get resource() {
        return AllQuestionResponseResource;
    }
}
