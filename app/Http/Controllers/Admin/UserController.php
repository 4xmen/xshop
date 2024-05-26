<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class UserController extends XController
{
    protected $cols = ['name','email','role','mobile'];
}
