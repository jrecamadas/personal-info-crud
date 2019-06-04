/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import SurveySentResource from '@common/resource/client-feedback/SurveySentResource';

export class SurveySent extends BaseModel {
    constructor(data) {
        const relations = {
            data: SurveySent,
        };

        super(data, relations);
    }

    static get resource() {
        return SurveySentResource;
    }
}
