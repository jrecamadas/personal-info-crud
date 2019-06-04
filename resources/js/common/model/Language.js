import { BaseModel } from '@common/model/BaseModel';
import LanguageResource from '@common/resource/LanguageResource';

export class Language extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Language
        };

        super(data, relations);
    }

    static get resource() {
        return LanguageResource;
    }
}
