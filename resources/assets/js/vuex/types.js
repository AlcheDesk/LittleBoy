//RBAC

/**-------------------------------------------------Permissions----------------------------------------------------**/
export const READ_PERMISSIONS = 'READ_PERMISSIONS';

/**-------------------------------------------------Roles----------------------------------------------------**/
export const READ_ROLES = 'READ_ROLES';

export const READ_GROUP_PERMISSIONS = 'READ_GROUP_PERMISSIONS';

export const READ_GROUP_USERS = 'READ_GROUP_USERS';

/**-------------------------------------------------Users----------------------------------------------------**/
export const READ_USERS = 'READ_USERS';
export const READ_USER_LOGS = 'READ_USER_LOGS';

//TODO
//Mutations type totals


/**-------------------------------------------------ProjectLib----------------------------------------------------**/

//project
export const READ_PROJECT = 'READ_PROJECT';
export const READ_PROJECT_TYPE = 'READ_PROJECT_TYPE';

//systemSetting
export const READ_SYSTEM_SETTING = 'READ_SYSTEM_SETTING';
export const UPDATE_SYSTEM_SETTING = 'UPDATE_SYSTEM_SETTING'

//project_testcase
export const READ_PROJECT_TESTCASE = 'READ_PROJECT_TESTCASE';
export const READ_REF_PROJECT_TESTCASE = 'READ_REF_PROJECT_TESTCASE';
export const READ_FOLDER = 'READ_FOLDER';
export const READ_FOLDER_TESTCASE = 'READ_FOLDER_TESTCASE';

export const READ_GROUPS = 'READ_GROUPS';

export const READ_DELETED_TESTCASE = 'READ_DELETED_TESTCASE';

//application
export const READ_PROJECT_APPLICATIONS = 'READ_PROJECT_APPLICATIONS';

//section
export const READ_APPLICATION_SECTIONS = 'READ_APPLICATION_SECTIONS';

//element
export const READ_SECTION_ELEMENTS = 'READ_SECTION_ELEMENTS';
export const READ_SECTION_LINES = 'READ_SECTION_LINES';

//api Element
export const READ_PROJECT_API_ELEMENT = 'READ_PROJECT_API_ELEMENT';
export const READ_API_TYPES = 'READ_API_TYPES';

//element type
export const READ_ELEMENT_TYPES = 'READ_ELEMENT_TYPES';
export const READ_ELEMENT_LOCATOR_TYPES = 'READ_ELEMENT_LOCATOR_TYPES';
export const READ_INSTRUCTION_ACTIONS = 'READ_INSTRUCTION_ACTIONS';
export const READ_WEBBROWSER_INSTRUCTION_ACTIONS = 'READ_WEBBROWSER_INSTRUCTION_ACTIONS';
export const READ_REDIS_INSTRUCTION_ACTIONS = 'READ_REDIS_INSTRUCTION_ACTIONS';
export const READ_STRINGUTIL_INSTRUCTION_ACTIONS = 'READ_STRINGUTIL_INSTRUCTION_ACTIONS';

//storage
export const READ_STORAGES = 'READ_STORAGES';
export const READ_TESTCASE_STORAGES = 'READ_TESTCASE_STORAGES';
//engine
export const READ_TESTCASE_ENGINES = 'READ_TESTCASE_ENGINES';
//environments
export const READ_ENVIRONMENTS = 'READ_ENVIRONMENTS';
export const READ_TESTCASE_ENVIRONMENTS = 'READ_TESTCASE_ENVIRONMENTS';

//instructions
export const READ_TESTCASE_INSTRUCTIONS = 'READ_TESTCASE_INSTRUCTIONS';
export const READ_INSTRUCTION_OPTION_TYPES = 'READ_INSTRUCTION_OPTION_TYPES';

//file type and path
export const READ_FILE_TYPES = 'READ_FILE_TYPES';
export const READ_FILE_PATH = 'READ_FILE_PATH';

/**-------------------------------------------------Folder----------------------------------------------------**/


//folder
export const READ_FOLDERS = 'READ_FOLDERS';
export const READ_FOLDER_TESTCASES = 'READ_FOLDER_TESTCASES';

/**-------------------------------------------------runSet-------------------------------------------------------**/
export const READ_RUN_CONTAINER = 'READ_RUN_CONTAINER';
export const READ_TESTCASE_CONTAINER = 'READ_TESTCASE_CONTAINER';
export const READ_REF_RUN_CONTAINER = 'READ_REF_RUN_CONTAINER';
export const READ_RUN_LIST_ALIAS = 'READ_RUN_LIST_ALIAS';
export const READ_RUN_SET_NOTIFICATION = 'READ_RUN_SET_NOTIFICATION';
export const READ_NOTIFICATION = 'READ_NOTIFICATION';
export const READ_RECIPIENT = 'READ_RECIPIENT';


/**-------------------------------------------------InstructionBundle-------------------------------------------------------**/
export const READ_INSTRUCTION_BUNDLE = 'READ_INSTRUCTION_BUNDLE';
export const READ_INSTRUCTION_BUNDLE_ENTRY = 'READ_INSTRUCTION_BUNDLE_ENTRY';
export const READ_INSTRUCTION_TYPE = 'READ_INSTRUCTION_TYPE';
export const READ_ELEMENT_TYPES_FOR_INSTRUCTION_TYPE = 'READ_ELEMENT_TYPES_FOR_INSTRUCTION_TYPE';



