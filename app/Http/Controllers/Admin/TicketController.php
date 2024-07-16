<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\TicketSaveRequest;
use App\Models\Access;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class TicketController extends XController
{

    // protected  $_MODEL_ = Ticket::class;
    // protected  $SAVE_REQUEST = TicketSaveRequest::class;

    protected $cols = ['title','status','customer_id'];
    protected $extra_cols = ['id'];

    protected $searchable = [];

    protected $listView = 'admin.tickets.ticket-list';
    protected $formView = 'admin.tickets.ticket-form';


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
//        'show' =>
//            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];


    public function __construct()
    {
        parent::__construct(Ticket::class, TicketSaveRequest::class);
    }

    /**
     * @param $ticket Ticket
     * @param $request  TicketSaveRequest
     * @return Ticket
     */
    public function save($ticket, $request)
    {

        $ticket->save();
        return $ticket;

    }

    public function index()
    {
        $query = $this->makeSortAndFilter();
        $query = $query->whereNull('parent_id');
        return $this->showList($query);
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
    public function edit(Ticket $item)
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
            case 'close':
                $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => 'CLOSED']);
                $msg = __(':COUNT items closed successfully', ['COUNT' => count($ids)]);
                break;
            case 'pending':
                $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => 'PENDING']);
                $msg = __(':COUNT items pending successfully', ['COUNT' => count($ids)]);
                break;
            case 'answered':
                $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => 'ANSWERED']);
                $msg = __(':COUNT items answered successfully', ['COUNT' => count($ids)]);
                break;
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Ticket $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Ticket $item)
    {
        $item->answer = $request->answer;
        $item->status = $request->status;
        $item->user_id = auth()->id();
        $item->save();
        if ($request->has('answers')){
            foreach ($request->answers as $id => $answer) {
                Ticket::whereId($id)->update(['answer' => $answer]);
            }
        }
        logAdmin(__METHOD__,Ticket::class,$item->id);
        if ($request->ajax()) {
            return ['OK' => true,
                "data" => modelWithCustomAttrs($item) ,
                "message" => __('As you wished updated successfully'), "id" => $item->id];
        } else {
            return redirect(getRoute('edit', $item->{$item->getRouteKeyName()}))
                ->with(['message' => __('As you wished updated successfully')]);
        }
    }


}
