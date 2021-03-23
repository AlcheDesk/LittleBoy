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

export function getProjects(param) {
    param = nameTranslate(param);
    return apiGet('/api/projects/', param);
};

export function addProject(param) {
    return apiPost('/api/projects/', param);
}

export function deleteProject(param) {
    return apiDelete('/api/projects/' + param.id + '/');
}

export function projectCopy(param) {
    return apiPost('/api/copy/projects/', param);
}

export function readProjectTypes() {
    return apiGet('/api/projectTypes/');
}

export function updateProject(param) {
    return apiPatch('/api/projects/', param);
}

//systemSetting
export function readSystemSetting(param) {
    return apiGet('/api/properties/', param);
}

export function updateSystemSetting(param) {
    return apiPatch('/api/properties/', param);
}

//project testcase
export function readProjectTestCases(param) {
    param.data = nameTranslate(param.data);
    return apiGet('/api/projects/' + param.projectId + '/testCases/?ref', param.data);
}

export function readRefProjectTestCases(param) {
    param.data = nameTranslate(param.data);
    return apiGet('/api/projects/' + param.projectId + '/testCases/', param.data);
}

export function addProjectTestCase(param) {
    return apiPost('/api/projects/' + param.projectId + '/testCases/', param.data);
}

export function deleteProjectTestCase(param) {
    return apiDelete('/api/projects/' + param.projectId + '/testCases/', param.id);
}

export function projectTestCaseCopy(param) {
    return apiPost('/api/copy/testCases/', param);
}

export function projectTestCaseMark(param) {
    return apiPatch('/api/testCases/', param);
}

export function addProjectTestCaseFromFolder(param) {
    return apiPut('/api/projects/' + param.projectId + '/testCases/', [], param.id);
}


export function readDeletedTestCases() {
    return apiGet('/api/testCases/');
}

export function addDeletedTestCasesToProject(param) {
    return apiPut('/api/projects/' + param.projectId + '/testCases/', [], param.data)
}


//project testcase instruction
export function readTestCaseInstructions(param) {
    param.data = nameTranslate(param.data);
    return apiGet('/api/testCases/' + param.testCaseId + '/instructions/?ref', param.data);
}

export function addTestCaseInstruction(param) {
    return apiPost('/api/testCases/' + param.testCaseId + '/instructions/', param.data);
}

export function deleteTestCaseInstruction(param) {
    return apiDelete('/api/instructions/', param);
}

export function copyTestCaseInstruction(param) {
    return apiPost('/api/copy/testCases/' + param.testCaseId + '/instructions/', param.data);
}

export function updateTestCaseInstruction(param) {
    return apiPatch('/api/instructions/', param);
}

export function readInstructionOptionTypes(param) {
    // return apiGet('/api/instructionActions/' + param.id + '/instructionOptions/');
    return apiGet('/api/instructionOptions', param);
}

export function addInstructionOptionType(param) {
    return apiPost('/api/instructions/' + param.instructionId + '/instructionOptions/', param.data);
}

export function updateInstructionOptionType(param) {
    return apiPatch('/api/instructions/' + param.instructionId + '/instructionOptions/', param.data);
}

export function deleteInstructionOptionType(param) {
    return apiDelete('/api/instructions/' + param.instructionId + '/instructionOptions/', param.data);
}

//read JS/SQL instruction action 
export function readInstructionOptions(param) {
    return apiGet('/api/instructionOptions/', param);
}

//read file type and path
export function readFileTypes() {
    return apiGet('/api/contentTypes/');
}

export function readFilePath(param) {
    return apiGet('/api/userContents/', param);
}

//move need TODO

//add step selection application/section/element/action read
//application--section--element 已经有了
//action

export function readInstructionActions(param) {
    return apiGet('/api/elements/' + param.elementId + '/instructionActions/', param.data);
}

export function readWebBrowserInstructionAction(param) {
    return apiGet('/api/elementTypes/' + param.id + '/instructionActions/');
}

