import { BaseModel } from '@common/model/BaseModel';
import CountryResource from '@common/resource/CountryResource';

export class Country extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Country
        };

        super(data, relations);
    }

    static get resource() {
        return CountryResource;
    }
}
