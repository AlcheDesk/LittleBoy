import { apiGet } from '../index'

// 执行总览(最新的15条)
export function getControlCenter(obj) {
    return apiGet('/api/jobs', obj)
}
// 工作列表
export function getJobs(obj) {
    return apiGet('/api/jobs', obj)
}
// 用例详情
export function getTasks(obj) {
    if (obj.uuid) {
        return apiGet('/api/tasks/' + obj.uuid, obj.data);
    } else {
        return apiGet('/api/tasks', obj)
    }
}
// 执行单元
export function getWorkers(obj) {
    return apiGet('/api/workers', obj)
}

// 根据UUID请求指定job的tasks
export function getTaskByJobId(obj) {
    return apiGet(`/api/jobs/${obj.uuid}/tasks?ref=true`, obj.param)
}