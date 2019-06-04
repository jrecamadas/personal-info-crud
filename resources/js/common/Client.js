import NProgress from 'nprogress';

export default {
    request(config) {
        // create a new axios instance
        const instance = axios.create({
            baseUrl: '/'
        });

        // before a request is made, start the nprogress
        // instance.interceptors.request.use(config => {
        //    NProgress.start();
        //    return config;
        //  });

        // before a response is returned, stop the nprogress
        //  instance.interceptors.response.use(response => {
        //     NProgress.done();
        //    return response;
        // });

        return instance.request({
            method: config.method,
            url: config.url,
            data: config.data,
            headers: config.headers,
            params: config.params
        });
    }
}
