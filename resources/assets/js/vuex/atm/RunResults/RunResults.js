//TODO
//need import types, types is about mutations_types
import * as types from '../../types'
import * as api from '../../../axios/atm/runResult/apiRunResult'



const state = {
    runResultProjects: {},
    runResultProjectsChart: {},
    runResultProjectTestCases: {},
    runResultProjectTestCaseRuns: {},
    runResultProjectTestCaseRunInstructions: {},
    runResultProjectTestCaseRunInstructionLog: {},
    runListResult: {},
    runCaseResult: {},
    testCaseResult: {}
};

const getters = {
    getRunResultProjects(state) {
        return state.runResultProjects;
    },
    getRunResultProjectsChart(state) {
        return state.runResultProjectsChart;
    },
    getTestCaseExecutionInfoByProjectId(state) {
        return state.runResultProjectTestCases;
    },
    getRunResultProjectTestCaseRuns(state) {
        return state.runResultProjectTestCaseRuns;
    },
    getRunResultProjectTestCaseRunInstructions(state) {
        return state.runResultProjectTestCaseRunInstructions;
    },
    getRunResultProjectTestCaseRunInstructionlog(state) {
        return state.runResultProjectTestCaseRunInstructionLog;
    },
    getRunListResults(state) {
        return state.runListResult;
    },
    getRunCaseResult(state) {
        return state.runCaseResult;
    },
    getTestCaseResult(state) {
        return state.testCaseResult;
    }
};

const mutations = {
    [types.READ_RUNRESULT_PROJECTS](state, obj) {
        state.runResultProjects = obj || {};
    },
    [types.READ_RUNRESULT_PROJECT_CHARTS](state, obj) {
        state.runResultProjectsChart = obj || {};
    },
    [types.READ_RUNRESULT_PROJECT_TESTCASES](state, obj) {
        state.runResultProjectTestCases = obj || {};
    },
    [types.READ_RUNRESULT_PROJECT_TESTCASE_RUN](state, obj) {
        state.runResultProjectTestCaseRuns = obj || {};
    },
    [types.READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION](state, obj) {
        state.runResultProjectTestCaseRunInstructions = obj || {};
    },
    [types.READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION_LOG](state, obj) {
        state.runResultProjectTestCaseRunInstructionLog = obj || {};
    },
    [types.READ_RUN_LIST_RESULT](state, obj) {
        state.runListResult = obj || {};
    },
    [types.READ_RUN_CASE_RESULT](state, obj) {
        state.runCaseResult = obj || {};
    },
    [types.READ_TESTCASE_RESULT](state, obj) {
        state.testCaseResult = obj || {};
    }
};

const actions = {
    readRunResultProjects({ commit }, obj) {
        api.getRunResultProjects(obj).then((res) => {
            commit('READ_RUNRESULT_PROJECTS', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRunResultProjectCharts({ commit }, obj) {
        api.getRunResultProjectCharts(obj).then((res) => {
            commit('READ_RUNRESULT_PROJECT_CHARTS', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRunResultProjectTestCases({ commit }, obj) {
        api.getTestCaseExecutionInfoByProjectId(obj).then((res) => {
            commit('READ_RUNRESULT_PROJECT_TESTCASES', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRunResultProjectTestCaseRuns({ commit }, obj) {
        api.getRunResultProjectTestCaseRuns(obj).then((res) => {
            commit('READ_RUNRESULT_PROJECT_TESTCASE_RUN', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRunResultProjectTestCaseInstructions({ commit }, obj) {
        api.getRunResultProjectTestCaseInstructions(obj).then((res) => {
            commit('READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRunResultProjectTestCaseInstructionLogs({ commit }, obj) {
        api.getRunResultProjectTestCaseInstructionLogs(obj).then((res) => {
            commit('READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION_LOG', res);
        }, (err) => {
            console.log(err);
        })
    },
    readRunListResults({ commit }, obj) {
        api.getRunListResult(obj).then((res) => {
            commit('READ_RUN_LIST_RESULT', res);
        }, (err) => {
            console.log(err);
        })
    },
    readListReportDetails({ commit }, obj) {
        return api.readListReportDetails(obj);
    },
    readRunCaseResults({ commit }, obj) {
        api.getRunCaseResult(obj).then((res) => {
            commit('READ_RUN_CASE_RESULT', res);
        }, (err) => {
            console.log(err);
        })
    },
    readTestCaseResults({ commit }, obj) {
        api.getTestCaseResult(obj).then((res) => {
            commit('READ_TESTCASE_RESULT', res);
        }, (err) => {
            console.log(err);
        })
    },
    readProjectResultForMessage({ state }, obj) {
        return api.projectResultForMessage(obj);
    },
    readTestCaseResultForMessage({ state }, obj) {
        return api.testCaseResultForMessage(obj);
    },
    readRunResultForMessage({ state }, obj) {
        return api.runResultForMessage(obj);
    },
    readRunListResultForMessage({ state }, obj) {
        return api.runListResultForMessage(obj);
    },
    rollBackRunList({ state }, obj) {
        return api.rollBackRunList(obj);
    },
    terminateRunListRun({ state }, obj) {
        return api.terminateRunListRun(obj);
    },
    terminateTestCaseRun({ state }, obj) {
        return api.terminateTestCaseRun(obj);
    },
    ViewTaskByRunId({ state }, runId) {
        return api.ViewTaskByRunId(runId);
    },
};

export default {
    state,
    getters,
    mutations,
    actions
}