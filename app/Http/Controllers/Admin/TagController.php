<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\TagSaveRequest;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class TagController extends XController
{

    protected $cols = ['name', 'slug'];
    protected $extra_cols = ['id'];

    protected $searchable = ['name', 'slug'];

    protected $listView = 'admin.tags.tag-list';


    protected $buttons = [
    ];


    public function __construct()
    {
        parent::__construct(Tag::class, TagSaveRequest::class);
    }


    protected function makeSortAndFilter()
    {


        if (!\request()->has('sort') || !in_array(\request('sort'), $this->cols)) {
            $query = $this->_MODEL_::orderByDesc('id');
        } else {
            $query = $this->_MODEL_::orderBy(\request('sort'), \request('sortType', 'asc'));
        }

        foreach (\request()->input('filter', []) as $col => $filter) {
            if (isJson($filter)) {
                $vals = json_decode($filter);
                if (count($vals) != 0) {
                    $query->whereIn($col, $vals);
                }
            } else {
                $query->where($col, $filter);
            }
        }

        if (mb_strlen(trim(\request()->input('q', ''))) > 0) {
            $q = trim(json_encode(\request()->input('q', '')), ' "');
            $q = str_replace('\\', '\\\\', $q);
            foreach ($this->searchable as $col) {
                $query->where(function ($query) use ($q) {
                    foreach ($this->searchable as $key => $col) {
                        if ($key === 0) {
                            $query->where($col, 'LIKE', '%' . $q . '%');
                        } else {
                            $query->orWhere($col, 'LIKE', '%' . $q . '%');
                        }
                    }
                });
            }
        }
        return $query;
    }

}
