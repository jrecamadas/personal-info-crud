import { BaseModel } from '@common/model/BaseModel';
import CheckPasswordResource from '@common/resource/CheckPasswordResource';

export class CheckPassword extends BaseModel {
    constructor(data) {
        let relations = {
            'data': CheckPassword
        };

        super(data, relations);
    }

    static get resource() {
        return CheckPasswordResource;
    }
}
