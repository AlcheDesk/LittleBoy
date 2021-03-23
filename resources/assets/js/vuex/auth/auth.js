//TODO
//need import types, types is about mutations_types
import * as types from '../types'
import * as api from '../../axios/auth/auth'
import { Message } from 'element-ui';


const state = {
};

const getters = {
};


const mutations = {
};

const actions = {
  login({commit}, obj) {
    return api.login(obj);
  },
  register({commit}, obj) {
    return api.register(obj);
  }
};

export default {
  state,
  getters,
  mutations,
  actions
}
