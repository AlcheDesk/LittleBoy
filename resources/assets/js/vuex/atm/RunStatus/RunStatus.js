//TODO
//need import types, types is about mutations_types
import * as types from '../../types'
import * as api from '../../../axios/atm/runStatus/apiRunStatus'


const state = {
  projectRunStatus: {},
  projectTestCaseRunStatus: {},
  runListStatus: {},
  runCaseStatus: {},
  testCaseStatus: {}
};

const getters = {
  getProjectRunStatus(state) {
    return state.projectRunStatus;
  },
  getProjectTestCaseStatus(state) {
    return state.projectTestCaseRunStatus;
  },
  getRunListStatus(state) {
    return state.runListStatus;
  },
  getRunCaseStatus(state) {
    return state.runCaseStatus;
  },
  getTestCaseStatus(state) {
    return state.testCaseStatus;
  }
};

const mutations = {
  [types.READ_PROJECT_RUNSTATUS](state, obj) {
    state.projectRunStatus = obj || {};
  },
  [types.READ_PROJECT_TESTCASE_RUNSTATUS](state, obj) {
    state.projectTestCaseRunStatus = obj || {};
  },
  [types.READ_RUN_LIST_STATUS](state, obj) {
    state.runListStatus = obj || {};
  },
  [types.READ_RUN_CASE_STATUS](state, obj) {
    state.runCaseStatus = obj || {};
  },
  [types.READ_TESTCASE_STATUS](state, obj) {
    state.testCaseStatus = obj || {};
  }
};

const actions = {
  readProjectRunStatus({commit}, obj) {
    api.getProjectStatus(obj).then((res) => {
      commit('READ_PROJECT_RUNSTATUS', res);
      window.setTimeout(function() {
        if (res.metadata.refresh) {
          actions.readProjectRunStatus({commit}, obj);
        }
      }, 10000)
    }, (err) => {
      console.log(err);
    })
  },
  readProjectTestCaseStatus({commit}, obj) {
    api.getProjectTestCaseStatus(obj).then((res) => {
      commit('READ_PROJECT_TESTCASE_RUNSTATUS', res);
      window.setTimeout(function() {
        if (res.metadata.refresh) {
          actions.readProjectTestCaseStatus(obj);
        }
      }, 10000)
    }, (err) => {
      console.log(err);
    })
  },
  readRunListStatus({commit}, obj) {
    api.getRunListStatus(obj).then((res) => {
      commit('READ_RUN_LIST_STATUS', res);
      window.setTimeout(function() {
        if (res.metadata.refresh) {
          actions.readProjectRunStatus({commit}, obj);
        }
      }, 10000)
    }, (err) => {
      console.log(err);
    })
  },
  readRunCaseStatus({commit}, obj) {
    api.getRunCaseStatus(obj).then((res) => {
      commit('READ_RUN_CASE_STATUS', res);
      window.setTimeout(function() {
        if (res.metadata.refresh) {
          actions.readProjectTestCaseStatus(obj);
        }
      }, 10000)
    }, (err) => {
      console.log(err);
    })
  },
  readTestCaseStatus({commit}, obj) {
    api.getTestCaseStatus(obj).then((res) => {
      commit('READ_TESTCASE_STATUS', res);
      window.setTimeout(function() {
        if (res.metadata.refresh) {
          actions.readProjectTestCaseStatus(obj);
        }
      }, 10000)
    }, (err) => {
      console.log(err);
    })
  },
  readProjectStatusForMessage({state}, obj) {
    return api.readProjectStatusForMessage(obj);
  },
  readRunListForMessage({state}, obj) {
    return api.getRunListStatusForMessage(obj);
  }
};

export default {
  state,
  getters,
  mutations,
  actions
}
