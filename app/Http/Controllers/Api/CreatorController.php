<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreatorController extends Controller
{
    //
    public function search($q)
    {
        // Perform the search

        $query = Creator::query();

        if (DB::connection()->getDriverName() === 'pgsql') {
            $query->whereRaw('name ILIKE ?', ["%{$q}%"]);
        } else {
            $query->where('name', 'LIKE', "%{$q}%");
        }

        $creators = $query->limit(10)->pluck('name');
        return ['OK' => true, 'data' => $creators];
    }
}
