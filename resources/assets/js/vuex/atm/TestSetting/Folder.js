import * as types from '../../types'
import * as api from '../../../axios/atm/projectLib/apiFolder'

const state = {
  folders: {},
  folderTestCases: {},
}

const getters = {
  getFolders(state) {
    return state.folders;
  },
  getSelectFolder(state) {
    return state.folders.data ? state.folders.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getFolderTestCases(state) {
    return state.folderTestCases;
  },
  getSelectFolderTestCases(state) {
    return state.folderTestCases.data ? state.folderTestCases.data.map(item => { return { label: item.testCase.name, value: item } }) : [];
  }
}

const mutations = {
  [types.READ_FOLDERS](state, obj) {
    state.folders = obj;
  },
  [types.READ_FOLDER_TESTCASES](state, obj) {
    state.folderTestCases = obj;
  },
}

const actions = {
  readFolders({commit}, obj) {
    api.readFolders(obj).then((res) => {
      commit('READ_FOLDERS', res);
    }, (err) => {
      console.log(err);
    })
  },
  addFolder({commit}, obj) {
    return api.addFolder(obj);
  },
  updateFolder({commit}, obj) {
    return api.updateFolder(obj);
  },
  deleteFolder({commit}, obj) {
    return api.deleteFolder(obj);
  },
  validateFolderName({state, commit}, obj) {
    return api.validateFolderName(obj);
  },
  readFolderForMessage({commit}, obj) {
    return api.readFolderForMessage(obj);
  },
  readFolderTestCases({commit}, obj) {
    api.readFolderTestCases(obj).then((res) => {
      commit('READ_FOLDER_TESTCASES', res);
    }, (err) => {
      console.log(err);
    })
  },
  addFolderTestCase({commit}, obj) {
    return api.addFolderTestCase(obj);
  },
  deleteFolderTestCase({commit}, obj) {
    return api.deleteFolderTestCase(obj);
  },
}

export default {
  state,
  getters,
  mutations,
  actions
}
