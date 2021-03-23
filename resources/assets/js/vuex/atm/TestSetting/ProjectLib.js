//TODO
//need import types, types is about mutations_types
import * as types from '../../types'
import * as api from '../../../axios/atm/projectLib/apiProjectLib'


const state = {
    projects: {},
    projectTypes: {},
    projectTestCases: {},
    projectRefTestCases: {},
    folders: {},
    folderTestCase: {},
    testCaseInstructions: {},
    instructionOptionTypes: {},
    projectApplications: {},
    applicationSections: {},
    sectionElements: {},
    sectionLines: {},
    instructionActions: {},
    elementTypes: {},
    elementLocatorTypes: {},
    storages: {},
    environments: {},
    testCaseStorage: {},
    testCaseEngines: {},
    testCaseEnvironments: {},
    setproperties: {},
    groups: {},
    deletedTestCases: {},
    webBroswerInstructionAction: {},
    stringUtilInstructionAction: {},
    testCaseOverWriteInstructions: {},
    testCaseOverWrites: {},
    refrenceTestCaseOverWrites: {},
    tagsForTestCase: {},
    typesForTestCase: {},
    redisInstructionAction: {},
    fileTypes: {},
    filePath: {}
};

const getters = {
    getProjects(state) {
        return state.projects;
    },
    getSelectProject(state) {
        return state.projects.data ? state.projects.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectProjectType(state) {
        return state.projectTypes.data ? state.projectTypes.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSystemSetting(state) {
        return state.setproperties;
    },
    getProjectTestCase(state) {
        return state.projectTestCases;
    },
    getSelectProjectTestCase(state) {
        return state.projectTestCases.data ? state.projectTestCases.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectTestCase(state) {
        return state.projectRefTestCases.data ? state.projectRefTestCases.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getTestCaseInstructions(state) {
        return state.testCaseInstructions;
    },
    getSelectInstructionOptionTypes(state) {
        return state.instructionOptionTypes.data ? state.instructionOptionTypes.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectApplications(state) {
        return state.projectApplications.data ? state.projectApplications.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectSections(state) {
        return state.applicationSections.data ? state.applicationSections.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectElements(state) {
        return state.sectionElements.data ? state.sectionElements.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getElementTypes(satte) {
        return state.elementTypes.data ? state.elementTypes.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getElementLocatorTypes(satte) {
        return state.elementLocatorTypes.data ? state.elementLocatorTypes.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectElementLocatorTypes(satte) {
        return state.elementLocatorTypes.data ? state.elementLocatorTypes.data.map(item => { return { label: item.name, value: item.name } }) : [];
    },
    // getSectionLines(state) {
    //   return state.sectionLines;
    // },
    getInstructionActions(state) {
        return state.instructionActions.data ? state.instructionActions.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getWebBroswerInstructionActions(state) {
        return state.webBroswerInstructionAction.data ? state.webBroswerInstructionAction.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getRedisInstructionActions(state) {
        return state.redisInstructionAction.data ? state.redisInstructionAction.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getStringUtilInstructionActions(state) {
        return state.stringUtilInstructionAction.data ? state.stringUtilInstructionAction.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getProjectApplications(state) {
        return state.projectApplications;
    },
    getApplicationSections(state) {
        return state.applicationSections;
    },
    getSectionElements(state) {
        return state.sectionElements;
    },
    getStorages(state) {
        return state.storages;
    },
    getSelectStorages(state) {
        return state.storages.data ? state.storages.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getEnvironments(state) {
        return state.environments.data ? state.environments.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getTestCaseStorage(state) {
        return state.testCaseStorage.data ? state.testCaseStorage.data.map(item => { return { label: item.name, value: item.id } }) : [];
    },
    getTestCaseEngine(state) {
        return state.testCaseEngines.data ? state.testCaseEngines.data.map(item => { return { label: item.name, value: item.id } }) : [];
    },
    getTestCaseEnvironment(state) {
        return state.testCaseEnvironments.data ? state.testCaseEnvironments.data.map(item => { return { label: item.name, value: item.id } }) : [];
    },
    getSelectGroups(state) {
        return state.groups.data ? state.groups.data.map(item => { return { label: item.name, value: item.name } }) : [];
    },
    getDeletedTestCases(state) {
        return state.deletedTestCases.data ? state.deletedTestCases.data.map(item => { return { label: item.name, value: item.id } }) : [];
    },
    getTestCaseOverWriteInstructions(state) {
        return state.testCaseOverWriteInstructions;
    },
    getTestCaseOverwrites(state) {
        return state.testCaseOverWrites;
    },
    getSelectTestCaseOverwrites(state) {
        return state.testCaseOverWrites.data ? state.testCaseOverWrites.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectRefrenceTestCaseOverwrites(state) {
        return state.refrenceTestCaseOverWrites.data ? state.refrenceTestCaseOverWrites.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectTagsForTestCase(state) {
        return state.tagsForTestCase.data ? state.tagsForTestCase.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectTypesForTestCase(state) {
        return state.typesForTestCase.data ? state.typesForTestCase.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectFileTypes(state) {
        return state.fileTypes.data ? state.fileTypes.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getSelectFilePath(state) {
        return state.filePath.data ? state.filePath.data.map(item => { return { label: item.path, value: item } }) : [];
    }
};

const mutations = {
    [types.READ_PROJECT](state, obj) {
        state.projects = obj || {};
    },
    [types.READ_PROJECT_TYPE](state, arr) {
        state.projectTypes = arr || [];
    },

    [types.READ_SYSTEM_SETTING](state, arr) {
        state.setproperties = arr || [];
    },
    [types.UPDATE_SYSTEM_SETTING](state, obj) {
        for (let i = 0; i < state.setproperties.length; i++) {
            if (state.setproperties[i].id == obj.id) {
                state.setproperties.splice(i, 1, obj);
            }
        }
    },

    [types.READ_PROJECT_TESTCASE](state, obj) {
        state.projectTestCases = obj || {};
    },
    [types.READ_REF_PROJECT_TESTCASE](state, obj) {
        state.projectRefTestCases = obj || {};
    },
    [types.READ_DELETED_TESTCASE](state, obj) {
        state.deletedTestCases = obj || {};
    },

    [types.READ_GROUPS](state, obj) {
        state.groups = obj || {};
    },
    [types.READ_PROJECT_APPLICATIONS](state, obj) {
        state.projectApplications = obj || {};
    },
    [types.READ_APPLICATION_SECTIONS](state, obj) {
        state.applicationSections = obj || {};
    },
    [types.READ_SECTION_ELEMENTS](state, obj) {
        state.sectionElements = obj || {};
    },
    [types.READ_ELEMENT_TYPES](state, obj) {
        state.elementTypes = obj || {};
    },
    [types.READ_ELEMENT_LOCATOR_TYPES](state, obj) {
        state.elementLocatorTypes = obj || {};
    },
    // [types.READ_SECTION_LINES](state, obj) {
    //   state.sectionLines = obj || {};
    // },
    [types.READ_INSTRUCTION_ACTIONS](state, obj) {
        state.instructionActions = obj || {};
    },
    [types.READ_WEBBROWSER_INSTRUCTION_ACTIONS](state, obj) {
        state.webBroswerInstructionAction = obj || {};
    },
    [types.READ_STRINGUTIL_INSTRUCTION_ACTIONS](state, obj) {
        state.stringUtilInstructionAction = obj || {};
    },
    [types.READ_REDIS_INSTRUCTION_ACTIONS](state, obj) {
        state.redisInstructionAction = obj || {};
    },
    [types.READ_TESTCASE_INSTRUCTIONS](state, obj) {
        state.testCaseInstructions = obj || {};
    },
    [types.READ_INSTRUCTION_OPTION_TYPES](state, obj) {
        state.instructionOptionTypes = obj || {};
    },
    [types.READ_STORAGES](state, obj) {
        state.storages = obj || {};
    },
    [types.READ_ENVIRONMENTS](state, obj) {
        state.environments = obj || {};
    },
    [types.READ_TESTCASE_STORAGES](state, obj) {
        state.testCaseStorage = obj || {};
    },
    [types.READ_TESTCASE_ENGINES](state, obj) {
        state.testCaseEngines = obj || {};
    },
    [types.READ_TESTCASE_ENVIRONMENTS](state, obj) {
        state.testCaseEnvironments = obj || {};
    },
    [types.READ_TESTCASE_OVERWRITE_INSTRUCTIONS](state, obj) {
        state.testCaseOverWriteInstructions = obj || {};
    },
    [types.READ_TESTCASE_OVERWRITE](state, obj) {
        state.testCaseOverWrites = obj || {};
    },
    [types.READ_REFRENCE_TESTCASE_OVERWRITE](state, obj) {
        state.refrenceTestCaseOverWrites = obj || {};
    },
    [types.READ_TAGS_FOR_TESTCASE](state, obj) {
        state.tagsForTestCase = obj || {};
    },
    [types.READ_TYPES_FOR_TESTCASE](state, obj) {
        state.typesForTestCase = obj || {};
    },
    [types.READ_FILE_TYPES](state, obj) {
        state.fileTypes = obj || {};
    },
    [types.READ_FILE_PATH](state, obj) {
        state.filePath = obj || {};
    }
};

const actions = {
    readProjects({ state, commit }, obj) {
        api.getProjects(obj).then((res) => {
            commit('READ_PROJECT', res);
        }, (err) => {
            console.log(err);
        });
    },
    addProject({ state, commit }, obj) {
        return api.addProject(obj);
    },
    deleteProject({ state, commit }, obj) {
        return api.deleteProject(obj);
    },
    updateProject({ state, commit }, obj) {
        return api.updateProject(obj);
    },
    saveasProject({ state, commit }, obj) {
        return api.projectCopy(obj);
    },
    readProjectTypes({ state, commit }) {
        api.readProjectTypes().then((res) => {
            commit('READ_PROJECT_TYPE', res);
        }, (err) => {
            console.log(err);
        })
    },

    //systemSetting
    readSystemSetting({ state, commit }, obj) {
        api.readSystemSetting(obj).then((res) => {
            commit('READ_SYSTEM_SETTING', res);
        }, (err) => {
            console.log(err);
        })
    },
    updateSystemSetting({ state, commit }, obj) {
        return api.updateSystemSetting(obj);
    },

    //projectTestcase
    readProjectTestCases({ state, commit }, obj) {
        api.readProjectTestCases(obj).then((res) => {
            commit('READ_PROJECT_TESTCASE', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRefProjectTestCases({ state, commit }, obj) {
        api.readRefProjectTestCases(obj).then((res) => {
            commit('READ_REF_PROJECT_TESTCASE', res);
        }, (err) => {
            console.log(err);
        })
    },
    addProjectTestCase({ state, commit }, obj) {
        return api.addProjectTestCase(obj);
    },
    deleteProjectTestCase({ state, commit }, obj) {
        return api.deleteProjectTestCase(obj);
    },
    saveasProjectTestCase({ state, commit }, obj) {
        return api.projectTestCaseCopy(obj);
    },
    markProjectTestCase({ state, commit }, obj) {
        return api.projectTestCaseMark(obj);
    },
    addProjectTestCaseFromFolder({ state, commit }, obj) {
        return api.addProjectTestCaseFromFolder(obj);
    },
    readDeletedTestCases({ state, commit }) {
        api.readDeletedTestCases().then((res) => {
            commit('READ_DELETED_TESTCASE', res);
        }, (err) => {
            console.log(err);
        })
    },
    addDeletedTestCasesToProject({ state }, obj) {
        return api.addDeletedTestCasesToProject(obj);
    },

    readGroups({ commit }, obj) {
        api.readGroups(obj).then((res) => {
            commit('READ_GROUPS', res);
        }, (err) => {
            console.log(err);
        })
    },

    //application
    readProjectApplications({ state, commit }, obj) {
        api.readProjectApplications(obj).then((res) => {
            commit('READ_PROJECT_APPLICATIONS', res);
        }, (err) => {
            console.log(err);
        })
    },
    addProjectApplication({ state, commit }, obj) {
        return api.addProjectApplication(obj);
    },
    deleteProjectApplication({ state, commit }, obj) {
        return api.deleteProjectApplication(obj);
    },
    updateProjectApplication({ state, commit }, obj) {
        return api.updateProjectApplication(obj);
    },
    //section
    readApplicationSections({ state, commit }, obj) {
        api.readApplicationSections(obj).then((res) => {
            commit('READ_APPLICATION_SECTIONS', res);
        }, (err) => {
            console.log(err);
        })
    },
    addApplicationSection({ state, commit }, obj) {
        return api.addApplicationSection(obj);
    },
    deleteApplicationSection({ state, commit }, obj) {
        return api.deleteApplicationSection(obj);
    },
    updateApplicationSection({ state, commit }, obj) {
        return api.updateApplicationSection(obj);
    },
    //element
    readSectionElements({ state, commit }, obj) {
        api.readSectionElements(obj).then((res) => {
            commit('READ_SECTION_ELEMENTS', res);
        }, (err) => {
            console.log(err);
        })
    },
    addSectionElement({ state, commit }, obj) {
        return api.addSectionElement(obj);
    },
    deleteSectionElement({ state, commit }, obj) {
        return api.deleteSectionElement(obj);
    },
    updateSectionElement({ satte, commit }, obj) {
        return api.updateSectionElement(obj)
    },
    readElementTypes({ satte, commit }) {
        api.readElementTypes().then((res) => {
            commit('READ_ELEMENT_TYPES', res);
        }, (err) => {
            console.log(err);
        })
    },
    readElementTypeUpdate({ satte, commit }) {
        return api.readElementTypes();
    },
    readElementLocatorTypes({ satte, commit }, obj) {
        api.readElementLocatorTypes(obj).then((res) => {
            commit('READ_ELEMENT_LOCATOR_TYPES', res);
        }, (err) => {
            console.log(err);
        })
    },
    readInstructionActions({ state, commit }, obj) {
        api.readInstructionActions(obj).then((res) => {
            commit('READ_INSTRUCTION_ACTIONS', res);
        }, (error) => {
            console.log(error);
        })
    },
    readWebBrowserInstructionActions({ state, commit }, obj) {
        api.readWebBrowserInstructionAction(obj).then((res) => {
            commit('READ_WEBBROWSER_INSTRUCTION_ACTIONS', res);
        }, (error) => {
            console.log(error);
        })
    },
    readRedisInstructionActions({ state, commit }, obj) {
        api.readRedisInstructionAction(obj).then((res) => {
            commit('READ_REDIS_INSTRUCTION_ACTIONS', res);
        }, (error) => {
            console.log(error);
        })
    },
    readStringUtilInstructionActions({ state, commit }, obj) {
        api.readStringUtilInstructionAction(obj).then((res) => {
            commit('READ_STRINGUTIL_INSTRUCTION_ACTIONS', res);
        }, (error) => {
            console.log(error);
        })
    },
    readElementRelevance({ state, commit }, obj) {
        return api.readElementRelevance(obj);
    },
    //instruction
    readTestCaseInstructions({ state, commit }, obj) {
        api.readTestCaseInstructions(obj).then((res) => {
            commit('READ_TESTCASE_INSTRUCTIONS', res)
        }, (err) => {
            console.log(err);
        })
    },
    addTestCaseInstruction({ state, commit }, obj) {
        return api.addTestCaseInstruction(obj);
    },
    deleteTestCaseInstruction({ state, commit }, obj) {
        return api.deleteTestCaseInstruction(obj);
    },
    updateTestCaseInstruction({ state, commit }, obj) {
        return api.updateTestCaseInstruction(obj);
    },
    copyTestCaseInstruction({ state }, obj) {
        return api.copyTestCaseInstruction(obj);
    },
    readInstructionOptionTypes({ commit }, obj) {
        api.readInstructionOptionTypes(obj).then((res) => {
            commit('READ_INSTRUCTION_OPTION_TYPES', res);
        }, (err) => {
            console.log(err);
        })
    },
    addInstructionOptionType({ commit }, obj) {
        return api.addInstructionOptionType(obj);
    },
    updateInstructionOptionType({ commit }, obj) {
        return api.updateInstructionOptionType(obj);
    },
    deleteInstructionOptionType({ commit }, obj) {
        return api.deleteInstructionOptionType(obj);
    },
    readInstructionOptions({ commit }, obj) {
        api.readInstructionOptions(obj).then((res) => {
            commit('READ_INSTRUCTION_OPTION_TYPES', res);
        }, (err) => {
            console.log(err);
        })
    },
    //about set environment
    readStorages({ state, commit }) {
        api.readStorages().then((res) => {
            commit('READ_STORAGES', res);
        }, (err) => {
            console.log(err);
        })
    },
    addStorage({ state, commit }, obj) {
        return api.addStorage(obj);
    },
    deleteStorage({ state, commit }, obj) {
        return api.deleteStorage(obj);
    },
    linkTestCaseStorage({ state, commit }, obj) {
        api.linkTestCaseStorage(obj).then((res) => {
            console.log(res, 'linkTestCaseStorage');
        }, (err) => {
            console.log(err);
        })
    },
    deleteTestCaseStorage({ commit }, obj) {
        return api.deleteTestCaseStorage(obj);
    },
    readTestCaseStorage({ state, commit }, obj) {
        api.readTestCaseStorage(obj).then((res) => {
            commit('READ_TESTCASE_STORAGES', res);
        }, (err) => {
            console.log(err);
        })
    },
    readEnvironments({ state, commit }) {
        api.readEnvironments().then((res) => {
            commit('READ_ENVIRONMENTS', res);
        }, (err) => {
            console.log(err);
        })
    },
    linkTestCaseEnvironment({ state, commit }, obj, param) {
        api.linkTestCaseEnvironment(obj, param).then((res) => {
            console.log(res, 'linkTestCaseEnvironment');
        }, (err) => {
            console.log(err);
        })
    },
    deleteTestCaseEnvironment({ commit }, obj) {
        return api.deleteTestCaseEnvironment(obj);
    },
    readTestCaseEnvironment({ state, commit }, obj) {
        api.readTestCaseEnvironments(obj).then((res) => {
            commit('READ_TESTCASE_ENVIRONMENTS', res);
        }, (err) => {
            console.log(err);
        })
    },
    readTestCaseEngine({ state, commit }, obj) {
        api.readTestCaseEngines(obj).then((res) => {
            commit('READ_TESTCASE_ENGINES', res);
        }, (err) => {
            console.log(err);
        })
    },
    linkTestCaseEngine({ state, commit }, obj) {
        api.linkTestCaseEngine(obj).then((res) => {
            console.log(res, 'linkTestCaseEngine');
        }, (err) => {
            console.log(err);
        })
    },
    deleteTestCaseEngine({ commit }, obj) {
        return api.deleteTestCaseEngine(obj);
    },
    runTestCases({ state, commit }, obj) {
        return api.runTestCases(obj);
    },
    validateProjectName({ state, commit }, obj) {
        return api.validateProjectName(obj);
    },
    validateTestCaseName({ state, commit }, obj) {
        return api.validateTestCaseName(obj);
    },
    validateApplicationName({ state, commit }, obj) {
        return api.validateApplicationName(obj);
    },
    validateSectionName({ state }, obj) {
        return api.validateSectionName(obj);
    },
    validateSectionElementName({ state, commit }, obj) {
        return api.validateElementName(obj);
    },
    //read something for message
    readProjectFormessage({ state, commit }, obj) {
        return api.readProjectForMessage(obj);
    },
    readTestCaseForMessage({ state, commit }, obj) {
        return api.readTestCaseForMessage(obj);
    },
    readApplicationForMessage({ state, commit }, obj) {
        return api.readApplicationForMessage(obj);
    },
    readSectionForMessage({ state, commit }, obj) {
        return api.readSectionForMessage(obj);
    },
    readFileDownLoadMessage({ commit }) {
        return api.readFileDownLoadMessage();
    },
    //overwrite instruction
    readTestCaseOverWriteInstructions({ commit }, obj) {
        api.readTestCaseOverWriterInstructions(obj).then((res) => {
            commit('READ_TESTCASE_OVERWRITE_INSTRUCTIONS', res);
        }, (err) => {
            console.log(err);
        })
    },
    putInstructionOverWrite({ commit }, obj) {
        return api.addInstructionOverWrite(obj);
    },
    deleteInstructionOverwrite({ commit }, obj) {
        return api.deleteInstructionOverwrite(obj);
    },
    //testCase
    readTestCaseOverWrites({ commit }, obj) {
        api.readTestCaseOverwrites(obj).then((res) => {
            commit('READ_TESTCASE_OVERWRITE', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRefrenceTestCaseOverwrites({ commit }, obj) {
        api.readTestCaseOverwrites(obj).then((res) => {
            commit('READ_REFRENCE_TESTCASE_OVERWRITE', res);
        }, (err) => {
            console.log(err);
        })
    },
    addTestCaseOverWrite({ commit }, obj) {
        return api.addTestCaseOverwrite(obj);
    },
    deleteTestCaseOverwrite({ commit }, obj) {
        return api.deleteTestCaseOverwrite(obj);
    },
    copyTestCaseOverwrite({ commit }, obj) {
        return api.copyTestCaseOverwrite(obj);
    },
    validateTestCaseOverWrite({ state, commit }, obj) {
        return api.validateTestCaseOverWrites(obj);
    },
    validateTestCaseRefrence({ commit }, obj) {
        return api.validateTestCaseRefrence(obj);
    },
    readTags({ commit }, obj) {
        api.readTags(obj).then((res) => {
            commit('READ_TAGS_FOR_TESTCASE', res);
        }, (err) => {
            console.log(err);
        })
    },
    addTags({ commit }, obj) {
        return api.addTags(obj);
    },
    updateTags({ commit }, obj) {
        return api.updateTags(obj);
    },
    removeTags({ commit }, obj) {
        return api.removeTags(obj);
    },
    addTagsForTestCase({ commit }, obj) {
        return api.addTagsForTestCase(obj);
    },
    editTagsForTestCase({ commit }, obj) {
        return api.editTagsForTestCase(obj);
    },
    deleteTagsForTestCase({ commit }, obj) {
        return api.deleteTagsForTestCase(obj);
    },
    countTestCaseOverwriterInstruction({ commit }, obj) {
        return api.countTestCaseOverwriterInstruction(obj);
    },
    countTestCaseOverwriterElement({ commit }, obj) {
        return api.countTestCaseOverwriterElement(obj);
    },
    countRemoveTagsForTestCase({ commit }, obj) {
        return api.countRemoveTagsForTestCase(obj);
    },
    readTestCaseTypes({ commit }, obj) {
        api.readTestCaseTypes(obj).then((res) => {
            commit('READ_TYPES_FOR_TESTCASE', res);
        }, (err) => {
            console.log(err);
        })
    },
    //file types and path
    readFileTypes({ commit }) {
        api.readFileTypes().then((res) => {
            commit('READ_FILE_TYPES', res);
        }, (err) => {
            console.log(err);
        })
    },
    readFilePath({ commit }, obj) {
        api.readFilePath(obj).then((res) => {
            commit('READ_FILE_PATH', res);
        }, (err) => {
            console.log(err);
        })
    },
    validateTestCaseDelete({ commit }, obj) {
        return api.validateTestCaseDelete(obj);
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}