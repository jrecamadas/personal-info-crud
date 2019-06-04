import { BaseModel } from '@common/model/BaseModel';
import ResourceResource from '@common/resource/acl/ResourceResource';

export class Resource extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Resource
        };

        super(data, relations);
    }

    static get resource() {
        return ResourceResource;
    }
}
