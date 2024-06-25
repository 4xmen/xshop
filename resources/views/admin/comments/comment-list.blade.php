@extends('admin.templates.panel-list-template-raw')
@section('title')
    {{__("Comments")}} -
@endsection
@section('table')
    <table class="table-list">

        <thead>
        <tr>
            <th>
                <div
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-custom-class="custom-tooltip"
                    data-bs-title="{{__("Check all")}}"
                    class="form-check form-switch mt-1 mx-2">
                    <input class="form-check-input chkall"
                           type="checkbox" role="switch">
                </div>
            </th>
            <th>
                {{__("Commentator")}}
            </th>
            <th>
                {{__("Comment")}}
            </th>
            <th>
                {{__("Model")}}
            </th>
            <th>

            </th>
        </tr>
        </thead>
        <tbody>
        @if(count($items) == 0)
            <tr>
                <td colspan="100%">
                    {{__("There is nothing to show!")}}
                </td>
            </tr>
        @else
            @foreach($items as $item)
                <tr>
                    <td>
                        <input type="checkbox" id="chk-{{$item->id}}" class="chkbox"
                               name="id[{{$item->id}}]" value="{{$item->id}}">
                        <label for="chk-{{$item->id}}">
                            {{$item->id}}
                        </label>
                    </td>
                    <td>
                        @if($item->commentator()['url'] == null)
                            {{$item->commentator()['name']}} [{{$item->commentator()['email']}}]
                        @else
                            <a href="{{$item->commentator()['url']}}">
                                {{$item->commentator()['name']}}
                            </a>
                        @endif
                        <br>
                        {{$item->ip}}
                    </td>
                    <td class="text-start w-50">
                        @if($item->parent != null)
                            <div class="btn btn-dark float-end" data-bs-toggle="tooltip"
                                 data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                 data-bs-title="{{$item->parent->id}}.{{$item->parent?->body}}">
                                <i class="ri-message-3-line"></i>
                            </div>
                        @endif
                        {{$item->body}}
                    </td>
                    <td class="text-start">
                        {{$item->commentable->title}}
                        {{$item->commentable->name}}
                    </td>
                    <td style="min-width: 180px">
                        <div class="d-none d-xl-block d-xxl-block">
                            <a href="{{route('admin.comment.destroy',$item->id)}}"
                               class="btn btn-sm btn-danger delete-confirm ms-1" data-bs-toggle="tooltip"
                               data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                               data-bs-title="{{__("Remove")}}">
                                <i class="ri-close-line"></i>
                            </a>
                            @if($item->status != 1)
                                <a href="{{route('admin.comment.status',[$item->id,1])}}"
                                   class="btn btn-sm btn-success ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                   data-bs-custom-class="custom-tooltip"
                                   data-bs-title="{{__("Approve")}}">
                                    <i class="ri-thumb-up-line"></i>
                                </a>
                            @else
                                <a
                                    class="btn btn-sm btn-light ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-title="{{__("Reply")}}"
                                    href="{{route('admin.comment.reply',$item->id)}}">
                                    <i class="ri-reply-line"></i>
                                </a>
                            @endif
                            @if($item->status != -1)
                                <a href="{{route('admin.comment.status',[$item->id,-1])}}"
                                   class="btn btn-sm btn-warning ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                   data-bs-custom-class="custom-tooltip"
                                   data-bs-title="{{__("Reject")}}">
                                    <i class="ri-thumb-down-line"></i>
                                </a>
                            @endif
                            @if($item->status != 0)
                                <a href="{{route('admin.comment.status',[$item->id,0])}}"
                                   class="btn btn-sm btn-info ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                   data-bs-custom-class="custom-tooltip"
                                   data-bs-title="{{__("Pending")}}">
                                    <i class="ri-hourglass-line"></i>
                                </a>
                            @endif
                        </div>
                        <div class="dropdown d-xl-none d-xxl-none">
                            <a class="btn btn-outline-secondary dropdown-toggle" href="#"
                               role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item delete-confirm"
                                       href="{{getRoute('destroy',$item->{$item->getRouteKeyName()})}}">
                                        <i class="ri-close-line"></i>
                                        &nbsp;
                                        {{__("Remove")}}
                                    </a>
                                </li>
                                @if($item->status != 1)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{route('admin.comment.status',[$item->id,-1])}}">
                                            <i class="ri-thumb-up-line"></i>
                                            &nbsp;
                                            {{__("Reject")}}
                                        </a>
                                    </li>
                                @endif
                                @if($item->status != -1)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{route('admin.comment.status',[$item->id,-1])}}">
                                            <i class="ri-thumb-down-line"></i>
                                            &nbsp;
                                            {{__("Reject")}}
                                        </a>
                                    </li>
                                @endif
                                @if($item->status != 1)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{route('admin.comment.status',[$item->id,1])}}">
                                            <i class="ri-close-line"></i>
                                            &nbsp;
                                            {{__("Approve")}}
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{route('admin.comment.reply',$item->id)}}">
                                            <i class="ri-reply-line"></i>
                                            &nbsp;
                                            {{__("Reply")}}
                                        </a>
                                    </li>
                                @endif
                                @if($item->status != 0)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{route('admin.comment.status',[$item->id,0])}}">
                                            <i class="ri-hourglass-2-line"></i>
                                            &nbsp;
                                            {{__("Pending")}}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>

            @endforeach
        @endif

        </tbody>


        {{-- pagination and toggle button start --}}
        <tfoot>
        <tr>
            <th colspan="100%">
                <div class="row">
                    <div class="col-md-3 text-start">
                        <div
                            id="toggle-select"
                            class="btn btn-outline-light mx-2"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="{{__("Toggle selection")}}">
                            <i class="ri-toggle-line"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{$items->withQueryString()->links()}}
                    </div>
                    <div class="col-md-3 text-center">
                    </div>
                </div>
            </th>
        </tr>
        </tfoot>
        {{-- pagination and toggle button end --}}
    </table>
@endsection

@section('filter')
    <h2>
        <i class="ri-info-i"></i>
        {{__("Status")}}:
    </h2>
    <searchable-multi-select
        :items='@json(commentStatuses())'
        title-field="name"
        value-field="id"
        xname="filter[status]"
        :xvalue='{{request()->input('filter.status','[]')}}'
        :close-on-Select="true"></searchable-multi-select>
@endsection

@section('bulk')
    <option value="status.-1"> {{__('Reject')}} </option>
    <option value="status.0"> {{__('Pending')}} </option>
    <option value="status.1"> {{__('Approve')}} </option>
@endsection
@section('side-raw')
@endsection
