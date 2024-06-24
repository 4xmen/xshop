<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\AttachmentSaveRequest;
use App\Models\Access;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class AttachmentController extends XController
{

    // protected  $_MODEL_ = Attachment::class;
    // protected  $SAVE_REQUEST = AttachmentSaveRequest::class;

    protected $cols = ['title','ext','is_fillable'];
    protected $extra_cols = ['slug','id'];

    protected $searchable = ['title', 'subtitle', 'body'];

    protected $listView = 'admin.attachments.attachment-list';
    protected $formView = 'admin.attachments.attachment-form';


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
        parent::__construct(Attachment::class, AttachmentSaveRequest::class);
    }

    /**
     * @param $attachment Attachment
     * @param $request  AttachmentSaveRequest
     * @return Attachment
     */
    public function save($attachment, $request)
    {

        $attachment->title = $request->input('title');
        $attachment->slug = $this->getSlug($attachment,'slug','title');
        $attachment->body = $request->input('body');
        $attachment->subtitle = $request->input('subtitle');
        $attachment->is_fillable = $request->has('is_fillable');
        if ($request->has('file')){
            $attachment->file = $this->storeFile('file',$attachment, 'attachments');
            $attachment->size = $request->file('file')->getSize();
            $attachment->ext = $request->file('file')->getClientOriginalExtension();
        }
        if ($request->has('attachable_id') && $request->has('attachable_id')){
            $attachment->attachable_type  = $request->input('attachable_type');
            $attachment->attachable_id  = $request->input('attachable_id');
        }else{
            $attachment->attachable_type  = null;
            $attachment->attachable_id  = null;
        }
        $attachment->save();
        return $attachment;

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
    public function edit(Attachment $item)
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

            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Attachment $item)
    {
        return parent::delete($item);
    }
    public function deattach(Attachment $item)
    {
        $item->attachable_id = null;
        $item->attachable_type = null;
        $item->save();

        logAdmin(__METHOD__,__CLASS__,$item->id);
        return redirect()->back()
            ->with(['message' => __('As you wished deattached successfully')]);
    }


    public function update(Request $request, Attachment $item)
    {
        return $this->bringUp($request, $item);
    }


}
