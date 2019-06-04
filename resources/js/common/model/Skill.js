import { BaseModel } from '@common/model/BaseModel';
import SkillResource from '@common/resource/SkillResource';

export class Skill extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Skill
        };

        super(data, relations);
    }

    static get resource() {
        return SkillResource;
    }
}
