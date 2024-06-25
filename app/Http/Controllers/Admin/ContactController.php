<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\ContactSaveRequest;
use App\Models\Access;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Helper;
use Illuminate\Support\Facades\Mail;
use function App\Helpers\hasCreateRoute;

class ContactController extends XController
{

    // protected  $_MODEL_ = Contact::class;
    // protected  $SAVE_REQUEST = ContactSaveRequest::class;

    protected $cols = ['name','subject','mobile','email',"created_at",'is_answered'];
    protected $extra_cols = ['id','hash'];

    protected $searchable = ['name','subject','mobile','email','body'];

    protected $listView = 'admin.contacts.contact-list';
    protected $formView = 'admin.contacts.contact-form';


    protected $buttons = [
//        'edit' =>
//            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'show' =>
            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];


    public function __construct()
    {
        parent::__construct(Contact::class, ContactSaveRequest::class);
    }

    /**
     * @param $contact Contact
     * @param $request  ContactSaveRequest
     * @return Contact
     */
    public function save($contact, $request)
    {

        $contact->save();
        return $contact;

    }


    public function show( $hash){
        $item = Contact::whereHash($hash)->firstOrFail();
        return view('admin.contacts.contact-show',compact('item'));
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
    public function edit(Contact $item)
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

    public function destroy(Contact $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Contact $item)
    {
        return $this->bringUp($request, $item);
    }

    public function reply(Request $request, Contact $item)
    {
        $body = $request->bodya;
        $item->is_answered = true;
        $item->body .= '<hr>'. __("Answer: <br>").$body;
        $item->save();

        Mail::raw($body, function ($message)  use ($item){

            $message->from(getSetting('email'),config('app.name'));
            $message->to($item->email);
            $message->subject('reply:',config('app.name', 'xshop') .' پاسخ تماس با ');
        });
        logAdmin(__METHOD__,Contact::class,$item->id);

        return  redirect()->back()->with(['message' => __('Your Email sent')]);
    }


}
