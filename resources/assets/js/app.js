/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import store from './vuex/index'
import 'font-awesome/css/font-awesome.css'
import en_locale from 'element-ui/lib/locale/lang/en'
import zh_locale from 'element-ui/lib/locale/lang/zh-CN'
import locale from 'element-ui/lib/locale'


Vue.use(ElementUI);


let lang = document.head.querySelector('meta[name="lang-token"]');
if (lang.content === 'zh-CN') {
    locale.use(zh_locale);
} else {
    locale.use(en_locale);
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('clients', require('./components/passport/Clients.vue').default);
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);

//RBAC component
// Vue.component('auth-management', require('./components/RBAC/administrator/authManagement.vue').default);
// Vue.component('group-management', require('./components/RBAC/administrator/groupManagement.vue').default);
// Vue.component('group-permission', require('./components/RBAC/administrator/groupPermissionsManagement.vue').default);
// Vue.component('group-user', require('./components/RBAC/administrator/groupUsersManagement.vue').default);
// Vue.component('user-management', require('./components/RBAC/administrator/userManagement.vue').default);
// Vue.component('user-log', require('./components/RBAC/administrator/userLogs.vue').default);

import panelPagination from './components/RBAC/basic/panelPagination.vue';
Vue.component('panel-pagination', panelPagination);

import authManagement from './components/RBAC/administrator/authManagement.vue';
Vue.component('auth-management', authManagement);

import groupManagement from './components/RBAC/administrator/groupManagement.vue';
Vue.component('group-management', groupManagement);

import groupPermissionsManagement from './components/RBAC/administrator/groupPermissionsManagement.vue';
Vue.component('group-permission', groupPermissionsManagement);

import groupUsersManagement from './components/RBAC/administrator/groupUsersManagement.vue';
Vue.component('group-user', groupUsersManagement);

import userManagement from './components/RBAC/administrator/userManagement.vue';
Vue.component('user-management', userManagement);

import userLogs from './components/RBAC/administrator/userLogs.vue';
Vue.component('user-log', userLogs);


/**-------------------------------------------------ATM----------------------------------------------------**/
//system-setting
import systemSetting from './components/ATM/TestSettings/projectLib/project/systemSetting.vue';
Vue.component('system-setting', systemSetting);

//basic component
import SearchPagination from './components/ATM/BasicComponents/SearchPagination.vue';
Vue.component('search-pagination', SearchPagination);

import projectContainer from './components/ATM/TestSettings/projectContainer.vue';
Vue.component('project-container', projectContainer);

import projectToolBar from './components/ATM/TestSettings/projectToolBar.vue';
Vue.component('project-tool-bar', projectToolBar);

import OperatingGuider from './components/ATM/BasicComponents/OperatingGuider.vue';
Vue.component('operating-guider', OperatingGuider);

//projectLib
import project from './components/ATM/TestSettings/projectLib/project/projectsLib.vue';
Vue.component('project', project);

import projectTestCase from './components/ATM/TestSettings/projectLib/testCase/projectTestCase.vue';
Vue.component('project-testcase', projectTestCase);

import testCaseInstruction from './components/ATM/TestSettings/projectLib/instruction/projectCaseInstructions.vue';
Vue.component('testcase-instruction', testCaseInstruction);

import jsonEditor from './components/ATM/TestSettings/projectLib/jsonEditor.vue';
Vue.component('api-instruction', jsonEditor);


//application
import application from './components/ATM/TestSettings/projectLib/application/projectApplication.vue';
Vue.component('project-application', application);

import section from './components/ATM/TestSettings/projectLib/section/projectApplicationSection.vue';
Vue.component('application-section', section);

import elementContainer from './components/ATM/TestSettings/projectLib/element/projectApplicationSectionElementContainer.vue';
Vue.component('section-element', elementContainer);

import apiElement from './components/ATM/TestSettings/projectLib/apiElement/apiElements.vue';
Vue.component('project-apielement', apiElement);

import apiElementEdit from './components/ATM/TestSettings/projectLib/apiElement/apiElementEdit.vue';
Vue.component('apielement-edit', apiElementEdit);

//testcaseShareFolders
import Folder from './components/ATM/TestSettings/folder/folder.vue';
import FolderTestcase from './components/ATM/TestSettings/folder/folderTestCase/folderTestCase.vue';

Vue.component('folder', Folder);
Vue.component('folder-testcase', FolderTestcase);

//testCaseLib
import testCase from './components/ATM/TestSettings/testCases/testCases.vue';
Vue.component('testcase', testCase);

