<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserSaveRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;

abstract class XController extends Controller
{

    protected $_MODEL_ = User::class;
    protected $SAVE_REQUEST = UserSaveRequest::class;
    protected $cols = [];
    protected $extra_cols = ['id'];
    protected $listView = 'admin.users.user-list';
    protected $formView = 'admin.users.user-form';

    protected $searchable = [];

    public function __construct($model = null, $request = null)
    {
        if ($model != null) {
            $this->_MODEL_ = $model;
        }
        if ($request != null) {
            $this->SAVE_REQUEST = $request;
        }
    }


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-edit-2-line'],
    ];


    public function save($item, $request)
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

        $validatedRequest = app()->make($this->SAVE_REQUEST)->merge($request->all());

        $item = new ($this->_MODEL_)();
        $item = $this->save($item, $request);
        logAdmin(__METHOD__, $this->_MODEL_, $item->id);

        if ($request->ajax()) {
            return ['OK' => true, "message" => __('As you wished created successfully'),
                "id" => $item->id,
                "data" => modelWithCustomAttrs($item) ,
                'url' => getRoute('edit', $item->{$item->getRouteKeyName()})];
        } else {
            return redirect(getRoute('edit', $item->{$item->getRouteKeyName()}))
                ->with(['message' => __('As you wished created successfully')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($item)
    {
        $x = new $this->_MODEL_();
        $m = $this->_MODEL_::where($x->getRouteKeyName(), $item)->first();
        //
        if (method_exists($m,'webUrl')){
            return redirect($m->webUrl());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function bringUp(Request $request, $item)
    {
        //

        $validatedRequest = app()->make($this->SAVE_REQUEST)->merge($request->all());
        $item = $this->save($item, $request);
        logAdmin(__METHOD__, $this->_MODEL_, $item->id);

        if ($request->ajax()) {
            return ['OK' => true,
                "data" => modelWithCustomAttrs($item) ,
                "message" => __('As you wished updated successfully'), "id" => $item->id];
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
        logAdmin(__METHOD__, $this->_MODEL_, $item->id);
        $item->delete();
        return redirect()->back()->with(['message' => __('As you wished removed successfully')]);
    }

    /**
     * restore removed the specified resource from storage.
     */
    public function restoreing($item)
    {
        //
        logAdmin(__METHOD__, $this->_MODEL_, $item->id);
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

    /**
     * do bulk actions
     * @param $msg
     * @param $action
     * @param $ids
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function do_bulk($msg, $action, $ids)
    {
        logAdminBatch(__METHOD__ . '.' . $action, $this->_MODEL_, $ids);
        return redirect()->back()->with(['message' => $msg]);
    }

    /**
     * @param $key request key as column's name
     * @param $model Model
     * @param $folder string save directory name
     * @return string|null
     */
    public function storeFile(string $key, $model, string $folder)
    {
        // Check if a file was uploaded for the given key
        if (! request()->hasFile($key)) {
            return null;
        }

        $file = request()->file($key);

        // Create a unique filename
        $name = time() . '-' . $file->getClientOriginalName();

        // Choose the disk (public storage) and target folder
        $disk   = Storage::disk('public'); // change to another disk if needed
        $target = $folder;               // e.g. 'attachments'

        // Ensure the target folder exists; create it if it doesn't
        if (! $disk->exists($target)) {
            $disk->makeDirectory($target);
        }

        // Store the file and get the relative path (e.g., "attachments/1661234567‑myfile.pdf")
        $path = $disk->putFileAs($target, $file, $name);

        return $path; // or return $name if you only need the filename
    }

    /**
     * @param $model Model
     * @param $key string key of slug request
     * @param $name base slug col
     * @return void
     */
    public function getSlug($model, $key = 'slug', $name = 'name')
    {
        if (!\request()->has('slug') || request()->input('slug') == null) {
            $slug = sluger($model->$name);
        } else {
            $slug = sluger(\request()->input($key, $model->$name));
        }

        return $this->createUniqueSlug($slug,$model->id);
    }


    /**
     * create unique slug
     * @param $slug
     * @param $id integer|null
     * @return mixed|string
     */
    public function createUniqueSlug($slug,$id = null)
    {
        $originalSlug = $slug;
        $counter = 1;

        $q  = $this->_MODEL_::where('slug', $slug);
        if ($id != null){
            $q = $q->where('id','<>',$id);
        }

        while ($q->count() > 0) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            $q  = $this->_MODEL_::where('slug', $slug);
            if ($id != null){
                $q = $q->where('id','<>',$id);
            }
        }

        return $slug;
    }


    public function saveImage($model,$key,$dir,$format = 'webp'){

        $dir = 'optimized/'.$dir;

        $disk = Storage::disk('public'); // change to another disk if needed

        // Load the image temporarily to inspect its dimensions
        $tmp = Image::load(\request()->file($key)->getPathname());

        if ($tmp->getWidth() > config('app.media.optimized_max_width')) {
            // Determine the target width (max of config('app.media.optimized_max_width') or the current width)
            $scale =  config('app.media.optimized_max_width')  / $tmp->getWidth();
            $newWidth = config('app.media.optimized_max_width');
            $newHeight = $tmp->getHeight() * $scale  ;
            $i = Image::load(\request()->file($key)->getPathname())
                ->optimize()
                // Resize while preserving aspect ratio (Fit::Contain prevents deformation)
                ->resize($newWidth, $newHeight)
                ->format($format);
        } else {
            // If width ≤ 200px, just process without resizing
            $i = Image::load(\request()->file($key)->getPathname())
                ->optimize()
                ->format($format);
        }

        if (getSetting('watermark2')) {
            $i->watermark(public_path('upload/images/logo.png'),
                AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent,
                config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                config('app.media.watermark_opacity'));
        }
        $temp = tempnam(sys_get_temp_dir(), 'TMP_');
        $i->save($temp);

        // Ensure the target folder exists; create it if it doesn't
        if (!$disk->exists($dir)) {
            $disk->makeDirectory($dir);
        }

        $name =  basename($model->$key) . '.' .$format;
        // Store the file
        $disk->putFileAs($dir, $temp, $name);
    }
}
