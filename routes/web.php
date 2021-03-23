<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LanguageController;


// require __DIR__ . '/UI/auth/auth.php';
require __DIR__ . '/UI/RBAC/RBAC.php';
require __DIR__ . '/UI/atm/testSetting.php';
require __DIR__ . '/UI/atm/modulePro.php';
require __DIR__ . '/UI/atm/runResult.php';
// require __DIR__ . '/UI/atm/runStatus.php';
require __DIR__ . '/UI/atm/debugResult.php';
require __DIR__ . '/UI/atm/exportRoute.php';

//ems
require __DIR__ . '/UI/ems/ems.php';

//accounts
require __DIR__ . '/UI/auth/accountRoute.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::redirect('/', '/login');

Route::get('/register/active/{token}', 'Auth\RegisterController@registerActive');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home/{account_name}/','Auth\Accounts\AccountController@toHome');

Route::get('/home/individual/{account_name}/','Auth\Accounts\AccountController@individualToHome');


Route::get('/invite', function () {
	return View::make("/auth/invite");
});

Route::get('/invite/codeSend', 'InviteController@invitationCode')->name('invite');
Route::get('/lang/{locale}', 'LanguageController@setLocale')->name('lang');

Route::get('profile', 'Auth\ProfileController@profile')->name('profile');

Route::post('profile', 'Auth\ProfileController@update_avatar');

Route::post('profile/name', 'Auth\ProfileController@update_profile_name')->name('update_profile_name');

Route::post('profile/email', 'Auth\ProfileController@update_profile_email')->name('update_profile_email');

Route::post('profile/password', 'Auth\ProfileController@update_profile_password')->name('update_profile_password');

Route::get('pay', 'Pay\AliPayController@alipay')->name('pay');

//route for log viewer
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::get('pdf', function() {
	PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

	$pdf = PDF::loadView('pdf');
	
	$pdf->setOptions(['isPhpEnabled'=> true]);
	return $pdf->stream();
});

Route::get('/export/testCases/{id}', 'API\ATM\ExportController@exportExcelTestCase');
Route::get('/export/runSets/{id}', 'API\ATM\ExportController@exportExcelRunSet');
Route::get('/export/projects/{id}', 'API\ATM\ExportController@exportExcelProject');
Route::get('/export/runSetResults/{id}', 'API\ATM\ExportController@exportExcelRunSetResult');

