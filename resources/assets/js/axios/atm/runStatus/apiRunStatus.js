import { apiGet } from '../../index'

function nameTranslate(obj) {
  if (obj.hasOwnProperty('name')) {
    obj.name = '%' + obj.name + '%';
  }
  if (obj.hasOwnProperty('comment')) {
    obj.comment = '%' + obj.comment + '%';
  }
  return obj;
}

//project status
export function getProjectStatus(obj) {
  obj = nameTranslate(obj);
  return apiGet('/api/statusReports/projects/', obj);
}

export function getProjectTestCaseStatus(obj) {
  obj.data = nameTranslate(obj.data);
  return apiGet('/api/statusReports/projects/' + obj.projectId + '/testCases/', obj.data);
}

export function readProjectStatusForMessage(obj) {
  return apiGet('/api/statusReports/projects/' + obj.id + '/');
}


export function getRunListStatus(obj) {
  obj = nameTranslate(obj);
  return apiGet('/api/statusReports/runSets/', obj);
}

export function getRunCaseStatus(obj) {
  obj.data = nameTranslate(obj.data);
  return apiGet('/api/statusReports/runSets/' + obj.runsetId + '/testCases/', obj.data);
}

export function getRunListStatusForMessage(obj) {
  return apiGet('/api/statusReports/runSets/' + obj.id + '/');
}

export function getTestCaseStatus(obj) {
  obj = nameTranslate(obj);
  return apiGet('/api/statusReports/testCases/', obj);
}

