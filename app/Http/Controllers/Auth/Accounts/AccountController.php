<?php

namespace App\Http\Controllers\Auth\Accounts;

use App\Account;
use App\Http\Controllers\Controller;
use App\Models\RBAC\accounts;
use App\Models\RBAC\users;
use Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReviewActive;

class AccountController extends Controller
{
    public function showAccount(){
        return view('auth.accounts.account');
    }

    public function showAccountList(){
        $user = Auth::user();
        $user_id = $user->id;
        $current_account = DB::table('accounts')->where('id', $user->current_account_id)->first()->name;
        $accounts = accounts::join('accounts_users','accounts_users.accounts_id','=','accounts.id')->where('accounts_users.users_id',$user_id)->where('accounts_users.active', true)->get('name');
        return view('auth.accounts.accountChoose',['account_name'=> $accounts, 'account' => $current_account]);
    }

    public function showAccountExitList(Request $request) {
        $user = Auth::user();
        $user_id = $user->id;
        $accounts = accounts::join('accounts_users','accounts_users.accounts_id','=','accounts.id')->where('accounts_users.users_id', $user_id)->where('name', '!=', $user->name)->where('account_level', 'team create account')->get();
        Log::info($accounts);
        return view('auth.accounts.accountExit',['account_name'=>$accounts]);
    }

    public function userExitAccount(Request $request) {
        $account_uuid = $request->account_uuid;
        $user = Auth::user();
        $user_id = $user->id;
        $account_id = DB::table('accounts')->where('uuid', $account_uuid)->first()->id;
		DB::table('accounts_users')->where('users_id', $user_id)->where('accounts_id', $account_id)->delete();
        DB::table('account_role')->where('user_id', $user_id)->where('account_id', $account_id)->delete();
        
        return redirect()->route('accountExitListShow');
    }

    public function showAccountCreate(){
        return view('auth.accounts.accountCreate');
    }

    public function showAccountJoin(){
        return view('auth.accounts.accountJoin');
    }

    //首次登录的单一account
    public function individualToHome($user_uuid){
        $account = accounts::where('user_uuid',$user_uuid)->first();
        $account_name = $account->name;
        $account_id = $account->id;

        //更新数据库中当前account
        $store_current_account = new LoginRecordController();

        $store_current_account->update_current_accout($user_uuid,$account_id);

        return view('home')->with('account_name', $account_name)->with('account_uuid', $account->uuid);
    }

    //accountChoose 选择account之后进入主页
    public function toHome($account_name){
        $account = accounts::where('name',$account_name)->first();
        $user=Auth::user();

        //更新数据库中当前account
        $store_current_account = new LoginRecordController();
        $store_current_account->update_current_accout($user->uuid, $account->id);

        return view('home')->with('account_name', $account_name)->with('account_uuid', $account->uuid);
    }

