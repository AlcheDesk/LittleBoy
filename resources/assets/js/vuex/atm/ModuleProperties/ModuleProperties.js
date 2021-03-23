//TODO
//need import types, types is about mutations_types
import * as types from '../../types'
import * as api from '../../../axios/atm/modulePro/apiModuleProperties'



const state = {
    driverPacks: {},
    packsEngines: {},
    engines: {},
    engineProperties: {},
    driverType: {},
    driverVendor: {},
    driverPropertyPredefinedValues: {},
    testCaseDriverMaps: {},
    runSetDriverMaps: {},
    testCaseDriverPacks: {},
    runSetDriverPacks: {},
    systemRequirements: {},
    systemRequirementPacks: {},
    packSystemRequirements: {},
};

const getters = {
    getDriverPacks(state) {
        return state.driverPacks;
    },
    getPacksEngines(state) {
        return state.packsEngines;
    },
    getEngines(state) {
        return state.engines;
    },
    getSelectEngines(state) {
        return state.engines.data ? state.engines.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getEngineProperties(state) {
        return state.engineProperties;
    },
    getDriverType(state) {
        return state.driverType.data ? state.driverType.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getDriverVendor(state) {
        return state.driverVendor.data ? state.driverVendor.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getDriverPropertyPredefinedValues(state) {
        return state.driverPropertyPredefinedValues.data ? state.driverPropertyPredefinedValues.data.map(item => { return { label: item.value, value: item.value } }) : [];
    },
    getSelectTestCaseDriverMaps(state) {
        return state.testCaseDriverMaps.data ? state.testCaseDriverMaps.data.map(item => { return { label: item.type } }) : [];
    },
    getSelectRunSetDriverMaps(state) {
        return state.runSetDriverMaps.data ? state.runSetDriverMaps.data.map(item => { return { label: item.type } }) : [];
    },
    getSelectTestCaseDriverPacks(state) {
        return state.testCaseDriverPacks.data ? state.testCaseDriverPacks.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectSystemRequirements(state) {
        return state.systemRequirements.data ? state.systemRequirements.data.map(item => {
            return {
                label: item.name,
                value: item
            }
        }) : [];
    },
    getSystemRequirementPacks(state) {
        return state.systemRequirementPacks;
    },
    getPackSystemRequirements(state) {
        return state.packSystemRequirements;
    }
};


const mutations = {
    [types.READ_DRIVER_PACK](state, obj) {
        state.driverPacks = obj || {};
    },
    [types.READ_PACKS_ENGINES](state, obj) {
        state.packsEngines = obj || {};
    },
    [types.READ_ENGINES](state, obj) {
        state.engines = obj || {};
    },
    [types.READ_ENGINE_PROPERTIES](state, obj) {
        state.engineProperties = obj || {};
    },
    [types.READ_DRIVER_TYPE](state, obj) {
        state.driverType = obj || {};
    },
    [types.READ_DRIVER_VENDOR](state, obj) {
        state.driverVendor = obj || {};
    },
    [types.READ_DRIVER_PROPERTY_PREDEFINED_VALUE](state, obj) {
        state.driverPropertyPredefinedValues = obj || [];
    },
    [types.READ_TESTCASE_DRIVER_PACK](state, obj) {
        state.testCaseDriverPacks = obj || {};
    },
    [types.READ_RUNSET_DRIVER_PACK](state, obj) {
        state.runSetDriverPacks = obj || {};
    }, //
    [types.READ_SYSTEM_REQUIREMENT_PACKS](state, obj) {
        state.systemRequirementPacks = obj || {};
    },
    [types.READ_PACK_SYSTEM_REQUIREMENTS](state, obj) {
        state.packSystemRequirements = obj || {};
    },
    [types.READ_SYSTEM_REQUIREMENTS](state, obj) {
        state.systemRequirements = obj || {};
    },
};

const actions = {
    readDriverPacks({ commit }, obj) {
        api.getDriverPacks(obj).then((res) => {
            commit('READ_DRIVER_PACK', res);
        }, (err) => {
            console.log(err);
        })
    },
    addDriverPack({ commit }, obj) {
        return api.addDriverPack(obj);
    },
    deleteDriverPack({ commit }, obj) {
        return api.deleteDriverPack(obj);
    },
    validateDriverPacksName({ commit }, obj) {
        return api.validateDriverPacksName(obj);
    },
    readPacksEngines({ commit }, obj) {
        return api.getPacksEngines(obj).then((res) => {
            commit('READ_PACKS_ENGINES', res);
        }, (err) => {
            console.log(err);
        })
    },
    addPacksEngines({ commit }, obj) {
        return api.addPacksENgines(obj);
    },
    deletePacksEngines({ commit }, obj) {
        return api.deletePacksEngines(obj);
    },
    readEngines({ commit }, obj) {
        api.getEngines(obj).then((res) => {
            commit('READ_ENGINES', res);
        }, (err) => {
            console.log(err);
        })
    },
    addEngines({ commit }, obj) {
        return api.addEngines(obj);
    },
    deleteEngines({ commit }, obj) {
        return api.deleteEngines(obj);
    },
    readEngineProperties({ commit }, obj) {
        api.getEngineProperties(obj).then((res) => {
            commit('READ_ENGINE_PROPERTIES', res);
        }, (err) => {
            console.log(err);
        })
    },
    addEngineProperties({ commit }, obj) {
        return api.addEngineProperties(obj);
    },
    deleteEngineProperties({ commit }, obj) {
        return api.deleteEngineProperties(obj);
    },
    readEngineForMessage({ commit }, obj) {
        return api.readEngineForMessage(obj);
    },
    readDriverType({ commit }) {
        api.readDriverType().then((res) => {
            commit('READ_DRIVER_TYPE', res);
        })
    },
    readDriverVendor({ commit }, obj) {
        api.readDriverVendor(obj).then((res) => {
            commit('READ_DRIVER_VENDOR', res);
        })
    },
    readDriverPropertiesPredefinedValue({ commit }, obj) {
        api.readDriverPropertiesPredefinedValue(obj).then((res) => {
            commit('READ_DRIVER_PROPERTY_PREDEFINED_VALUE', res);
        })
    },
    validateDriversName({ commit }, obj) {
        return api.validateDriversName(obj);
    },
    readTestCaseDriverMaps({ commit }, obj) {
        return api.readTestCaseExecuteDriverMaps(obj);
    },
    readRunSetDriverMaps({ commit }, obj) {
        return api.readRunSetExecuteDriverMaps(obj);
    },
    readTestCaseDriverPacks({ commit }, obj) {
        api.readTestCaseExecuteDriverPacks(obj).then((res) => {
            commit('READ_TESTCASE_DRIVER_PACK', res);
        }, (err) => {
            console.log(err);
        })
    },
    readSystemRequirementPacks({ commit }, obj) {
        api.readSystemRequirementPacks(obj).then((res) => {
            commit('READ_SYSTEM_REQUIREMENT_PACKS', res);
        }, (err) => {
            console.log(err);
        })
    },
    addSystemRequirementPack({ commit }, obj) {
        return api.addSystemRequirementPack(obj);
    },
    deleteSystemRequirementPack({ commit }, obj) {
        return api.deleteSystemRequirementPack(obj);
    },
    validateSystemRequirementPack({ commit }, obj) {
        return api.validateSystemRequirementPack(obj);
    },
    readPackSystemRequirements({ commit }, obj) {
        api.readPackSystemRequirements(obj).then((res) => {
            commit('READ_PACK_SYSTEM_REQUIREMENTS', res);
        }, (err) => {
            console.log(err);
        })
    },
    addPackSystemRequirement({ commit }, obj) {
        return api.addPackSystemRequirement(obj);
    },
    deletePackSystemRequirement({ commit }, obj) {
        return api.deletePackSystemRequirement(obj);
    },
    readSystemRequirements({ commit }, obj) {
        api.readSystemRequirements(obj).then((res) => {
            commit('READ_SYSTEM_REQUIREMENTS', res);
        }, (err) => {
            console.log(err);
        })
    },
};

export default {
    state,
    getters,
    mutations,
    actions
}