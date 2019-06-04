import { BaseModel } from "@common/model/BaseModel";
import TimezoneResource from "@common/resource/TimezoneResource";

export class Timezone extends BaseModel {
    constructor(data) {
        let relations = {
            data: Timezone
        };

        super(data, relations);
    }

    static get resource() {
        return TimezoneResource;
    }
}
