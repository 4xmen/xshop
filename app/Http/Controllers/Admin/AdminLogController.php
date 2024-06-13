<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\AdminLogSaveRequest;
use App\Models\Access;
use App\Models\AdminLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class AdminLogController extends XController
{

    // protected  $_MODEL_ = AdminLog::class;
    // protected  $SAVE_REQUEST = AdminLogSaveRequest::class;

    protected $cols = ['action','user_id'];
    protected $extra_cols = ['id','loggable_type','loggable_id'];

    protected $searchable = ['action'];

    protected $listView = 'admin.commons.adminlogs';


    protected $buttons = [];


    public function __construct()
    {
        parent::__construct(AdminLog::class);
    }


    public function log(User $item){
        return redirect()->route('admin.adminlog.index',['filter[user_id]'=> '['.$item->id.']']);
    }


}
