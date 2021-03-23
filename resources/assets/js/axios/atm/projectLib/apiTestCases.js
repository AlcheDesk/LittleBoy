import { apiGet } from '../../index'

function nameTranslate(obj) {
  if (obj.hasOwnProperty('name')) {
    obj.name = '%' + obj.name + '%';
  }
  if (obj.hasOwnProperty('comment')) {
    obj.comment = '%' + obj.comment + '%';
  }
  if (obj.hasOwnProperty('target')) {
    obj.target = '%' + obj.target + '%';
  }
  return obj;
}


//read all testCases
export function readTestCases(obj) {
  obj = nameTranslate(obj);
  return apiGet('/api/testCases/?ref', obj)
}


export function readProjectForTestCase(obj) {
  return apiGet('/api/testCases/' + obj.id + '/projects/');
}

