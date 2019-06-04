import { BaseModel } from "@common/model/BaseModel";
import AllQuestionResource from "@common/resource/AllQuestionResource";

export class AllQuestion extends BaseModel {
    constructor(data) {
        let relations = {
            data: AllQuestion
        };

        super(data, relations);
    }

    static get resource() {
        return AllQuestionResource;
    }
}
