import axios from 'axios'
import { Loading } from 'element-ui';


/*all api
   read  ----   Get
   add   ----   Post
   delete  ----   Delete
   update  ----   Patch */

axios.defaults.timeout = 60000;
axios.defaults.withCredentials = true;

var loading;

//POST传参序列化
axios.interceptors.request.use((config) => {
  console.log(config.method, config);
  loading = Loading.service({
    lock: true,
    text: '操作中....'
  })
  config.headers = {
    'content-Type': 'application/x-www-form-urlencoded',
    'Access-Control-Allow-Headers':'Authorization,Origin, X-Requested-With, Content-Type, Accept',
    'Access-Control-Allow-Methods':'GET,POST, PATCH, PUT, DELETE',
    'Access-Control-Allow-Origin': '*'
  };
  return config;
}, (error) => {
  console.log(error);
  return Promise.reject(error);
});

//返回状态判断
axios.interceptors.response.use((res) => {
  console.log(res, 'return')
  setTimeout(() => {
    if (loading) {
      loading.close();
    }
  }, 100);
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
  console.log(error)
  return Promise.reject(error);
});


function proxyGet(url, obj) {
  return new Promise((resolve, reject) => {
    axios.get(url, {params:obj})
      .then((response) => {
        resolve(response.data);
      }, (err) => {
        reject(err);
      })
  })
};

function proxyPost(url, data, param) {
  return new Promise((resolve, reject) => {
    axios.post(url, data, {params: param})
      .then((response) => {
        resolve(response.data);
      }, (err) => {
        reject(err);
      })
  })
};

function proxyPatch(url, data, param) {
  return new Promise((resolve, reject) => {
    axios.patch(url, data, {params: param})
      .then((response) => {
        resolve(response.data);
      }, (err) => {
        reject(err);
      })
  })
};

function proxyDelete(url, param) {
  return new Promise((resolve, reject) => {
    axios.delete(url, {params: param})
      .then((response) => {
        resolve(response.data);
      }, (err) => {
        reject(err);
      })
  })
};

function proxyPut(url, data, param) {
  return new Promise((resolve, reject) => {
    axios.put(url, data, {params: param})
    .then((response) => {
      resolve(response.data);
    }, (err) => {
      reject(err);
    })
  })
};



export function apiUniCall(obj) {
  if (obj.headers.length) {
    obj.headers.forEach((item) => {
      axios.defaults.headers[item.key] = item.value;
    });
  }
  if (obj.method === 'GET') {
    return proxyGet(obj.url, obj.query);
  }
  if (obj.method === 'POST') {
    return proxyPost(obj.url, obj.body, obj.query);
  }
  if (obj.method === 'PATCH') {
    return proxyPatch(obj.url, obj.body, obj.query);
  }
  if (obj.method === 'PUT') {
    return proxyPut(obj.url, obj.body, obj.query);
  }
  if (obj.method === 'DELETE') {
    return proxyDelete(obj.url, obj.query);
  }
}