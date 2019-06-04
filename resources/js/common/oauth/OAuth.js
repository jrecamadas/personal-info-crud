import Client from '../Client';
import config from './config';

let instance = null;

class OAuth {
    constructor() {
        if (instance) {
            return instance;
        }

        this.instance = this;
    }

    // get token
    getToken() {
        return localStorage.getItem(config.auth_token);
    }

    // authenticate user
    authenticate(creds) {
        return Client.request({
            method: 'post',
            url: `${config.url}/token`,
            data: _.assign(creds, config.creds)
        }).then((res) => {
            // save user access_token for future use
            localStorage.setItem(config.auth_token, res.data.access_token);
            return true;
        }).catch((err) => {
            // invalid user
            return false;
        })
    }

    // get headers
    getHeaders() {
        const token = this.getToken();
        let headers = {};

        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        return headers;
    }

    // check if user is authenticated
    isAuthenticated() {
        return Client.request({
            method: 'post',
            url: `${config.url}/check`,
            headers: this.getHeaders()
        }).then((res) => {
            return !!res.data.authenticated;
        }).catch((err) => {
            return false;
        })
    }

    // this will only used in public applicant form page
    tokenize() {
        return Client.request({
            method: 'post',
            url: config.app_pub_url
        }).then((res) => {
            // save user access_token for future use
            localStorage.setItem(config.auth_token, res.data.accessToken);
            return true
        }).catch((err) => {
            return false;
        })
    }

    tokenizeSurvey(link) {
        return Client.request({
            method: 'post',
            url: config.app_survey_url + '/' + link,
        }).then((res) => {
            // save user access_token for future use
            localStorage.setItem(config.auth_token, res.data.accessToken);
            return true;
        }).catch((err) => {
            return false;
        })
    }

    // logout user
    // invalidate token
    logout() {
        return Client.request({
            method: 'post',
            url: `${config.url}/logout`,
            headers: this.getHeaders()
        }).then((err) => {
            // remove stored access_token
            localStorage.removeItem(config.auth_token);
            return true;
        }).catch((err) => {
            return false;
        })
    }
}

export default new OAuth();
