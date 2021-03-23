import * as types from '../../types.js'
import * as api from '../../../axios/atm/projectLib/apiTest'

const state = {
  projectApiElements: {},
  schemas: {},
  apiTypes: {},
}

const getters = {
  getProjectApiElements(state) {
    return state.projectApiElements;
  },
  getSelectProjectApiElements(state) {
    return state.projectApiElements.data ? state.projectApiElements.data.map(item => {
      // if (!item.isDriver) {
        return { label: item.name, value: item }
      // }
    }) : [];
  },
  getSchemas(state) {
    return state.schemas.data ? state.schemas.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getApiTypes(state) {
    return state.apiTypes.data ? state.apiTypes.data.map(item => { return { label: item.name, value: item } }) : [];
  }
}

const mutations = {
  [types.READ_PROJECT_API_ELEMENT](state, obj) {
    state.projectApiElements = obj || {};
  },
  [types.READ_SCHEMA](state, obj) {
    state.schemas = obj || {};
  },
  [types.READ_API_TYPES](state, obj) {
    state.apiTypes = obj || {};
  }
}

const actions = {
  readProjectApiElements({commit}, obj) {
    api.readProjectApiElements(obj).then((res) => {
      commit('READ_PROJECT_API_ELEMENT', res);
    })
  },
  addProjectApiElement({commit}, obj) {
    return api.addProjectApiElement(obj);
  },
  addProjectApiElementInInstruction({commit}, obj) {
    return api.addProjectApiElementInInstruction(obj);
  },
  updateProjectApiElement({commit}, obj) {
    return api.updateProjectApiElement(obj);
  },
  deleteProjectApiElement({commit}, obj) {
    return api.deleteProjectApiElement(obj);
  },
  readSchemas({commit}) {
    api.readSchemas().then((res) => {
      commit('READ_SCHEMA', res);
    })
  },
  putSchema({commit}, obj) {
    api.putSchema(obj).then((res) => {
      actions.readSchemas({commit});
    })
  },
  apiUnitCalls({commit}, obj) {
    return api.apiUnitCalls(obj);
  },
  validateApiElementName({commit}, obj) {
    return api.validateApiElementName(obj);
  },
  readApiTypes({commit}) {
    api.readApiTypes().then((res) => {
      commit('READ_API_TYPES', res);
    })
  },
  //PreExecution
  httpPreExecution({commit}, obj) {
    return api.httpPreExecution(obj);
  },
  webServicePreExecution({commit}, obj) {
    return api.webServicePreExecution(obj);
  },
  redisPreExecution({commit}, obj) {
    return api.redisPreExecution(obj);
  },
  validateRedisResult({commit}, obj) {
    return api.validateRedisResult(obj);
  }
}

export default {
  state, getters, mutations, actions
}
