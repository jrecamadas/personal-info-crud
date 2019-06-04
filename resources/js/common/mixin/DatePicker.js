export default {
    methods: {
        getConfig(dateOnly = true, timeOnly = true, otherConfig = {}) {
            let config = {
                altInput: true,
                altInputClass: 'form-control',
                enableTime: true,
                enableSeconds: true,
                noCalendar: false,
                allowInput: false
            };

            if (dateOnly && !timeOnly) {
                config['altFormat'] = 'Y-m-d';
                config['dateFormat'] = 'Y-m-d';
                config['enableTime'] = false;
                config['enableSeconds'] = false;
            } else if (!dateOnly && timeOnly) {
                config['altFormat'] = 'h:i K';
                config['dateFormat'] = 'H:i:S';
                config['enableTime'] = true;
                config['enableSeconds'] = false;
                config['noCalendar'] = true;
            }

            for (const key in otherConfig) {
                if (otherConfig.hasOwnProperty(key)) {
                    const val = otherConfig[key];
                    config[key] = val;
                }
            }

            return config;
        },
        timeTwentyFourFormat(time) {
            time = time.split(' ');
            const hr = time[0].split(':');
            if(time[1] == 'PM') {
                hr[0] = parseInt(hr[0]) + 12;
                if(hr[0] == 24) {
                    hr[0] = '00';
                }
            } else {
                if(hr[0] == '12') {
                    hr[0] = '00';
                }
            }
            return `${hr[0]}:${hr[1]}`;
        }
    }
}
