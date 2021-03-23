
import * as types from '../types'
import * as api from '../../axios/ems/EMS'

const state = {
  controlCenter: {},
  workers: {},
  jobs: {},
  tasks: {},
  jobCount: '',
  taskCount: '',
  workCount: ''
}

const getters = {
  controlCenter: state => Array.from(state.controlCenter),
  workers: state => Array.from(state.workers),
  jobs: state => Array.from(state.jobs),
  tasks: state => Array.from(state.tasks),
  jobCount: state => state.jobCount,
  taskCount: state => state.taskCount,
  workCount: state => state.workCount
}

const mutations = {
  [types.SET_CONTROL_CENTER](state, obj) {
    state.controlCenter = obj
  },
  [types.SET_WORKERS](state, obj) {
    state.workers = obj
  },
  [types.SET_JOBS](state, obj) {
    state.jobs = obj
  },
  [types.SET_TASKS](state, obj) {
    state.tasks = obj
  },
  [types.SET_JOB_COUNT](state, obj) {
    state.jobCount = obj
  },
  [types.SET_TASK_COUNT](state, obj) {
    state.taskCount = obj
  },
  [types.SET_WORK_COUNT](state, obj) {
    state.workCount = obj
  },
}

const actions = {
  getControlCenter({
    commit
  }, obj) {
    api.getControlCenter(obj).then((res) => {
      commit('SET_CONTROL_CENTER', res.data)
    }, (err) => {
      console.log(err)
    })
  },
  getWorkers({
    commit
  }, obj) {
    api.getWorkers(obj).then((res) => {
      commit('SET_WORKERS', res.data)
      commit('SET_WORK_COUNT', res.metadata.count)
    }, (err) => {
      console.log(err)
    })
  },
  getJobs({
    commit
  }, obj) {
    api.getJobs(obj).then((res) => {
      commit('SET_JOBS', res.data)
      commit('SET_JOB_COUNT', res.metadata.count)
    }, (err) => {
      console.log(err)
    })
  },
  getTasks({
    commit
  }, obj) {
    api.getTasks(obj).then((res) => {
      commit('SET_TASKS', res.data)
      commit('SET_TASK_COUNT', res.metadata.count)
    }, (err) => {
      console.log(err)
    })
  },
  getTaskByJobId({
    commit
  }, obj) {
    api.getTaskByJobId(obj).then((res) => {
      commit('SET_TASKS', res.data)
      commit('SET_TASK_COUNT', res.metadata.count)
    }, (err) => {
      console.log(err)
    })
  },


}


export default {
  state,
  getters,
  mutations,
  actions
}
