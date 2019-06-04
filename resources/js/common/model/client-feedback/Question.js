/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import QuestionResource from '@common/resource/client-feedback/QuestionResource';

export class Question extends BaseModel {
    constructor(data) {
        const relations = {
            data: Question,
        };

        super(data, relations);
    }

    static get resource() {
        return QuestionResource;
    }
}
