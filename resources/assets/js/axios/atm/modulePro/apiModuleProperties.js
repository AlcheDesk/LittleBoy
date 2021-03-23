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

//moduleProperties
export function getDriverPacks(param) {
    param = nameTranslate(param);
    return apiGet('/api/driverPacks/', param);
}

export function addDriverPack(param) {
    return apiPost('/api/driverPacks/', param);
}

export function deleteDriverPack(param) {
    return apiDelete('/api/driverPacks/' + param.id + '/');
}

export function validateDriverPacksName(param) {
    return apiGet('/api/count/driverPacks/?all', param);
}


//packsEngines
export function getPacksEngines(param) {
    param.data = nameTranslate(param.data);
    return apiGet('/api/driverPacks/' + param.packId + '/drivers/', param.data);
}

export function addPacksENgines(param) {
    return apiPut('/api/driverPacks/' + param.packId + '/drivers/', param.data);
}

export function deletePacksEngines(param) {
    return apiDelete('/api/driverPacks/' + param.packId + '/drivers/', param.id);
}


//engine
export function getEngines(param) {
    if (param.engineId) {
        return apiGet('/api/drivers/' + param.engineId + '/');
    } else {
        param = nameTranslate(param);
        return apiGet('/api/drivers/', param);
    }
}

export function addEngines(param) {
    if (param.id) {
        return apiPatch('/api/drivers/', [param]);
    } else {
        return apiPost('/api/drivers/', param);
    }
}

export function deleteEngines(param) {
    return apiDelete('/api/drivers/' + param.id + '/');
}



//engineProperties

export function getEngineProperties(param) {
    return apiGet('/api/drivers/' + param.engineId + '/driverProperties/');
}


export function addEngineProperties(param) {
    return apiPost('/api/drivers/' + param.engineId + '/driverProperties/', param.data);
}

export function deleteEngineProperties(param) {
    return apiDelete('/api/drivers/' + param.engineId + '/driverProperties/' + param.id + '/');
}

export function readDriverPropertiesPredefinedValue(param) {
    return apiGet('/api/driverProperties/' + param.id + '/driverPropertyPredefinedValues/')
}

//read message

export function readEngineForMessage(param) {
    return apiGet('/api/drivers/' + param.id + '/');
}



//driver
export function readDriverType() {
    return apiGet('/api/driverTypes/');
}

export function readDriverVendor(param) {
    return apiGet('/api/driverTypes/' + param.id + '/driverVendors/');
}

export function validateDriversName(param) {
    if (param.name) {
        return apiGet('/api/count/drivers/?all', param);
    }
    if (param.driverId) {
        return apiGet('/api/count/drivers/?relation', param);
    }
}


//for run message
export function readTestCaseExecuteDriverMaps(param) {
    // return apiGet('/api/testCases/' + param.testCaseId + '/executionDriverMaps/');
    return apiGet('/api/testCases/' + param.testCaseId + '/driverTypes/');
}

export function readRunSetExecuteDriverMaps(param) {
    // return apiGet('/api/runSets/' + param.runSetId + '/executionDriverMaps/');
    return apiGet('/api/runSets/' + param.runSetId + '/driverTypes/');
}

//for run drivers
export function readTestCaseExecuteDriverPacks(param) {
    return apiGet('/api/testCases/' + param.testCaseId + '/driverPacks?ref=true', param.data);
}



//systemRequiremets

//packs
export function readSystemRequirementPacks(param) {
    return apiGet('/api/systemRequirementPacks/', param);
}

export function addSystemRequirementPack(param) {
    return apiPost('/api/systemRequirementPacks/', param);
}

export function deleteSystemRequirementPack(param) {
    return apiDelete('/api/systemRequirementPacks/' + param.id + '/');
}

export function validateSystemRequirementPack(param) {
    return apiGet('/api/count/systemRequirementPacks/?all', param);
}

//packSystemRequirements
export function readPackSystemRequirements(param) {
    return apiGet('/api/systemRequirementPacks/' + param.packId + '/systemRequirements/', param.data);
}

export function addPackSystemRequirement(param) {
    return apiPut('/api/systemRequirementPacks/' + param.packId + '/systemRequirements/', param.data);
}

export function deletePackSystemRequirement(param) {
    return apiDelete('/api/systemRequirementPacks/' + param.packId + '/systemRequirements/', param.id);
}

//systemRequirements
export function readSystemRequirements(param) {
    return apiGet('/api/systemRequirements/', param);
}