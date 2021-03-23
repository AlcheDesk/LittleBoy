<?php
namespace App\Http\Controllers\RBAC;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;
use Exception;

class UserController extends Controller
{

    public function __construct()
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all users and pass it to the view
        return User::all();
    }

    // /**
    // * Show the form for creating a new resource.
    // *
    // * @return \Illuminate\Http\Response
    // */
    // public function create()
    // {
    // // Get all roles and pass it to the view
    // $roles = Role::get();
    // return view('users.create', [
    // 'roles' => $roles
    // ]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate name, email and password fields
            $this->validate($request, [
                'name' => 'required|max:120',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);

            $email = $request->email;
            $user = new User([
                'name' => $request->name,
                'email' => $email,
                'password' => bcrypt($request->password),
                // generate random activation token
                'activation_token' => str_random(60),
                // generate random v4 UUID for the user
                'uuid' => (string) Str::uuid()
            ]);

            $user->save();

            $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
            Storage::put('avatars/' . $user->id . '/avatar.png', (string) $avatar);

            // $user = User::create($request->only('email', 'name', 'password')); // Retrieving only the email and password data

            $roles = $request['roles']; // Retrieving the roles field
                                        // Checking if a role was selected
            if (isset($roles)) {
                foreach ($roles as $role) {
                    $role_r = Role::where('id', '=', $role)->firstOrFail();
                    $user->assignRole($role_r); // Assigning role to user
                }
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        DB::beginTransaction();
        try {
            // use the uuid to find the user
            $user = User::where('uuid', $id)->firstOrFail();
            $roles = $user->getRoleNames();
            $user->roles = $roles;
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // /**
    // * Show the form for editing the specified resource.
    // *
    // * @param int $id
    // * @return \Illuminate\Http\Response
    // */
    // public function edit($id)
    // {
    // $user = User::findOrFail($id); // Get user with specified id
    // $roles = Role::get(); // Get all roles

    // return view('users.edit', compact('user', 'roles')); // pass user and roles data to view
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // $user = User::findOrFail($id); // Get role specified by id

            $user = User::where('uuid', $id)->firstOrFail();
            // Validate name, email and password fields
            $this->validate($request, [
                'name' => 'required|max:120',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required|min:6|confirmed'
            ]);
            $input = $request->only([
                'name',
                'email',
                'password'
            ]); // Retreive the name, email and password fields
            $roles = $request['roles']; // Retreive all roles
                                        // update the user data
            $user->fill($input)->save();

            if (isset($roles)) {
                $user->roles()->sync($roles); // If one or more role is selected associate user to roles
            } else {
                $user->roles()->detach(); // If no role is selected remove exisiting role associated to a user
            }
            $userAfter = User::where('email', $request->email)->firstOrFail();
            $roles = $user->getRoleNames();
            $userAfter->roles = $roles;
            DB::commit();
            return $userAfter;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Find a user with a given id and delete
            $user = User::where('uuid', $id)->findOrFail();
            $user->delete();
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}

