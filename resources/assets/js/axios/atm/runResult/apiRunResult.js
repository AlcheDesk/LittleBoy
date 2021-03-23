import { apiGet, apiPost, apiDelete } from '../../index'

function nameTranslate(obj) {
    if (obj.hasOwnProperty('name')) {
        obj.name = '%' + obj.name + '%';
    }
    if (obj.hasOwnProperty('target')) {
        obj.target = '%' + obj.target + '%';
    }
    if (obj.hasOwnProperty('comment')) {
        obj.comment = '%' + obj.comment + '%';
    }
    return obj;
}

export function getRunResultProjects(param) {
    param = nameTranslate(param);
    // return apiGet('/api/resultReports/projects/', param);
    return apiGet('/api/projectExecutionInfo/', param);
}

export function getRunResultProjectCharts(param) {
    return apiGet('/api/projectReportInfo/' + param.projectId + '/?ref');
}

export function getTestCaseExecutionInfoByProjectId(param) {
    param.data = nameTranslate(param.data);
    // return apiGet('/api/resultReports/projects/' + param.projectId + '/testCases/', param.data);
    // return apiGet('/api/resultReports/projects/' + param.projectId + '/testCaseExecutionInfo/', param.data);
	return apiGet('/api/projectExecutionInfo/' + param.projectId + '/testCaseExecutionInfo/', param.data);
}

//change 2019/11/6
export function getRunResultProjectTestCaseRuns(param) {
    param.data = nameTranslate(param.data);
    // return apiGet('/api/resultReports/testCases/' + param.testCaseId + '/runs/?ref', param.data);
    return apiGet('/api/testCases/' + param.testCaseId + '/runExecutionInfo/?ref', param.data);
}

export function getRunResultProjectTestCaseInstructions(param) {
    param.data = nameTranslate(param.data);
    return apiGet('/api/runs/' + param.runId + '/instructionResults/', param.data);
}

export function getRunResultProjectTestCaseInstructionLogs(param) {
    return apiGet('/api/instructionResults/' + param.id + '/stepLogs/', param.data);
}

//Run List Result
export function getRunListResult(obj) {
    obj = nameTranslate(obj);
    return apiGet('/api/runSetResults/', obj);
}

//change 2019/11/6
export function getRunCaseResult(obj) {
    // obj.data = nameTranslate(obj.data);
    // return apiGet('/api/resultReports/runSetResults/' + obj.runSetId + '/runs/?ref', obj.data);
    return apiGet('/api/runSetResults/' + obj.runSetId + '/runExecutionInfo/?ref', obj.data);
}

export function readListReportDetails(obj) {
    return apiGet('/api/runSetResults/' + obj.runSetId + '/?full');
}


//TestCase Result list
export function getTestCaseResult(obj) {
    obj = nameTranslate(obj);
    // return apiGet('/api/resultReports/testCases/', obj);
    return apiGet('/api/testCaseExecutionInfo/', obj);
}



//read message
export function projectResultForMessage(obj) {
    // return apiGet('/api/resultReports/projects/' + obj.id + '/');
    return apiGet('/api/projectExecutionInfo/' + obj.id + '/');
}

export function testCaseResultForMessage(obj) {
    // return apiGet('/api/resultReports/testCases/' + obj.id + '/');
    return apiGet('/api/testCaseExecutionInfo/' + obj.id + '/');
}

export function runResultForMessage(obj) {
    // return apiGet('/api/resultReports/runs/' + obj.id + '/');
    return apiGet('/api/runExecutionInfo/' + obj.id + '/');
}


export function runListResultForMessage(obj) {
    return apiGet('/api/runSetResults/' + obj.id + '/');
}


//testcase run again
export function rollBackRunList(param) {
    return apiPost('/api/execute/runSetResults/' + param.id + '/', []);
}

export function rollBackProject(param) {
    return apiPost('/api/execute/projectResults/' + param.id + '/', []);
}

//terminates
export function terminateRunListRun(param) {
    return apiDelete('/api/utils/termination/runSetResults/' + param.id + '/');
}

export function terminateTestCaseRun(param) {
    return apiDelete('/api/utils/termination/runs/' + param.runId + '/');
}

export function ViewTaskByRunId(runId) {
    return apiGet('/api/runs/' + runId + '/tasks');
}
