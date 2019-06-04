import { BaseModel } from '@common/model/BaseModel';
import SmartTeamBuilderResource from '@common/resource/SmartTeamBuilderResource';

export class SmartTeamBuilder extends BaseModel {
    constructor(data) {
        let relations = {
            'data': SmartTeamBuilder
        };

        super(data, relations);
    }

    static get resource() {
        return SmartTeamBuilderResource;
    }
}
