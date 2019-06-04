import _ from 'lodash';
import Client from '../Client';
import config from './config';
import OAuth from '../oauth/OAuth';

export class BaseResource {
    constructor(options) {
        this._url = config.url + options.url;
        this.public = options.public || {};

        // default actions for our resource
        let actions = ['get', 'post', 'put', 'patch', 'delete'];

        // assign each action to this object
        _.each(actions, (action) => {
            // call the partial of call function for each action
            this[action] = _.partial(this.call, action);
        });
    }

    // @method:string - one of the Http actions e.g get, post, put, patch, delete
    call(method, data) {
        // build the url and parameter
        let params = this.interpolate(data, method == 'post');

        // create the config parameters
        let config = {
            method: method,
            url: params.url,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        if (method == 'get') {
            config['params'] = params.data;
        } else {
            config['data'] = params.data;
        }

        // if the resource is not available for public, add access token
        if (!this.public[method]) {
            config.headers['Authorization'] = `Bearer ${OAuth.getToken()}`;
        }

        return Client.request(config);
    }

    // build the url using wild cards and the data passed
    interpolate(data, removeOnly = false) {
        // create a copy of data
        let clone = {...data};

        // get the wild cards
        let keys = this.keys;

        return {
            url: _(keys).reduce(function(url, key) {
                // get the key without the :
                var dataKey = key.substring(1);

                // if property is set, replace the value of the wild card
                if (clone && clone[dataKey] && !removeOnly) {
                    // replace wild card
                    url = url.replace(key, clone[dataKey]);
                    // delete the value in the data
                    delete clone[dataKey];
                } else {
                    // else remove the wild card
                    url = url.replace(key, '');
                }

                return url.replace(/\/$/, '');
            }, this.url),
            data: clone
        };
    }

    // get the wild cards used
    get keys() {
        return this.url.replace(/.*:\/\//g, '').match(/:[a-zA-Z_]+/g);
    }

    // get the url of this resource
    get url() {
        return this._url;
    }
}
