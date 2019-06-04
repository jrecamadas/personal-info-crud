import _ from 'lodash';
import DateMixin from '@common/mixin/DateMixin';
import { EmployeeEducation } from '@common/model/EmployeeEducation';

export default {
    computed: {

    },
    created() {

    },
    methods: {
        getEducationData(employee) {
            let educations = [];
            try{
                if(employee.educations.data.filter(a => a.is_present == 1).length) {
                    employee.educations.data.filter(a => a.is_present == 1).forEach(function(education){
                        educations.push(education);
                    });
                }
                return educations.concat(_.orderBy(employee.educations.data.filter(a => a.is_present != 1),'year_completed','desc'));
            }catch(e){
                return [];
            }
        }
    },
    mixins: [
        DateMixin
    ]
}