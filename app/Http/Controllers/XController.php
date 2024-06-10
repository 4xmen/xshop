<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSaveRequest;
use App\Models\User;
use Illuminate\Http\Request;

abstract class XController extends Controller
{

    protected const _MODEL_ = User::class;
    protected const SAVE_REQUEST = UserSaveRequest::class;
    protected $cols = [];
    protected $extra_cols = ['id'];
    protected $listView = 'admin.users.user-list';
    protected $formView = 'admin.users.user-form';

    protected $searchable = [];


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-edit-2-line'],
    ];


    public function save($user, $request)
    {

    }

    protected function showList($query)
    {


        if (hasRoute('trashed')) {
            $this->extra_cols[] = 'deleted_at';
        }
        $items = $query->paginate(config('app.panel.page_count'),
            array_merge($this->extra_cols, $this->cols));
        $cols = $this->cols;
        $buttons = $this->buttons;
        return view($this->listView, compact('items', 'cols', 'buttons'));
    }

    protected function makeSortAndFilter()
    {


        if (!\request()->has('sort') || !in_array(\request('sort'), $this->cols)) {
            $query = self::_MODEL_::orderByDesc('id');
        } else {
            $query = self::_MODEL_::orderBy(\request('sort'), \request('sortType', 'asc'));
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
            foreach ($this->searchable as $col) {
                $query->where(function ($query) {
                    foreach ($this->searchable as $key => $col) {
                        if ($key === 0) {
                            $query->where($col, 'LIKE', '%' . \request()->input('q', '') . '%');
                        } else {
                            $query->orWhere($col, 'LIKE', '%' . \request()->input('q', '') . '%');
                        }
                    }
                });
            }
        }
        return $query;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = $this->makeSortAndFilter();
        return $this->showList($query);

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validatedRequest = app()->make(self::SAVE_REQUEST)->merge($request->all());

        $item = new (self::_MODEL_)();
        $item = $this->save($item, $request);
        logAdmin(__METHOD__, self::_MODEL_, $item->id);

        if ($request->ajax()) {
            return ['OK' => true, __('As you wished created successfully')];
        } else {
            return redirect(getRoute('edit', $item->{$item->getRouteKeyName()}))
                ->with(['message' => __('As you wished created successfully')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function bringUp(Request $request, $item)
    {
        //

        $validatedRequest = app()->make(self::SAVE_REQUEST)->merge($request->all());
        $item = $this->save($item, $request);
        logAdmin(__METHOD__, self::_MODEL_, $item->id);

        if ($request->ajax()) {
            return ['OK' => true, __('As you wished updated successfully')];
        } else {
            return redirect(getRoute('edit', $item->{$item->getRouteKeyName()}))
                ->with(['message' => __('As you wished updated successfully')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($item)
    {
        //
        logAdmin(__METHOD__, self::_MODEL_, $item->id);
        $item->delete();
        return redirect()->back()->with(['message' => __('As you wished removed successfully')]);
    }

    /**
     * restore removed the specified resource from storage.
     */
    public function restoreing($item)
    {
        //
        logAdmin(__METHOD__, self::_MODEL_, $item->id);
        $item->restore();
        return redirect()->back()->with(['message' => __('As you wished restored successfully')]);
    }


    /**
     * Show list of trashed
     */
    public function trashed()
    {
        $query = $this->makeSortAndFilter()->onlyTrashed();
        return $this->showList($query);
    }

    protected function do_bulk($msg, $action, $ids)
    {
        logAdminBatch(__METHOD__ . '.' . $action, self::_MODEL_, $ids);
        return redirect()->back()->with(['message' => $msg]);
    }


}
