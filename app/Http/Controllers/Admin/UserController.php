<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\UserSaveRequest;
use App\Models\Access;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class UserController extends XController
{
    protected $cols = ['name', 'email', 'role', 'mobile'];

    protected $searchable = ['name', 'mobile', 'email'];


    protected const request = UserSaveRequest::class;

    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'show' =>
            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
        'log' =>
            ['title' => "Logs", 'class' => 'btn-outline-light', 'icon' => 'ri-file-list-2-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];

    public function save($user, $request)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (trim($request->input('password')) != '') {
            $user->password = bcrypt($request->input('password'));
        }
        $user->mobile = $request->input('mobile');
        $user->role = $request->input('role');
        $user->syncRoles($request->input('role'));
        $user->save();
        if ($request->has('acl')) {
            $user->accesses()->delete();
            foreach ($request->input('acl', []) as $route) {
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

        }
        return $user;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view($this->formView);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $item)
    {
        //
        return view($this->formView, compact('item'));
    }

    public function bulk(Request $request)
    {

//        dd($request->all());
        $data = explode('.', $request->input('action'));
        $action = $data[0];
        $ids = $request->input('id');
        switch ($action) {
            case 'delete':
                $msg = __(':COUNT items deleted successfully', ['COUNT' => count($ids)]);
                $this->_MODEL_::destroy($ids);
                break;
            case 'restore':
                $msg = __(':COUNT items restored successfully', ['COUNT' => count($ids)]);
                foreach ($ids as $id) {
                    $this->_MODEL_::withTrashed()->find($id)->restore();
                }
                break;
            case 'role':
                foreach ($ids as $id) {
                    $user = User::where('id', $id)->first();
                    $user->role = $data[1];
                    $user->syncRoles([strtolower($data[1])]);
                    $user->save();
                }
                $msg = __(':COUNT users role changed to :NEWROLE successfully', ['COUNT' => count($ids), 'NEWROLE' => __($data[1])]);
                break;
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(User $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, User $item)
    {
        return $this->bringUp($request, $item);
    }

    public function restore($item)
    {
        return parent::restoreing(User::withTrashed()->where('email', $item)->first());
    }
}
