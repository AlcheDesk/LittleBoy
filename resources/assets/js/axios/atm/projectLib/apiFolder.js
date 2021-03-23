import { apiGet, apiPost, apiDelete, apiPut, apiPatch } from '../../index'

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
//读收藏夹
export function readFolders(param) {
  param = nameTranslate(param);
  return apiGet('/api/testCaseShareFolders/', param);
}

//添加收藏夹
export function addFolder(param) {
  return apiPost('/api/testCaseShareFolders/', param);
}

//更新收藏夹
export function updateFolder(param) {
  return apiPatch('/api/testCaseShareFolders/', param);
}

//删除收藏夹
export function deleteFolder(param) {
  return apiDelete('/api/testCaseShareFolders/' + param.id + '/');
}

export function validateFolderName(param) {
  return apiGet('/api/count/testCaseShareFolders/?all', param);
}


//read folder for message
export function readFolderForMessage(param) {
  return apiGet('/api/testCaseShareFolders/' + param.id + '/');
}

//读取收藏夹下的测试用例
export function readFolderTestCases(param) {
  param.data = nameTranslate(param.data);
  return apiGet('/api/testCaseShareFolders/' + param.folderId + '/testCaseShareFolderTestCaseLinks/?ref', param.data);
}

//添加收藏夹下的测试用例
export function addFolderTestCase(param) {
  return apiPut('/api/testCaseShareFolderTestCaseLinks/', param);
}

//删除收藏夹下的测试用例
export function deleteFolderTestCase(param) {
  return apiDelete('/api/testCaseShareFolderTestCaseLinks/' + param.id + '/');
}