export function readRedisInstructionAction(param) {
    return apiGet('/api/elementTypes/' + param.id + '/instructionActions/');
}

export function readStringUtilInstructionAction(param) {
    return apiGet('/api/instructionTypes/' + param.id + '/instructionActions/');
}

//application

export function readProjectApplications(param) {
    param.data = nameTranslate(param.data);
    if (param.projectId) {
        return apiGet('/api/projects/' + param.projectId + '/applications/', param.data);
    } else {
        return apiGet('/api/applications/', param.data)
    }
}

export function addProjectApplication(param) {
    return apiPost('/api/projects/' + param.projectId + '/applications/', param.data);
}

export function deleteProjectApplication(param) {
    return apiDelete('/api/projects/' + param.projectId + '/applications/', param.id);
}

export function updateProjectApplication(param) {
    return apiPatch('/api/applications/', param)
}

//section

export function readApplicationSections(param) {
    param.data = nameTranslate(param.data);
    return apiGet('/api/applications/' + param.applicationId + '/sections/', param.data);
}

export function addApplicationSection(param) {
    return apiPost('/api/applications/' + param.applicationId + '/sections/', param.data);
}

export function deleteApplicationSection(param) {
    return apiDelete('/api/sections/' + param.id + '/');
}

export function updateApplicationSection(param) {
    return apiPatch('/api/sections/', param);
}

//element

export function readSectionElements(param) {
    param.data = nameTranslate(param.data);
    return apiGet('/api/sections/' + param.sectionId + '/elements/', param.data);
}

export function addSectionElement(param) {
    return apiPost('/api/sections/' + param.sectionId + '/elements/', param.data);
}

export function updateSectionElement(param) {
    return apiPatch('/api/elements/', param)
}

export function deleteSectionElement(param) {
    return apiDelete('/api/sections/' + param.sectionId + '/elements/', param.id);
}

export function readElementTypes() {
    return apiGet('/api/elementTypes/?isDriver=false');
}

export function readElementLocatorTypes(param) {
    return apiGet('/api/elementTypes/' + param.id + '/elementLocatorTypes/');
}

export function readElementRelevance(param) {
    return apiGet('/api/count/elements?relation', param);
}


//storages
export function readStorages() {
    return apiGet('/api/storages/');
}
//add
export function addStorage(param) {
    return apiPost('/api/storages/', param);
}
//delete
export function deleteStorage(param) {
    return apiDelete('/api/storages/' + param.id + '/');
}

export function readTestCaseStorage(param) {
    return apiGet('/api/testCases/' + param.testCaseId + '/storages/');
}

export function linkTestCaseStorage(param) {
    return apiPost('/api/testCases/' + param.testCaseId + '/storages/', param.data);
}

export function deleteTestCaseStorage(param) {
    return apiDelete('/api/testCases/' + param.testCaseId + '/storages/', param.data);
}

//testCaseEngine
export function readTestCaseEngines(param) {
    return apiGet('/api/testCases/' + param.testCaseId + '/drivers/');
}

export function linkTestCaseEngine(param) {
    return apiPost('/api/testCases/' + param.testCaseId + '/drivers/', param.data);
}

export function deleteTestCaseEngine(param) {
    return apiDelete('/api/testCases/' + param.testCaseId + '/drivers/', param.data);
}

//systemRequirements
export function readEnvironments() {
    return apiGet('/api/systemRequirements/');
}

export function readTestCaseEnvironments(param) {
    return apiGet('/api/testCases/' + param.testCaseId + '/systemRequirements/');
}

export function linkTestCaseEnvironment(param) {
    return apiPost('/api/testCases/' + param.testCaseId + '/systemRequirements/', param.data);
}

export function deleteTestCaseEnvironment(param) {
    return apiDelete('/api/testCases/' + param.testCaseId + '/systemRequirements/', param.data);
}


//runTestCase
export function runTestCases(param) {
    return apiPost('/api/execute/testCases/' + param.testCaseId + '/', param.data, param.param);
}
export function readGroups(param) {
    return apiGet('/api/groups/', param);
}

