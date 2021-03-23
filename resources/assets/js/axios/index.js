import axios from 'axios'
// import qs from 'qs'
import { Loading, Message } from 'element-ui';
import moment from 'moment'


/*all api
   read  ----   Get
   add   ----   Post
   delete  ----   Delete
   update  ----   Patch */

axios.defaults.timeout = 60000;
// axios.defaults.headers = {
//   'Access-Control-Allow-Headers':'Authorization,Origin, X-Requested-With, Content-Type, Accept',
//   'Access-Control-Allow-Methods':'GET,POST, PATCH, PUT, DELETE',
//   'Access-Control-Allow-Origin': '*'
// };
axios.defaults.headers.post['Content-Type'] = 'application/json';
// axios.defaults.withCredentials = true;
// axios.defaults.baseURL = process.env.API_ROOT;

var loading;

//POST传参序列化
axios.interceptors.request.use((config) => {
    console.log(config.method, config);
    if (config.method != 'get') {
        loading = Loading.service({
            lock: true,
            text: '操作中....'
        })
    }
    let str = window.location.href.split('?')[1];
    let page = parseInt(str && str.split('&')[0].split('=')[1].split('+')[0]);
    let pageSize = parseInt(str && str.split('&')[0].split('=')[1].split('+')[1]);
    if (window.location.pathname.includes('atm') && config.params && !config.params.hasOwnProperty('location') && config.params.pageSize != 'all') {
        if (config.params && config.params.pageNumber) {
            if (page && page != config.params.pageNumber) {
                config.params.pageNumber = page;
            }
            if (pageSize && pageSize != config.params.pageSize) {
                config.params.pageSize = pageSize;
            }
        }
    } else {
        if (window.location.pathname.includes('atm') && config.params && config.params.hasOwnProperty('location')) {
            delete config.params.location;
        }
    }
    return config;
}, (error) => {
    console.log(error);
    return Promise.reject(error);
});

//返回状态判断
axios.interceptors.response.use((res) => {
    console.log(res, 'return')
    if (res.config.method == 'get') {
        if (res.config.url.indexOf('testCaseOverwrites') === -1 && res.data.data) {
            for (let i = 0; i < res.data.data.length; i++) {
                if (res.data.data.length) {
                    if (res.data.data[i].hasOwnProperty('createdAt')) {
                        res.data.data[i].createdAt = moment(res.data.data[i].createdAt).format('YYYY/MM/DD HH:mm:ss');
                    }
                    if (res.data.data[i].hasOwnProperty('updatedAt')) {
                        res.data.data[i].updatedAt = moment(res.data.data[i].updatedAt).format('YYYY/MM/DD HH:mm:ss');
                    }
                    if (res.data.data[i].hasOwnProperty('runDate')) {
                        res.data.data[i].runDate = moment(res.data.data[i].runDate).format('YYYY/MM/DD HH:mm:ss');
                    }
                    if (res.data.data[i].hasOwnProperty('latestRunUpdatedAt')) {
                        res.data.data[i].latestRunUpdatedAt = moment(res.data.data[i].latestRunUpdatedAt).format('YYYY/MM/DD HH:mm:ss');
                    }
                    if (res.data.data[i].hasOwnProperty('latestRunCreatedAt')) {
                        res.data.data[i].latestRunCreatedAt = moment(res.data.data[i].latestRunCreatedAt).format('YYYY/MM/DD HH:mm:ss');
                    }
                }
            }
        }
        setTimeout(() => {
            if (loading) {
                loading.close();
            }
        }, 100);
    } else {
        setTimeout(() => {
            if (loading) {
                loading.close();
            }
        }, 100);
    }
    if (String(res.status).indexOf('20') >= 0) {
        return res;
    } else {
        return Promise.reject(res);
    }
}, (error) => {
    setTimeout(() => {
        if (loading) {
            loading.close();
        }
    }, 100);
    console.log(error, 'error....')
    Message({
        type: 'error',
        message: error.response.data.error.message
    });
    return Promise.reject(error);
});


function proxyGet(url, obj) {
    return new Promise((resolve, reject) => {
        axios.get(url, { params: obj })
            .then((response) => {
                resolve(response.data);
            }, (err) => {
                reject(err);
            })
    })
};

function proxyPost(url, data, param) {
    return new Promise((resolve, reject) => {
        axios.post(url, data, { params: param })
            .then((response) => {
                resolve(response.data);
            }, (err) => {
                reject(err);
            })
    })
};

function proxyPatch(url, data) {
    return new Promise((resolve, reject) => {
        axios.patch(url, data)
            .then((response) => {
                resolve(response.data);
            }, (err) => {
                reject(err);
            })
    })
};

function proxyDelete(url, data) {
    const config = {};
    if (!!data) {
        config.params = {
            ids: data
        }
    }
    return new Promise((resolve, reject) => {
        axios.delete(url, config)
            .then((response) => {
                resolve(response.data);
            }, (err) => {
                reject(err);
            })
    })
};

function proxyPut(url, data, param) {
    const config = {};
    if (!!param) {
        config.params = {
            ids: param
        }
    }
    return new Promise((resolve, reject) => {
        axios.put(url, data, config)
            .then((response) => {
                resolve(response.data);
            }, (err) => {
                reject(err);
            })
    })
};

//need TODO return data type
export function apiGet(url, obj) {
    return proxyGet(url, obj);
}

export function apiPost(url, obj, param) {
    return proxyPost(url, obj, param);
}

export function apiPatch(url, param) {
    return proxyPatch(url, param);
}


export function apiDelete(url, param) {
    return proxyDelete(url, param);
}


export function apiPut(url, data, param) {
    return proxyPut(url, data, param);
}