import _ from 'lodash';
import { Client } from '@common/model/Client';
import AssetMixin from '@common/mixin/AssetMixin';

export default {
    computed: {
        photo: function () {
            return (client) => {
                let photoUrl = `/assets/img/logos/default-corporate-image.png`;
                if (client.photo.data.length) {
                    photoUrl = _.last(client.photo.data).path;
                }
                return this.getAssetPath(photoUrl);
            };
        }
    },
    methods: {
        formatOnboardingResults(responses) {
            let firstRows = {
                'company_name'              : 'Company Name',
                'zip_code'                  : 'Zip Code',
                'business_hour'             : 'Business Hours',
                'remote_team_exp'           : 'Remote Team Exp',
                'remote_team_exp_type'      : 'Types',
                'remote_team_exp_country'   : 'Country',
            };
            let secondRows = {
                'project_start'     : 'Project Starts',
                'work_hour'         : 'Preferred Work Hours',
                'service_need'      : 'Services Needed',
                'project_term'      : 'Term',
                'tech_require'      : 'Technologies Required',
                'product_status'    : 'Company/Product Status',
                'current_resource'  : 'Current Resources',
            };

            return {
                'first': this.parseOnboardResults(responses, firstRows),
                'second': this.parseOnboardResults(responses, secondRows),
            };
        },
        parseOnboardResults(responses, rows) {
            let results = [];
            let noRemoteTeamExp = false;

            _.each(rows, function(row, key) {
                let response = _.filter(responses, {'form_label': key});

                if (_.isEmpty(response)) {
                    return;
                }

                if (_.includes(key, 'remote_team_exp')) {
                    if (noRemoteTeamExp) {
                        return;
                    }

                    if (key === 'remote_team_exp') {
                        let singleRes = _.trim(response[0].value);
                        noRemoteTeamExp = _.includes(['no', 'false'], _.toLower(singleRes));
                    }
                }

                results.push({
                    'label': row,
                    'value': _.join(_.map(response, 'value'), ', '),
                });
            });

            return results;
        },
    },
    mixins: [
        AssetMixin
    ]
}