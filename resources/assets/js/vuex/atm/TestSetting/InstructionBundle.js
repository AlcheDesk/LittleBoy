//TODO 
//need import types, types is about mutations_types
import * as types from '../../types'
import * as api from '../../../axios/atm/projectLib/apiInstructionBundle'

const state = {
  instructionBundle: {},
  instructionBundleEntry: {},
  instructionType: {},
  elementTypeForInstructionType: {}
};

const getters = {
  getInstructionBundle(state) {
    return state.instructionBundle;
  },
  getSelectInstructionBundle(state) {
    return state.instructionBundle.data ? state.instructionBundle.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getInstructionBundleEntry(state) {
    return state.instructionBundleEntry;
  },
  getSelectInstructionType(state) {
    return state.instructionType.data ? state.instructionType.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getSelectElementTypeForInstructionType(state) {
    return state.elementTypeForInstructionType.data ? state.elementTypeForInstructionType.data.map(item => { return { label: item.name, value: item } }) : [];
  },
};

const mutations = {
  [types.READ_INSTRUCTION_BUNDLE](state, obj) {
    state.instructionBundle = obj || {};
  },
  [types.READ_INSTRUCTION_BUNDLE_ENTRY](state, obj) {
    if (Object.prototype.toString.call(obj) == '[object Array]') {
      for (let i = 0; i < obj.length; i++) {
        if (!obj[i].hasOwnProperty('flag')) {
          obj[i].flag = false;
        }
      }
      state.instructionBundleEntry.data = obj || {};
    } else {
      for (let i = 0; i < obj.data.length; i++) {
        obj.data[i].flag = false;
      }
      state.instructionBundleEntry = obj || {};
    }
  },
  [types.READ_INSTRUCTION_TYPE](state, obj) {
    state.instructionType = obj || {};
  },
  [types.READ_ELEMENT_TYPES_FOR_INSTRUCTION_TYPE](state, obj) {
    state.elementTypeForInstructionType = obj || {};
  },
};

const actions = {
  readInstructionBundle({state, commit}, obj) {
    api.readInstructionBundle(obj).then((res) => {
      commit('READ_INSTRUCTION_BUNDLE', res);
    }, (err) => {
      console.log(err);
    })
  },
  addInstructionBundle({state, commit}, obj) {
    return api.addInstructionBundle(obj);
  },
  updateInstructionBundle({commit}, param) {
    return api.updateInstructionBundle(param);
  },
  removeInstructionBundle({state, commit}, obj) {
    return api.removeInstructionBundle(obj);
  },
  validateInstructionBundleName({commit}, obj) {
    return api.validateInstructionBundleName(obj);
  },
  readInstructionBundleEntry({state, commit}, obj) {
    api.readInstructionBundleEntry(obj).then((res) => {
      commit('READ_INSTRUCTION_BUNDLE_ENTRY', res);
    }, (err) => {
      console.log(err);
    })
  },
  addInstructionBundleEntry({state, commit}, obj) {
    return api.addInstructionBundleEntry(obj);
  },
  editInstructionBundleEntry({state, commit}, obj) {
    return api.editInstructionBundleEntry(obj);
  },
  removeInstructionBundleEntry({state, commit}, obj) {
    return api.removeInstructionBundleEntry(obj);
  },
  readInstructionBundleForMessage({state, commit}, obj) {
    return api.readInstructionBundleForMessage(obj);
  },
  readInstructionTypes({commit}, obj) {
    api.readInstructionTypes(obj).then((res) => {
      commit('READ_INSTRUCTION_TYPE', res);
    }, (err) => {
      console.log(err);
    })
  },
  readElementTypesForInstructionType({commit}, obj) {
    api.readElementTypesForInstructionType(obj).then((res) => {
      commit('READ_ELEMENT_TYPES_FOR_INSTRUCTION_TYPE', res);
    }, (err) => {
      console.log(err);
    })
  }
};

export default {
  state,
  getters,
  mutations,
  actions
}