    public function index()
    {
//        return Account::all();

        $accounts = accounts::get();
        foreach ($accounts as $account){
            if ($account){
                $account->user;
            }
        }
        return response()->json([
            'message' => '请求成功',
            'data' => $accounts ?: []
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 指定的user对应几个account
     */
    public function countAccounts($user_id)
    {
        $accounts = accounts::join('accounts_users','accounts_users.accounts_id','=','accounts.id')->where('accounts_users.users_id',$user_id);
//        $accounts = accounts::where('user_uuid',$user_uuid)->with('users')->get();
        $accounts_count = $accounts->count();

        return $accounts_count;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 一个user拥有的account
     */
    public function AccountsList($user_id)
    {
        $accounts = accounts::join('accounts_users','accounts_users.accounts_id','=','accounts.id')->where('accounts_users.users_id',$user_id)->get('name');

        Log::info($accounts);

        return response()->json([
            'message' => '查询计数成功',
            'data' => $accounts ?: []
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 一个account拥有几个user
     */
    public function countUsers($account_id)
    {
        $user = users::join('accounts_users','accounts_users.users_id','=','users.id')->where('accounts_users.accounts_id',$account_id)->get();
        $count = $user->count();

        return response()->json([
            'message' => '查询计数成功',
            'data' => $count ?: []
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 指定的 account id拥有的所有user
     */
    public function usersByAccountId($account_id)
    {
//        $users = users::join('accounts_users','accounts_users.users_id','=','users.id')->where('accounts_users.accounts_id',$account_id)->where('active', 1)->get();
        $account = accounts::find($account_id);
        $users = $account->users;

        return $users;
    }


    public function show($id)
    {
        //return Account::find($id);
        //return User::find($id)->accounts();
        $account = accounts::find($id);
        if($account) {
            $account->users;
        }

        return response()->json([
            'message' => '请求成功',
            'data' => $account ?: []
        ], 200);
    }

    public function store(Request $request)
    {
        Log::info($request);

        DB::beginTransaction();
        try{

            $this->validate($request, [
                'name' => 'required|string|max:255',
                'industry' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'contact' => 'required|string|max:255',
                'phone_number' => ['required', 'regex:/(^(\d{3,4}-)?\d{5,8})$|(1[0-9]{10})/'],
            ],
                [
                    'name.required' =>' Name is required and less than 255 in length ',
                    'industry.required' =>'industry is required and less than 255 in length ',
                    'position.required' =>'position is required and less than 255 in length ',
                    'contact.required' =>'contact is required and less than 255 in length ',
                    'phone number.required' =>'Phone is required and is a number',
                ]);

            $user = Auth::user();
            $user_id = $user->id;
            $name = $request->name;
            $industry = $request->industry;
            $position = $request->position;
            $phone_number = $request->phone_number;
            $contact = $request->contact;

            $tenant_id_max = DB::table('accounts')->max('tenant_id');
            $tenant_id = $tenant_id_max + 1;

            $accountModel = new accounts;
            $accountModel->name = $name;
            $accountModel->uuid = Str::uuid();
            $accountModel->account_level = 'team create account';
            $accountModel->expirated_at = Carbon::now()->addDays(9999);
            $accountModel->description = 'team create account';
            $accountModel->industry = $industry;
            $accountModel->position = $position;
            $accountModel->phone_number = $phone_number;
            $accountModel->contact = $contact;
            $accountModel->user_uuid = $user->uuid;
            $accountModel->tenant_id = $tenant_id;

            $accountModel->save();
            $accountModel->users()->attach($user_id);
            DB::commit();


            $account_id = $accountModel->id;
            $role = new RoleController();
            $role->insert_role_relation($user_id, $account_id, 'administrator');
            $role->insert_role_relation($user_id, $account_id, 'user');
            DB::table('accounts_users')->where('accounts_id', $accountModel->id)->where('users_id', $user_id)->update(['active' => true]);


            $invite_code = $accountModel->uuid;
            return view('auth.accounts.accountCreateSucess',['invite_code'=>$invite_code]);
        }catch (\Exception $e){
            DB::rollback();
            Log::info($e->getMessage());
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    public function accountJoin(Request $request)
    {
        $account_uuid = $request->inviteCode;
        Log::info($account_uuid);
        $message = 'join error,Unreasonable data,please check for correctness or repetition!';

        DB::beginTransaction();
        try{
            $user = Auth::user();
            $user_id = $user->id;

            $account = accounts::where('uuid',$account_uuid)->first();
            // $account_id = $account->id;

            if(strcmp($account->account_level,"team create account")==0){

                $account->users()->attach($user_id);

                DB::commit();

                $user['account_name'] = $account->name;

                $account_user = User::where('uuid', '=', $account->user_uuid)->first();

                Notification::send($account_user, new ReviewActive($account_user));  //新添的属性传递不进去

                // $role = new RoleController(); //没通过审核不赋予role
                // $role->insert_role_relation($user_id, $account_id, 'user');

                $account_name = $account->name;
                return view('auth.accounts.accountJoinSucess',['account_name'=>$account_name]);
            } else{
                return Redirect::back()->withErrors('error');
            }
        }catch (\Exception $e){
            DB::rollback();
            return Redirect::back()->withErrors('error');
        }
    }


    public function selectAccountByUuid(Request $request)
    {
//        return Account::create($request->all());
        $account_uuid = $request->uuid;

        DB::beginTransaction();
        try{
            $account = accounts::findOrFail($account_uuid);
            DB::commit();

            return response()->json([
                'message' => '新增成功',
                'data' => $account
            ], 200);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'message' => '新增失败',
            ], 400);
        }
    }


    public function create($account,$user_id)
    {
//        return Account::create($request->all());

        DB::beginTransaction();
        try{
            $accountModel = new accounts;
            $accountModel = $account;
            $accountModel -> save();
            $accountModel -> users() -> attach($user_id);
            $insert_id = $accountModel->id;//当前插入的account id
            DB::commit();

            return $insert_id;
        }catch (\Exception $e){
            DB::rollback();
            return null;
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $account = accounts::findOrFail($id);
            //$account -> name ='';
            $user_id = $request ->get('user_id');
            $account -> update($account);
            $account -> users()->detach();//先删除关系
            $account -> users() -> attach($user_id);
            DB::commit();

            return response()->json([
                'message' => '更新成功',
                'data' => $account
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => '更新失败',
            ], 400);
        }
    }

    public function delete(Request $request, $id)
    {
        $article = Account::findOrFail($id);
        $article->delete();

        return 204;
    }

    /**
     * @param $id
     */
    public function destory($id){
        DB::beginTransaction();
        try{
            $account = accounts::findOrFail($id);
            $account->users()->detach();//先删除关系
            $account->delete();
            DB::commit();

            return response()->json([
                'message' => '删除成功',
                'data' => $account
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => '删除失败',
            ], 400);
        }
    }
}