/**-------------------------------------------------modulePro----------------------------------------------------**/
//driverPacks
export const READ_DRIVER_PACK = 'READ_DRIVER_PACK';

//packsEngines
export const READ_PACKS_ENGINES = 'READ_PACKS_ENGINES';

//engines
export const READ_ENGINES = 'READ_ENGINES';

//engineProperties
export const READ_ENGINE_PROPERTIES = 'READ_ENGINE_PROPERTIES';

//driverType
export const READ_DRIVER_TYPE = 'READ_DRIVER_TYPE';

//driverVendor
export const READ_DRIVER_VENDOR = 'READ_DRIVER_VENDOR';

//driverType drivers
export const READ_DRIVER_TYPE_DRIVER = 'READ_DRIVER_TYPE_DRIVER';

//driverPropertyPredefinedValues
export const READ_DRIVER_PROPERTY_PREDEFINED_VALUE = 'READ_DRIVER_PROPERTY_PREDEFINED_VALUE';

//testCase driver packs
export const READ_TESTCASE_DRIVER_PACK = 'READ_TESTCASE_DRIVER_PACK';

//runset driver packs
export const READ_RUNSET_DRIVER_PACK = 'READ_RUNSET_DRIVER_PACK';

//SYSTEMrEQUIREMENTS
export const READ_SYSTEM_REQUIREMENT_PACKS = 'READ_SYSTEM_REQUIREMENT_PACKS';
export const READ_PACK_SYSTEM_REQUIREMENTS = 'READ_PACK_SYSTEM_REQUIREMENTS';
export const READ_SYSTEM_REQUIREMENTS = 'READ_SYSTEM_REQUIREMENTS';

/**-------------------------------------------------runStatus----------------------------------------------------**/
//project status
export const READ_PROJECT_RUNSTATUS = 'READ_PROJECT_RUNSTATUS';

//project testcase status
export const READ_PROJECT_TESTCASE_RUNSTATUS = 'READ_PROJECT_TESTCASE_RUNSTATUS';

//runListStatus
export const READ_RUN_LIST_STATUS = 'READ_RUN_LIST_STATUS';
//runCaseStatus
export const READ_RUN_CASE_STATUS = 'READ_RUN_CASE_STATUS';
//TestCaseStatus
export const READ_TESTCASE_STATUS = 'READ_TESTCASE_STATUS';


/**-------------------------------------------------runResult----------------------------------------------------**/
//projects
export const READ_RUNRESULT_PROJECTS = 'READ_RUNRESULT_PROJECTS';

//projectCharts
export const READ_RUNRESULT_PROJECT_CHARTS = 'READ_RUNRESULT_PROJECT_CHARTS';

//projectTestCase
export const READ_RUNRESULT_PROJECT_TESTCASES = 'READ_RUNRESULT_PROJECT_TESTCASES';

//projectTestCaseRun
export const READ_RUNRESULT_PROJECT_TESTCASE_RUN = 'READ_RUNRESULT_PROJECT_TESTCASE_RUN';

//projectTestCaseRunInstruction
export const READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION = 'READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION';

//projectTestCaseRunInstructionLog
export const READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION_LOG = 'READ_RUNRESULT_PROJECT_TESTCASE_RUN_INSTRUCTION_LOG';

//runList Result
export const READ_RUN_LIST_RESULT = 'READ_RUN_LIST_RESULT';
//runCaseResult
export const READ_RUN_CASE_RESULT = 'READ_RUN_CASE_RESULT';
//testCaseResult
export const READ_TESTCASE_RESULT = 'READ_TESTCASE_RESULT';


/**-------------------------------------------------testCases----------------------------------------------------**/
export const READ_TESTCASES = 'READ_TESTCASES'

//schema
export const READ_SCHEMA = 'READ_SCHEMA';


//instruction overwrite
export const READ_TESTCASE_OVERWRITE_INSTRUCTIONS = 'READ_TESTCASE_OVERWRITE_INSTRUCTIONS';

export const READ_TESTCASE_OVERWRITE = 'READ_TESTCASE_OVERWRITE';

export const READ_REFRENCE_TESTCASE_OVERWRITE = 'READ_REFRENCE_TESTCASE_OVERWRITE';


//tags for testCases
export const READ_TAGS_FOR_TESTCASE = 'READ_TAGS_FOR_TESTCASE';

//types for testCases
export const READ_TYPES_FOR_TESTCASE = 'READ_TYPES_FOR_TESTCASE';

//USER
export const READ_USER_MESSGE = 'READ_USER_MESSGE';
export const READ_USER_MANAGEMENT = 'READ_USER_MANAGEMENT';



/**-------------------------------------------------EMS----------------------------------------------------**/
export const SET_CONTROL_CENTER = 'SET_CONTROL_CENTER'

export const SET_WORKERS = 'SET_WORKERS'
export const SET_WORK_COUNT = 'SET_WORK_COUNT'

export const SET_JOBS = 'SET_JOBS'
export const SET_JOB_COUNT = 'SET_JOB_COUNT'

export const SET_TASKS = 'SET_TASKS'
export const SET_TASK_COUNT = 'SET_TASK_COUNT'