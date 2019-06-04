/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import QuestionCategoryResource from '@common/resource/client-feedback/QuestionCategoryResource';

export class QuestionCategory extends BaseModel {
    constructor(data) {
        const relations = {
            data: QuestionCategory,
        };

        super(data, relations);
    }

    static get resource() {
        return QuestionCategoryResource;
    }
}
