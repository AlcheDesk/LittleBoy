import { apiGet, apiPost, apiDelete, apiPut, apiPatch } from '../../index'

function nameTranslate(param) {
  if (param.hasOwnProperty('name')) {
    param.name = '%' + param.name + '%';
  }
  if (param.hasOwnProperty('comment')) {
    param.comment = '%' + param.comment + '%';
  }
  return param;
}

//RunContainer
export function readRunContainer(param) {
  param = nameTranslate(param);
  return apiGet('/api/runSets/?ref', param);
}

export function readRefRunContainer(param) {
  return apiGet('/api/runSets/?refRunSet', param);
}

export function readCountRefRunContainer(param) {
  return apiGet('/api/count/runSets/?haveRefRunSet', param);
}

export function addRunContainer(param) {
  return apiPost('/api/runSets/', param);
}

export function updateRunContainer(param) {
  return apiPatch('/api/runSets/', param);
}

export function removeRunContainer(param) {
  return apiDelete('/api/runSets/' + param.id + '/');
}

export function validateRunContainerName(param) {
  return apiGet('/api/count/runSets/?all', param);
}



//TestCaseContainer
export function readTestCaseContainer(param) {
  param.data = nameTranslate(param.data);
  return apiGet('/api/runSets/' + param.runSetId + '/runSetTestCaseLinks/?ref', param.data)
  // return apiGet('/api/runSets/' + param.runSetId + '/testCases/?ref', param.data);
}

export function addTestCaseContainer(param) {
  // return apiPut('/api/runSets/' + param.runSetId + '/testCases/', param.data);
  return apiPut('/api/runSetTestCaseLinks/', param)
}

export function countTestCaseContainerOverwriteOrDriverPack(param) {
  return apiGet('/api/count/runSetTestCaseLinks/', param);
}

export function removeTestCaseContainer(param) {
  return apiDelete('/api/runSetTestCaseLinks/' + param.id + '/');
}


export function runRunSetTestCases(param) {
  return apiPost('/api/execute/runSets/' + param.runSetId + '/', param.data, param.param);
}


//read runsetting message
export function readRunSettingForMessage(param) {
  return apiGet('/api/runSets/' + param.id + '/');
}

//testCaseOverwrite set
// export function testCaseSetTestCaseParam(param) {
//   // return apiPatch('/api/runSets/' + param.runSetId + '/testCases/' + param.testCaseId + '/', param.data);
//   return apiPut('/api/runSetTestCaseLinks/', param);
// }


//runListAlias
export function readRunListAlias(param) {
  return apiGet('/api/aliases/?pageSize=all&orderBy=createdAt+desc');
}

export function addRunListAlias(param) {
  return apiPost('/api/aliases/', param);
}

export function updateRunListAlias(param) {
  return apiPatch('/api/aliases/', param);
}

export function removeRunListAlias(param) {
  return apiDelete('/api/aliases/' + param.id + '/');
}

export function getRunListLinkAlias(param) {
  return apiGet('/api/runSets/' + param.runSetId + '/aliases/?pageSize=all&orderBy=createdAt+desc');
}

export function setRunListLinkAlias(param) {
  return apiPut('/api/runSets/' + param.runSetId + '/aliases/', param.data);
}

export function removeRunListLinkAlias(param) {
  return apiDelete('/api/runSets/' + param.runSetId + '/aliases/', param.data);
}

export function countRemoveAliasForRunList(param) {
  return apiGet('/api/count/aliases/?relation', param);
}


//notification
export function readRunSetNotification(param) {
  return apiGet('/api/runSets/' + param.runSetId + '/notifications/?ref&pageSize=all&orderBy=createdAt+desc');
}

export function addRunSetNotification(param) {
  return apiPut('/api/runSets/' + param.runSetId + '/notifications/', param.data);
}

export function deleteRunSetNotification(param) {
  return apiDelete('/api/runSets/' + param.runSetId + '/notifications/', param.id);
}

export function readNotification() {
  return apiGet('/api/notifications/?ref&pageSize=all&orderBy=createdAt+desc');
}

export function addNotification(param) {
  return apiPost('/api/notifications/', param);
}

export function updateNotification(param) {
  return apiPatch('/api/notifications/', param);
}

export function deleteNotification(param) {
  return apiDelete('/api/notifications/' + param.id + '/');
}


export function readRecipient() {
  return apiGet('/api/emailNotificationTargets/?pageSize=all&orderBy=createdAt+desc');
}

export function addRecipient(param) {
  return apiPost('/api/emailNotificationTargets/', param);
}

export function updateRecipient(param) {
  return apiPatch('/api/emailNotificationTargets/', param);
}

export function deleteRecipient(param) {
  return apiDelete('/api/emailNotificationTargets/' + param.id + '/');
}

export function countEmailsAddress(param) {
  return apiGet ('/api/count/emailNotificationTargets/', param);
}

//runSet alarm set

export function readRunSetAlarmSet(param) {
  return apiGet('/api/scheduler/runSets/' + param.id + '/triggers/');
}

export function addOrUpdateRunSetAlarmSet(param) {
  return apiPut('/api/scheduler/runSets/' + param.id + '/triggers/', param.data);
}

export function deleteRunSetAlarmSet(param) {
  return apiDelete('/api/scheduler/runSets/' + param.id + '/triggers/' + param.uuid);
}
