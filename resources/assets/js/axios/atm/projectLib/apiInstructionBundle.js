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

//InstructionBundle
export function readInstructionBundle(param) {
  param = nameTranslate(param);
  return apiGet('/api/instructionBundles/', param);
}

export function addInstructionBundle(param) {
  return apiPost('/api/instructionBundles/', param);
}

export function updateInstructionBundle(param) {
  return apiPatch('/api/instructionBundles/', param);
}

export function removeInstructionBundle(param) {
  return apiDelete('/api/instructionBundles/' + param.id + '/');
}

export function validateInstructionBundleName(param) {
  return apiGet('/api/count/instructionBundles/?all', param);
}



//InstructionInstructionBundle
export function readInstructionBundleEntry(param) {
  param.data = nameTranslate(param.data);
  return apiGet('/api/instructionBundles/' + param.id + '/instructionBundleEntries/?ref', param.data)
}

export function addInstructionBundleEntry(param) {
  return apiPost('/api/instructionBundles/' + param.id + '/instructionBundleEntries/', param.data)
}

export function editInstructionBundleEntry(param) {
  return apiPatch('/api/instructionBundleEntries/', param);
}

export function removeInstructionBundleEntry(param) {
  return apiDelete('/api/instructionBundleEntries/' + param.id + '/');
}


//read runsetting message
export function readInstructionBundleForMessage(param) {
  return apiGet('/api/instructionBundles/' + param.id + '/');
}

//instructionTypes and instructionType => elementType
export function readInstructionTypes(param) {
  return apiGet('/api/instructionTypes/', param);
}

export function readElementTypesForInstructionType(param) {
  return apiGet('/api/instructionTypes/' + param.id + '/elementTypes/', param.data);
};