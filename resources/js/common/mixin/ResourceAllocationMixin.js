export default {

    /** This is from the job_positions table. Update this when, this and the table doesn't match **/
    data: function(){
        return {
            excludePositions: [
                1, //President
                2, //Managing Director
                3, //Director for Operations
                4, //Operation Manager
                5, //Development Manager
                //6	, //Project Manager
                7, //Shift Supervisor
                8, //HR Manager
                9, //QA Manager
                10, //SEO Manager
                11, //HR Officer
                12, //HR Staff
                13, //Treasurer
                //14, //QA Tester
                //15, //SEO Specialist
                //16, //Developer
                //17, //FullStack PHP Developer
                //18, //PHP Developer
                //19, //.NET Developer
                //20, //C# Developer
                //21, //Ruby Developer
                //22, //Ruby on Rails Developer
                //23, //Python Developer
                //24, //Python Django Developer
                //25, //Java Developer
                //26, //C++ Developer
                //27, //Mobile Application Developer
                //28, //IOS Developer
                //29, //Android Developer
                //30, //UX/UI Designer
                //31, //Graphic Artist
                //32, //Web Designer
                //33, //Content Writer
                34, //Content Director
                35, //Technical Writer
                36, //Utility
                37, //Shift Lead
                38, //Chief Success Officer
                9999  //catches error prone comma missed to remove.
            ]
        };
    },
    methods: {
        /**
         * Search needle in haystack
         * @param needle - to look for
         * @param haystack - the array to test whether needle is there
         * @returns {boolean}
         */
        inArray(needle,haystack){
            let passed = false;
            haystack.every(function(item){
                if(needle === item){
                    passed = true;
                    return false;
                } else {
                    return true;
                }
            });
            return passed;
        },

        /**
         * Remove those employees without position
         * Remove those whose position is not dev
         */
        isAllowedResource(resource){
            let allowed = true;
            if(resource.positions.data[0] === undefined){
                return !allowed;
            } else {
                let pass = false;
                resource.positions.data.forEach((obj) => {
                    if(!this.inArray(parseInt(obj.position_id),this.excludePositions)){ pass = true; }
                });
                if(!pass){ allowed = false; }
            }
            return allowed;
        },

        isInAssignedResources(employee_id, assigned_resources){
            let assigned = false;
            assigned_resources.every((assigned_resource) => {
                if(assigned_resource.employee_id === employee_id){
                    assigned = true;
                    return false;
                } else {
                    return true;
                }
            });
            return assigned;
        },

        /**
         * Loops with the existing columns and see if it's what you are looking for.
         * @param projectid
         * @returns the object of that column (reactive)
         */
        getColumnNode(projectid){
            let instance = null;
            this.projects.every(function(obj){
                if(obj.projectid === projectid || obj.clientid === projectid){
                    instance = obj;
                    return false;
                } else { return true; }
            });
            return instance;
        },
        getResourcePhoto(resource){
            let profile_photo = '/assets/img/avatars/' + (resource.gender ? resource.gender.toLowerCase() : 'male') + '.png';
            if(resource.photo && resource.photo.data && resource.photo.data.length){
                let latest = 0;
                resource.photo.data.forEach((record)=>{
                    if(record.type === 1 && record.id > latest){
                        latest = record.id;
                        profile_photo = record.path;
                    }
                });
                /*resource.photo.data.every((record)=>{
                    if(record.type === 1){
                        profile_photo = record.path;
                        return false;
                    }else { return true; }
                });*/
            }
            return profile_photo;
        },
        getResourcePosition(resource){
            let position = [];
            resource.positions.data.forEach((pos) => {
                if(!this.inArray(pos.position_id,this.excludePositions)){
                    position.push(pos.job_title);
                }
            });
            return position.join(', ');
        },
        getResourceSkills(resource){
            let skills = [];
            if(resource.skills && resource.skills.data && resource.skills.data.length > 0){
                resource.skills.data.forEach((skill) => {
                    skills.push({
                        skill: skill.name,
                        level: skill.proficiency
                    });
                });
            }
            return skills;
        },
        getResourceShifts(resource){
            let shift = [];
            if(resource.shift && resource.shift.data){
                shift.push({
                    start: resource.shift.data.time.cst.start,
                    end: resource.shift.data.time.cst.end,
                    timezone: 'CST',
                    place: 'Kansas'
                });
                shift.push({
                    start: resource.shift.data.time.ph.start,
                    end: resource.shift.data.time.ph.end,
                    timezone: 'PHT',
                    place: 'Phil'
                });
            }
            return shift;
        },
        getResourceProfileCardURL(resource){
            let card = '';
            if(resource.user && resource.user.data){
                card = '/profile/' + resource.user.data.user_name;
            }
            return card;
        },
        getClientProjects(clientId, clients){
            let projects = [];
            let client = clients.filter(obj => obj.id == clientId)[0];
            if(client && client.projects){
                client.projects.data.forEach((project) => {
                    projects.push(project);
                });
            }
            return projects;
        },

        /**
         * This fetches the DOM object stored in the Vue event object. We let the jQuery handle the sliding effect
         * @param obj Vue $event event on click of that element
         */
        detailClicked(obj){
            let element = obj.path[3];
            let detail = $(element).find("div.resource-details-content");
            if($(detail).css('display')=='none'){
                $(detail).slideDown();
            }else{
                $(detail).slideUp();
            }
        },
    }
}
