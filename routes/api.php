<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth')->get('/user', function (Request $request) {
// 	return $request->user();
// });
//
//RBAC routes
require __DIR__ . '/API/RBAC/userRoute.php';
require __DIR__ . '/API/RBAC/roleRoute.php';
require __DIR__ . '/API/RBAC/permissionRoute.php';

require __DIR__ . '/API/auth/authRoute.php';
require __DIR__ . '/API/auth/passwordResetRoute.php';
//ATM routes
require __DIR__ . '/API/atm/apiSchemaRoute.php';
require __DIR__ . '/API/atm/accountRoute.php';
require __DIR__ . '/API/atm/aliasRoute.php';
require __DIR__ . '/API/atm/apiUnitCallRoute.php';
require __DIR__ . '/API/atm/applicationRoute.php';
require __DIR__ . '/API/atm/copyRoute.php';
require __DIR__ . '/API/atm/countRoute.php';
require __DIR__ . '/API/atm/driverEntryRoute.php';
require __DIR__ . '/API/atm/driverPackRoute.php';
require __DIR__ . '/API/atm/driverPropertyPredefinedValueRoute.php';
require __DIR__ . '/API/atm/driverPropertyRoute.php';
require __DIR__ . '/API/atm/driverRoute.php';
require __DIR__ . '/API/atm/driverTypeRoute.php';
require __DIR__ . '/API/atm/driverVendorRoute.php';
require __DIR__ . '/API/atm/instructionActionRoute.php';
require __DIR__ . '/API/atm/elementLocatorTypeRoute.php';
require __DIR__ . '/API/atm/elementRoute.php';
require __DIR__ . '/API/atm/elementTypeRoute.php';
require __DIR__ . '/API/atm/emailNotificationTargetRoute.php';
require __DIR__ . '/API/atm/executeRoute.php';
require __DIR__ . '/API/atm/exportRoute.php';
require __DIR__ . '/API/atm/fileRoute.php';
require __DIR__ . '/API/atm/fileTypeRoute.php';
require __DIR__ . '/API/atm/folderRoute.php';
require __DIR__ . '/API/atm/groupRoute.php';
require __DIR__ . '/API/atm/instructionBundleRoute.php';
require __DIR__ . '/API/atm/instructionOptionRoute.php';
require __DIR__ . '/API/atm/instructionOverwriteRoute.php';
require __DIR__ . '/API/atm/instructionResultRoute.php';
require __DIR__ . '/API/atm/instructionRoute.php';
require __DIR__ . '/API/atm/instructionTypeRoute.php';
require __DIR__ . '/API/atm/notificationRoute.php';
require __DIR__ . '/API/atm/projectRoute.php';
require __DIR__ . '/API/atm/projectTypeRoute.php';
require __DIR__ . '/API/atm/propertyRoute.php';
require __DIR__ . '/API/atm/resultReportRoute.php';
require __DIR__ . '/API/atm/runRoute.php';
require __DIR__ . '/API/atm/runSetRoute.php';
require __DIR__ . '/API/atm/runSetResultRoute.php';
require __DIR__ . '/API/atm/sectionRoute.php';
require __DIR__ . '/API/atm/systemRequirementPacksRoute.php';
// require __DIR__ . '/API/atm/statusReportRoute.php';
require __DIR__ . '/API/atm/stepLogRoute.php';
require __DIR__ . '/API/atm/stepLogTypeRoute.php';
require __DIR__ . '/API/atm/systemRequirementRoute.php';
require __DIR__ . '/API/atm/schedulerRoute.php';
require __DIR__ . '/API/atm/tagRoute.php';
// require __DIR__ . '/API/atm/testCaseFolderRoute.php';
// require __DIR__ . '/API/atm/testCaseFolderTypeRoute.php';
require __DIR__ . '/API/atm/testCaseOptionRoute.php';
require __DIR__ . '/API/atm/testCaseOverwriteRoute.php';
require __DIR__ . '/API/atm/testCaseRoute.php';
require __DIR__ . '/API/atm/testCaseTypeRoute.php';
require __DIR__ . '/API/atm/terminationRoute.php';
require __DIR__ . '/API/atm/userContentAndContentTypeRoute.php';
// require __DIR__ . '/API/atm/utilRoute.php';
// User Routes
require __DIR__ . '/API/atm/preExecutionRoute.php';


//EMS routes
// require __DIR__ . '/API/ems/groupRoute.php';
require __DIR__ . '/API/ems/jobRoute.php';
// require __DIR__ . '/API/ems/jobTypeRoute.php';
// require __DIR__ . '/API/ems/operatingSystemRoute.php';
// require __DIR__ . '/API/ems/statusRoute.php';
require __DIR__ . '/API/ems/taskRoute.php';
// require __DIR__ . '/API/ems/taskTypeRoute.php';
// require __DIR__ . '/API/ems/vendorRoute.php';
require __DIR__ . '/API/ems/workerRoute.php';

// //Test routes
// require __DIR__ . '/API/test/ExceptionTestRoute.php';

// User Routes
require __DIR__ . '/API/user/accountRoute.php';

// Util Routes
require __DIR__ . '/Util/utilRoute.php';

//verify Routes
require __DIR__ . '/API/atm/verifyRoute.php';

//execution info route
require __DIR__ . '/API/atm/testCaseExecutionInfoRoute.php';
require __DIR__ . '/API/atm/runExecutionInfoRoute.php';
require __DIR__ . '/API/atm/projectExecutionInfoRoute.php';

//report info route
require __DIR__ . '/API/atm/projectReportInfoRoute.php';

