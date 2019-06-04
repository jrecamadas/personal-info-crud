import { BaseResource } from '@common/resource/BaseResource';

class EmployeePortfolioResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-portfolios/:id'
        };

        super(options);
    }
}

export default new EmployeePortfolioResource();
