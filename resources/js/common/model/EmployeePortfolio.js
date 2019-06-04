import { BaseModel } from '@common/model/BaseModel';
import EmployeePortfolioResource from '@common/resource/EmployeePortfolioResource';

export class EmployeePortfolio extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeePortfolio
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeePortfolioResource;
    }
}
