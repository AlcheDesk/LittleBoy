import { apiGet, apiPost, apiPatch, apiDelete, apiPut } from '../../index'

function nameTranslate(param) {
  if (param.hasOwnProperty('name')) {
    param.name = '%' + param.name + '%';
  }
  if (param.hasOwnProperty('comment')) {
    param.comment = '%' + param.comment + '%';
  }
  if (param.hasOwnProperty('target')) {
    param.target = '%' + param.target + '%';
  }
  return param;
}

export function readProjectApiElements(param) {
  param.data = nameTranslate(param.data);
  return apiGet('/api/projects/' + param.id + '/elements/', param.data);
}

export function addProjectApiElement(param) {
  return apiPost('/api/projects/' + param.id + '/elements/', param.data)
}
export function addProjectApiElementInInstruction(param) {
  return apiPut('/api/projects/' + param.id + '/elements/', param.data);
}

export function updateProjectApiElement(param) {
  return apiPatch('/api/elements/', param);
}

export function deleteProjectApiElement(param) {
  return apiDelete('/api/projects/' + param.id + '/elements/', param.data.id)
}

export function readSchemas() {
  return apiGet('/api/apiSchemas/');
}

export function putSchema(param) {
  return apiPut('/api/apiSchemas/', param);
}


//validate apiElement Name
export function validateApiElementName(param) {
  return apiGet('/api/count/elements/', param);
}


//preOperation
export function apiUnitCalls(param) {
  return apiPost('/api/apiUnitCalls/', [param]);
}

//httpPreExecution
export function httpPreExecution(param) {
  return apiPost('/api/preExecution/httpPreExecution', param)
}

//webServicePreExecution
export function webServicePreExecution(param) {
  return apiPost('/api/preExecution/webServicePreExecution', param)
}

//RedisPreExecution
export function redisPreExecution(param) {
  return apiPost('/api/preExecution/RedisExecution', param)
}

//validateRedisResult
export function validateRedisResult(param) {
  return apiPost('/api/verify', param);
}


//soap elements
export function readApiTypes() {
  return apiGet('/api/instructionTypes?name=%25API%25')
}


