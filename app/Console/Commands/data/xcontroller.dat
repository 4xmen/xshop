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

    // protected  $_MODEL_ = User::class;
    // protected  $SAVE_REQUEST = UserSaveRequest::class;

    protected $cols = [];
    protected $extra_cols = [];

    protected $searchable = [];

    protected $listView = 'admin.users.user-list';
    protected $formView = 'admin.users.user-form';


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'show' =>
            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];


    public function __construct()
    {
        parent::__construct(User::class, UserSaveRequest::class);
    }

    /**
     * @param $user User
     * @param $request  UserSaveRequest
     * @return User
     */
    public function save($user, $request)
    {

        $user->save();
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
            /**restore*/
            case 'restore':
                $msg = __(':COUNT items restored successfully', ['COUNT' => count($ids)]);
                foreach ($ids as $id) {
                    $this->_MODEL_::withTrashed()->find($id)->restore();
                }
                break;
            /*restore**/
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

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(User::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