//nameValidate
export function validateProjectName(param) {
    return apiGet('/api/count/projects/?all', param);
}

export function validateTestCaseName(param) {
    return apiGet('/api/count/testCases/?all', param)
}

export function validateApplicationName(param) {
    return apiGet('/api/count/applications/?all', param);
}

export function validateSectionName(param) {
    return apiGet('/api/count/sections/?all', param);
}

export function validateElementName(param) {
    return apiGet('/api/count/elements/?all', param);
}


//read something for message

export function readProjectForMessage(param) {
    return apiGet('/api/projects/' + param.id + '/');
}

export function readTestCaseForMessage(param) {
    return apiGet('/api/testCases/' + param.id + '/?ref');
}

export function readApplicationForMessage(param) {
    return apiGet('/api/applications/' + param.id + '/');
}

export function readSectionForMessage(param) {
    return apiGet('/api/sections/' + param.id + '/');
}


//file download
export function readFileDownLoadMessage() {
    return apiGet('/api/properties/');
}


//overwrite instruction
export function readTestCaseOverWriterInstructions(param) {
    return apiGet('/api/testCaseOverwrites/' + param.id + '/instructionOverwrites/?ref', param.data)
}

export function addInstructionOverWrite(param) {
    return apiPut('/api/instructionOverwrites/', param);
}

export function deleteInstructionOverwrite(param) {
    return apiDelete('/api/instructionOverwrites/' + param.id + '/');
}


//testcase
export function readTestCaseOverwrites(param) {
    param.data = nameTranslate(param.data);
    if (param.type) {
        return apiGet('/api/testCases/' + param.testCaseId + '/testCaseOverwrites/?ref', param.data);
    } else {
        return apiGet('/api/testCases/' + param.testCaseId + '/testCaseOverwrites/', param.data);
    }
}

export function addTestCaseOverwrite(param) {
    return apiPost('/api/testCases/' + param.testCaseId + '/testCaseOverwrites/', param.data);
}

export function deleteTestCaseOverwrite(param) {
    return apiDelete('/api/testCaseOverwrites/' + param.id + '/');
}

export function copyTestCaseOverwrite(param) {
    return apiPost('/api/copy/testCaseOverwrites/', param);
}

export function validateTestCaseOverWrites(param) {
    return apiGet('/api/count/testCaseOverwrites/?all', param);
}

//refrence testCase test
export function validateTestCaseRefrence(param) {
    return apiGet('/api/count/testCaseReference', param);
}

//tags for testCases
export function readTags(param) {
    return apiGet('/api/tags/?pageSize=all&orderBy=createdAt+desc', param);
}

export function addTags(param) {
    return apiPost('/api/tags/', param);
}

export function updateTags(param) {
    return apiPatch('/api/tags/', param);
}

export function removeTags(param) {
    return apiDelete('/api/tags/' + param.id + '/');
}

export function addTagsForTestCase(param) {
    return apiPost('/api/testCases/' + param.id + '/tags/', param.data);
}

export function editTagsForTestCase(param) {
    return apiPut('/api/testCases/' + param.id + '/tags/', param.data);
}

export function deleteTagsForTestCase(param) {
    return apiDelete('/api/testCases/' + param.id + '/tags/', param.tagId);
}


//edit instruction will change testCaseOverwrite notification
export function countTestCaseOverwriterInstruction(param) {
    return apiGet('/api/count/instructionOverwrites/', param);
}

export function countTestCaseOverwriterElement(param) {
    return apiGet('/api/count/instructionOverwrites/', param);
}

export function countRemoveTagsForTestCase(param) {
    return apiGet('/api/count/tags/?relation', param);
}

//testcase types
export function readTestCaseTypes(param) {
    return apiGet('/api/testCaseTypes/');
}

export function validateTestCaseDelete(id) {
    return apiGet('/api/count/testCases/' + id + '/testCases/');
}