import _ from 'lodash';

// base class for models
export class BaseModel {
    // constructor for the class
    constructor(data, relations) {
        // iterate through the object properties
        for (let prop in data) {
            // if a relation is defined
            if (relations[prop]) {
                // if data property is an array
                if (data[prop] instanceof Array) {
                    // iterate through it and create a new model for each
                    this[prop] = _.map(data[prop], function(data) {
                        return new relations[prop](data);
                    });
                } else {
                    // create new model for it
                    this[prop] = new relations[prop](data[prop]);
                }
            } else {
                // just add the property to the object
                this[prop] = data[prop];
            }
        }
    }

    // static function to get
    static get(data) {
        // call get function of the resource
        return this.resource.get(data).then((res) => {
            return new this(res.data);
        });
    }

    // saves the data passed to the object
    // performs post if primary key is not found patch otherwise
    // if foreceCreate is true, patch is used
    save(data, forceCreate = false) {
        // primar key is first key, substring to remove :
        let key = this.primaryKey;
        let pk, action;

        // if primary key is available and not forceCreate flag
        if (key && this[key] && !forceCreate) {
            // use patch
            action = 'patch';
            // pass primary key
            data[key] = this[key];
        } else {
            // if primary key is not found, post
            action = 'post';
        }

        // call the resource function depending on action
        return this.constructor.resource[action](data).then((res) => {
            return new this.constructor(res.data);
        });
    }

    // deletes the resource
    delete() {
        // primary key is first key, substring to remove :
        let key = this.primaryKey;
        // create data with primary key
        let data = {};
        data[key] = this[key];

        // call delete function of the resource
        return this.constructor.resource.delete(data).then((res) => {
            return res.data;
        });
    }

    // get the primary key of the resource
    get primaryKey() {
        let pk = _.head(this.constructor.resource.keys);

        if (pk) {
            return pk.substring(1);
        }
    }

    // static function to get resource of the model
    static get resource() {
        // must override this!!
        throw new TypeError('Must override this method.');
    }
}
