import _ from 'lodash';

export default {
    computed: {
        report: function() {
            return (rep) => {
                let report = [];

                _.each(rep, (r) => {
                    report.push(r.type);
                });

                return report.length ? report.join(' ') : '';
            }
        }
    }
}
