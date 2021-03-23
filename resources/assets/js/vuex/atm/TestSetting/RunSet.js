//TODO 
//need import types, types is about mutations_types
import * as types from '../../types'
import * as api from '../../../axios/atm/projectLib/apiRunSet'

const state = {
  runContainers: {},
  refRunContainers: {},
  testCasesContainers: {},
  runListAlias: {},
  runSetNotifications: {},
  notifications: {},
  recipients: {}
};

const getters = {
  getRunContainer(state) {
    return state.runContainers;
  },
  getSelectRefRunContainer(state) {
    return state.refRunContainers.data ? state.refRunContainers.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getTestCaseContainer(state) {
    return state.testCasesContainers;
  },
  getSelectRunContainer(state) {
    return state.runContainers.data ? state.runContainers.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getSelectRunListAlias(state) {
    return state.runListAlias.data ? state.runListAlias.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getRunSetNotifications(state) {
    return state.runSetNotifications;
  },
  getSelectNotifications(state) {
    return state.notifications.data ? state.notifications.data.map(item => { return { label: item.subject, value: item } }) : [];
  },
  getSelectRecipients(state) {
    return state.recipients.data ? state.recipients.data.map(item => { return { label: item.name, value: item } }) : [];
  },
  getRecipients(state) {
    return state.recipients;
  }
};

const mutations = {
  [types.READ_RUN_CONTAINER](state, obj) {
    state.runContainers = obj || {};
  },
  [types.READ_REF_RUN_CONTAINER](state, obj) {
    state.refRunContainers = obj || {};
  },
  [types.READ_TESTCASE_CONTAINER](state, obj) {
    state.testCasesContainers = obj || {};
  },
  [types.READ_RUN_LIST_ALIAS](state, obj) {
    state.runListAlias = obj || {};
  },
  [types.READ_RUN_SET_NOTIFICATION](state, obj) {
    state.runSetNotifications = obj || {};
  },
  [types.READ_NOTIFICATION](state, obj) {
    state.notifications = obj || {};
  },
  [types.READ_RECIPIENT](state, obj) {
    state.recipients = obj || {};
  },
};

const actions = {
  readRunContainer({state, commit}, obj) {
    api.readRunContainer(obj).then((res) => {
      commit('READ_RUN_CONTAINER', res);
    }, (err) => {
      console.log(err);
    })
  },
  addRunContainer({state, commit}, obj) {
    return api.addRunContainer(obj);
  },
  updateRunContainer({commit}, param) {
    return api.updateRunContainer(param);
  },
  deleteRunContainer({state, commit}, obj) {
    return api.removeRunContainer(obj);
  },
  validateRunContainerName({commit}, obj) {
    return api.validateRunContainerName(obj);
  },
  readRefRunContainer({state, commit}, obj) {
    api.readRefRunContainer(obj).then((res) => {
      commit('READ_REF_RUN_CONTAINER', res);
    }, (err) => {
      console.log(err);
    })
  },
  readCountRefRunContainer({commit}, obj) {
    return api.readCountRefRunContainer(obj);
  },
  readTestCaseContainer({state, commit}, obj) {
    api.readTestCaseContainer(obj).then((res) => {
      commit('READ_TESTCASE_CONTAINER', res);
    }, (err) => {
      console.log(err);
    })
  },
  addTestCaseContainer({state, commit}, obj) {
    return api.addTestCaseContainer(obj);
  },
  countTestCaseContainerOverwriteOrDriverPack({commit}, obj) {
    return api.countTestCaseContainerOverwriteOrDriverPack(obj);
  },
  deleteTestCaseContainer({state, commit}, obj) {
    return api.removeTestCaseContainer(obj);
  },
  runRunSetTestCases({state, commit}, obj) {
    return api.runRunSetTestCases(obj);
  },
  readRunSettingForMessage({state, commit}, obj) {
    return api.readRunSettingForMessage(obj);
  },
  // testCaseSetTestCaseParam({commit}, obj) {
  //   return api.testCaseSetTestCaseParam(obj);
  // },
  readRunListAlias({commit}, obj) {
    api.readRunListAlias(obj).then((res) => {
      commit('READ_RUN_LIST_ALIAS', res);
    }, (err) => {
      console.log(err);
    })
  },
  addRunListAlias({commit}, obj) {
    return api.addRunListAlias(obj);
  },
  updateRunListAlias({commit}, obj) {
    return api.updateRunListAlias(obj);
  },
  removeRunListAlias({commit}, obj) {
    return api.removeRunListAlias(obj);
  },
  getRunListLinkAlias({commit}, obj) {
    return api.getRunListLinkAlias(obj);
  },
  setRunListLinkAlias({commit}, obj) {
    return api.setRunListLinkAlias(obj);
  },
  removeRunListLinkAlias({commit}, obj) {
    return api.removeRunListLinkAlias(obj);
  },
  countRemoveAliasForRunList({commit}, obj) {
    return api.countRemoveAliasForRunList(obj);
  },
  readRunSetNotification({commit}, obj) {
    api.readRunSetNotification(obj).then((res) => {
      commit('READ_RUN_SET_NOTIFICATION', res);
    })
  },
  addRunSetNotification({commit}, obj) {
    return api.addRunSetNotification(obj);
  },
  deleteRunSetNotification({commit}, obj) {
    return api.deleteRunSetNotification(obj);
  },
  readNotification({commit}, obj) {
    api.readNotification(obj).then((res) => {
      commit('READ_NOTIFICATION', res);
    })
  },
  addNotification({commit}, obj) {
    return api.addNotification(obj);
  },
  updateNotification({commit}, obj) {
    return api.updateNotification(obj);
  },
  deleteNotification({commit}, obj) {
    return api.deleteNotification(obj);
  },
  readRecipient({commit}, obj) {
    api.readRecipient(obj).then((res) => {
      commit('READ_RECIPIENT', res);
    })
  },
  addRecipient({commit}, obj) {
    return api.addRecipient(obj);
  },
  updateRecipient({commit}, obj) {
    return api.updateRecipient(obj);
  },
  deleteRecipient({commit}, obj) {
    return api.deleteRecipient(obj);
  },
  countEmailsAddress({commit}, obj) {
    return api.countEmailsAddress(obj);
  },
  readRunSetAlarmSet({commit}, obj) {
    return api.readRunSetAlarmSet(obj);
  },
  addOrUpdateRunSetAlarmSet({commit}, obj) {
    return api.addOrUpdateRunSetAlarmSet(obj);
  },
  deleteRunSetAlarmSet({commit}, obj) {
    return api.deleteRunSetAlarmSet(obj);
  }
};

export default {
  state,
  getters,
  mutations,
  actions
}
