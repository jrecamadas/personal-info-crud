import { BaseModel } from '@common/model/BaseModel';
import AssetResource from '@common/resource/AssetResource';

export class Asset extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Asset
        };

        super(data, relations);
    }

    static get resource() {
        return AssetResource;
    }
}
