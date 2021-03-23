import * as types from '../../types'
import * as api from '../../../axios/atm/projectLib/apiTestCases'


const state = {
  testCases: {}
}

const getters = {
  getTestCases(state) {
    return state.testCases
  }
}

const mutations = {
  [types.READ_TESTCASES](state, obj) {
    state.testCases = obj;
  }
}

const actions = {
  readTestCases({commit}, obj) {
    api.readTestCases(obj).then((res) => {
      commit('READ_TESTCASES', res);
    }, (err) => {
      console.log(err);
    })
  },
  readProjectForTestCase({commit}, obj) {
    return api.readProjectForTestCase(obj);
  }
}

export default {
  state,
  getters,
  mutations,
  actions
}
