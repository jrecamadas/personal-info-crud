import _ from 'lodash';
import DateMixin from '@common/mixin/DateMixin';
import AssetMixin from '@common/mixin/AssetMixin';
import { Employee } from '@common/model/Employee';

export default {
    computed: {
        /**
         * The default image depends on gender, if gender is not mentioned, last resort is male.
         * If they have uploaded a photo, that will be the one to be used to show in profile.
         * @returns {function(*): string}
         */
        photo: function() {
            return (emp) => {
                let photoUrl = `/assets/img/avatars/${emp.gender ? emp.gender.toLowerCase() : 'male'}.png`;

                if(emp.photo) {
                    let photoArr = [];
                    if (emp.photo.data && emp.photo.data.length) {
                        photoArr = emp.photo.data;
                    } else if(emp.photo && emp.photo.length){
                        photoArr = emp.photo;
                    }
                    let latest = 0;
                    photoArr.forEach((record)=>{
                        if(record.type === 1 && record.id > latest){
                            latest = record.id;
                            photoUrl = record.path;
                        }
                    });
                }

                //return window.location.origin + '/api/asset?path=' + photoUrl;
                return window.location.origin + this.getAssetPath(photoUrl);
            }
        },
        presentAddress: function() {
            return (address) => {
                const _address = address.filter(a => a.is_present == 1);

                if (_address.length) {
                    return this._getAddress(_address[0]);
                }

                return null;
            }
        },
        permanentAddress: function() {
            return (address)  => {
                const _address = address.filter(a => a.is_permanent == 1);

                if (_address.length) {
                    return this._getAddress(_address[0]);
                }

                return null;
            }
        },
        dateHired: function() {
            return (dh) => dh ? this.formatDate(dh, 'MM/DD/YYYY') : 'Unassigned';
        },
        position: function() {
            return (positions) => {
                let pos = positions || [];
                let position = [];

                _.each(pos, (p) => {
                    let temp = [];

                    if (p.level) {
                        temp.push(p.level);
                    }

                    temp.push(p.job_title);
                    position.push(temp.join(' '));
                });

                return position.length ? position.join(' / ') : 'Unassigned';
            }
        },
        location: function() {
            return (location) => {
                let locationDetail = '';
                if(location.city){
                    locationDetail += location.city;
                }
                if(location.country && location.city){
                    locationDetail += ', ';
                }
                if(location.country){
                    locationDetail += location.country;
                }
                return locationDetail;
            };
        },
        displayLocationTooltip() {
            return (location) => {
                let locationDetail = '';
                if(typeof location !== 'undefined' && typeof location.data !== 'undefined') {
                    if(location.data.room_number)
                        locationDetail += 'Rm. # ' + location.data.room_number + ', ';
                    if(location.data.floor)
                        locationDetail += location.data.floor + ' flr, ';
                    if(location.data.building)
                        locationDetail += location.data.building + '\n';
                    if(location.data.city)
                        locationDetail += location.data.city + ', ';
                    if(location.data.country)
                        locationDetail += location.data.country + ', ';
                }
                return locationDetail.slice(0,-2);
            }
        },
        cityAndCountry: function() {
            return (location) => {
                let locationDetail = '';
                if(typeof location !== 'undefined') {
                    let country = location.country_code == 'PH' ? 'Philippines' : 'Belarus';
                    locationDetail += location.city !== null && location.city ? location.city : '';
                    locationDetail += (location.country_code !== null && location.country_code) && (location.city !== null && location.city) ? ', ' : '';
                    locationDetail += location.country_code !== null && location.country_code ? country : '';
                }
                return locationDetail;
            }
        },
        status: function() {
            return (status) => `status-${status.toLowerCase()}`;
        },
        aboutMe: function() {
            return (summary) => summary || 'No description provided.';
        },
        interests: function() {
            return (interests) => {
                let _interests = [];

                _.each(interests, (i) => {
                    _interests.push(i.interest);
                });

                return _interests.length ? _interests.join(', ') : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut risus tellus, posuere et iaculis interdum, pretium vitae tortor. Praesent dictum a elit sed venenatis. Morbi eu erat non neque tristique posuere in ac metus.';
            }
        },
        dateOfBirth: function() {
            return (dob) => dob ? this.formatDate(dob, 'MM/DD/YYYY') : null;
        },
        lastEmploymentStatus: function() {
            return (empStat) =>
            {
                let empStatData = (empStat && empStat.data) ? empStat.data : [];
                return (empStatData && empStatData.length) ? _.last(empStatData).status.name : ' ---- ';
            }
        },
        empDepartment: function() {
            return (emp_department) =>
            {
                return (emp_department && emp_department.data) ? emp_department.data.name : 'Unassigned';
            }
        }
    },
    methods: {
        getLevel(level) {
            let levels = {
                'Junior': 1,
                'Mid': 2,
                'Senior': 3
            };

            return level ? levels[level] : level;
        },
        checkContactNumber: function($event) {
            let val = $event.target.value.replace(/-|\s/g,"");
            if(val.length == 12)
            $event.preventDefault();
        },
        generateEmployeeNo() {
            return new Promise((resolve, reject) => {
                Employee.get({take: 1, orderBy: 'employee_no|desc', withTrashed: 1}).then((res) => {
                    let data = res.data;
                    let employeeNo = 'FS-0001';

                    if (data.length) {
                        let temp = data[0].employee_no.split('-');
                        let prefx = temp[0];
                        let lastId = temp[1];
                        let newNum = this._pad((parseInt(lastId) + 1));

                        employeeNo = `${prefx}-${newNum}`;
                    }

                    resolve(employeeNo);
                });
            });
        },
        _pad(num, size = 4) {
            let s = String(num);

            while (s.length < (size || 2)) {
                s = `0${s}`;
            }

            return s;
        },
        getPositionIdByTitle(title) {
            const positions = this.positions.filter(s => s.text.toUpperCase().includes(title.toUpperCase()));
            return positions[0].id;
        },
        _getAddress(address) {
            let _address = [];

            _.forOwn(address, (value, key) => {
                if (key != 'id' && key != 'country' && key != 'is_present' && key != 'is_permanent' && key != 'postal_zip_code') {
                    if (value && value != '') {
                        _address.push(value);
                    }
                }
            });
            if(address && address.country && address.country.data) {
                _address.push(address.country.data.name);
            }

            if (address.postal_zip_code && address.postal_zip_code != '') {
                _address.push(address.postal_zip_code);
            }

            return _address.join(' ');
        },
        copyToClipBoardInput(className) {
            (function(){
                let urlSrc = document.querySelector("input."+className);
                urlSrc.select();
                document.execCommand("copy");

                setTimeout(function(){
                    document.getSelection().empty();
                },120);
            })();
        },
        copyToClipboard(className){
            (function(){
                let urlSrc = document.querySelector("span."+className);
                let range  = document.createRange();
                range.selectNodeContents(urlSrc);

                let selected = window.getSelection();
                selected.removeAllRanges();
                selected.addRange(range);
                document.execCommand("copy");

                setTimeout(function(){
                    document.getSelection().empty();
                },120);
            })();
        },
        getUnique(arr, comp) {
            const unique = arr
            .map(e => e[comp].toLowerCase())
            // store the keys of the unique objects
            .map((e, i, final) => final.indexOf(e) === i && i)
            // eliminate the dead keys & store unique objects
            .filter(e => arr[e]).map(e => arr[e]);

            return unique;
        }
    },
    mixins: [
        AssetMixin,
        DateMixin
    ]
}
