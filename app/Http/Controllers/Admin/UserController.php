<?php

namespace App\Http\Controllers\Admin;

use App\CreateOrUpdate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Models\Item;
use App\Models\User;
use App\SafeController;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class UserController extends XController
{
    protected $cols = ['name', 'email', 'role', 'mobile'];
    protected $filterables = ['role'];

    protected $searchable = ['name','mobile','email'];

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

  public function createOrUpdate( $item, $request)
  {


  }

    public function bulk(Request $request){

//        dd($request->all());
        $data = explode('.', $request->input('action'));
        $action = $data[0];
        $ids = $request->input('id');
        switch ($action) {
            case 'delete':
                $msg = __(':COUNT items deleted successfully',['COUNT' => count($ids)]);
                $this->model::destroy($ids);
                break;
            case 'restore':
                $msg = __(':COUNT items restored successfully',['COUNT' => count($ids)]);
                foreach ($ids as $id) {
                    $this->model::withTrashed()->find($id)->restore();
                }
                break;
            case 'role':
                foreach ($ids as $id) {
                    $user = User::where('id',$id)->first();
                    $user->role = $data[1];
                    $user->syncRoles([strtolower($data[1])]);
                    $user->save();
                }
                $msg = __(':COUNT user role changed to :NEWROLE successfully',['COUNT' => count($ids), 'NEWROLE' => __($data[1])]);
                break;
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action] );
        }

        return $this->do_bulk($msg,$action, $ids);
    }

    public function destroy(User $item)
    {
        return parent::delete($item);
    }

    public function restore($item)
    {

        return parent::restoreing(User::withTrashed()->where('email',$item)->first());
    }
}
