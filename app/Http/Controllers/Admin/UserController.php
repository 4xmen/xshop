<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use function Xmen\StarterKit\Helpers\logAdmin;
use Xmen\StarterKit\Requests\UserSaveRequest;

class UserController extends Controller
{
    private $name = 'User';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(20);

        return view('starter-kit::admin.user.userList', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('starter-kit::admin.user.userForm');
    }

    public function createOrUpdate(User $user, UserSaveRequest $req)
    {
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        if (trim($req->input('password')) != '') {
            $user->password = bcrypt($req->input('password'));
        }
        $user->mobile = $req->input('mobile');
        $user->syncRoles($req->input('role'));
        $user->save();
        $user->accesses()->delete();
        foreach ($req->input('acl', []) as $route) {
            $a = new Access();
            $a->route = $route;
            $a->user_id = $user->id;
            $a->save();
            $routes = explode('.', $route);
            if ($routes[2] == 'store' || $routes[2] == 'update') {
                $routes[2] = $routes[2] == 'store' ? 'create' : 'edit';
                $a = new Access();
                $a->route = implode('.', $routes);
                $a->user_id = $user->id;
                $a->save();
            }
        }
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSaveRequest $request)
    {
        $user = new User();
        $user = $this->createOrUpdate($user, $request);
        logAdmin(__METHOD__, User::class, $user->id);

        return redirect()->route('admin.user.all')->with(['message' => $user->name . ' ' . __($this->name) . ' ' . __(' created')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    public function edit(User $user)
    {
        $routes = [];
        foreach (\Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                $routeName = explode('.', $action['as']);
                if (isset($routeName[2]) && $routeName[0] == 'admin') {
                    if (!isset($routes[$routeName[1]])) {
                        $routes[$routeName[1]] = [];
                        if ($routeName[2] != 'edit' && $routeName[2] != 'create')
                            $routes[$routeName[1]][] = $routeName[2];

                    } else {
                        if ($routeName[2] != 'edit' && $routeName[2] != 'create')
                            $routes[$routeName[1]][] = $routeName[2];
                    }
                }
            }
        }
        unset($routes['home'], $routes['user'], $routes['ckeditor']);
        return view('starter-kit::admin.user.userForm', compact('user', 'routes'));
    }

    public function update(UserSaveRequest $request, User $user)
    {
        $this->createOrUpdate($user, $request);
        logAdmin(__METHOD__, User::class, $user->id);

        return redirect()->route('admin.user.all')->with(['message' => $user->name . ' ' . __($this->name) . ' ' . __(' edited')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->hasRole('super-admin')) {
            $user->delete();
            logAdmin(__METHOD__, User::class, $user->id);
            return redirect()->back()->with(['message' => $user->name . ' ' . __($this->name) . ' ' . __(' deleted')]);
        }
        return redirect()->route('admin.user.all');
    }
}
