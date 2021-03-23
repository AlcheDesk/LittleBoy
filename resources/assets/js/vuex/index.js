import Vue from 'vue'
import Vuex from 'vuex'

//auth
import auth from './auth/auth';
import RBAC from './RBAC/RBAC';
import EMS from './ems/EMS';
import ProjectLib from './atm/TestSetting/ProjectLib'
import Folder from './atm/TestSetting/Folder'
import TestCases from './atm/TestSetting/TestCases'
import RunSet from './atm/TestSetting/RunSet'
import InstructionBundle from './atm/TestSetting/InstructionBundle'
import ApiTest from './atm/TestSetting/ApiTest'
import RunStatus from './atm/RunStatus/RunStatus'
import RunResults from './atm/RunResults/RunResults'
import ModuleProperties from './atm/ModuleProperties/ModuleProperties'

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    auth,
    RBAC,
    EMS,
    ProjectLib,
    Folder,
    TestCases,
    ApiTest,
    RunSet,
    InstructionBundle,
    RunStatus,
    RunResults,
    ModuleProperties
  }
});

export default store;