//runList
import runList from './components/ATM/TestSettings/runContainer/runContainer.vue';
Vue.component('run-list', runList);
import runListTestCase from './components/ATM/TestSettings/runContainer/testCase/testCaseContainer.vue';
Vue.component('run-list-testcase', runListTestCase);

//template
import instructionBundle from './components/ATM/TestSettings/instructionBundle/instructionBundle.vue';
Vue.component('instruction-bundle', instructionBundle);

import instructionBundleEntry from './components/ATM/TestSettings/instructionBundle/Entry/instructionBundleEntry.vue';
Vue.component('instruction-bundle-entry', instructionBundleEntry);


//modulePro
import engineSetting from './components/ATM/moduleProperties/engineSetting/engine.vue';
Vue.component('engine-setting', engineSetting);

import engineProperties from './components/ATM/moduleProperties/engineSetting/properties/engineProperties.vue';
Vue.component('engine-properties', engineProperties);


import driverPacks from './components/ATM/moduleProperties/driverPack/driverPacks.vue';
Vue.component('engine-packs', driverPacks);

import packsEngines from './components/ATM/moduleProperties/driverPack/engines/packsEngines.vue';
Vue.component('pack-engines', packsEngines);

import systemRequirementsPacks from './components/ATM/moduleProperties/systemRequirements/systemRequirementsPack.vue';
Vue.component('system-requirements-packs', systemRequirementsPacks);

import packsSystemRequirements from './components/ATM/moduleProperties/systemRequirements/systemRequirements/systemRequirements.vue';
Vue.component('pack-system-requirements', packsSystemRequirements);

//runstatus
Vue.component('project-runstatus', require('./components/ATM/runStatus/projectStatus.vue').default);
Vue.component('testcase-runstatus', require('./components/ATM/runStatus/projectTestCaseStatus.vue').default);

Vue.component('runlist-runstatus', require('./components/ATM/runStatus/RunListStatus.vue').default);
Vue.component('runlist-testcase-runstatus', require('./components/ATM/runStatus/RunCaseStatus.vue').default);

Vue.component('testcase-run-runstatus', require('./components/ATM/runStatus/TestCaseStatus.vue').default);


//runResult
Vue.component('project-runresult', require('./components/ATM/runResults/projectResults.vue').default);
Vue.component('project-charts', require('./components/ATM/runResults/projectResultChart.vue').default);
Vue.component('project-testcase-runresult', require('./components/ATM/runResults/projectTestCasesResults.vue').default);
Vue.component('testcase-run-runresult', require('./components/ATM/runResults/projectTestCaseRunResults.vue').default);
Vue.component('run-instruction-runresult', require('./components/ATM/runResults/projectCaseInstructionsResults.vue').default);
Vue.component('api-instruction-result-log', require('./components/ATM/runResults/projectApiInstructionResultLog.vue').default);

Vue.component('runlist-runresult', require('./components/ATM/runResults/RunListResult.vue').default);
Vue.component('runcase-runresult', require('./components/ATM/runResults/RunCaseResult.vue').default);

Vue.component('testcase-runresult', require('./components/ATM/runResults/TestCaseResult.vue').default);


//debug resut
Vue.component('debug-project', require('./components/ATM/debugResults/DebugProject.vue').default);
Vue.component('debug-testcase', require('./components/ATM/debugResults/DebugTestCase.vue').default);
Vue.component('debug-run', require('./components/ATM/debugResults/DebugRun.vue').default);
Vue.component('debug-instruction', require('./components/ATM/debugResults/DebugInstruction.vue').default);
Vue.component('debug-api-instruction', require('./components/ATM/debugResults/DebugApiInstruction.vue').default);

Vue.component('debug-runlist', require('./components/ATM/debugResults/DebugRunlist.vue').default);
Vue.component('debug-runcase', require('./components/ATM/debugResults/DebugRunCase.vue').default);

Vue.component('debug-case', require('./components/ATM/debugResults/DebugCase.vue').default);

//permission
Vue.component('users', require('./components/admin/Users.vue').default)


//lang
// Vue.component('lang', require('./components/Lang.vue').default)

/**-------------------------------------------------ATM----------------------------------------------------**/

import ControlCenter from './components/EMS/controlCenter.vue';
import Work from './components/EMS/work.vue';
import Task from './components/EMS/task.vue';
import ExecutionUnit from './components/EMS/executionUnit.vue';

Vue.component('control-center', ControlCenter);
Vue.component('work', Work);
Vue.component('task', Task);
Vue.component('execution-unit', ExecutionUnit);






const app = new Vue({
    el: '#app',
    store
});
