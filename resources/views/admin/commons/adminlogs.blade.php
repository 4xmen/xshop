@extends('admin.templates.panel-list-template-raw')

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
            @foreach($cols as $col)
                <th>
                    <a href="?sort={{$col}}{{sortSuffix($col)}}&{{queryBuilder('sort')}}">
                        {{__($col)}}
                    </a>
                </th>
            @endforeach
            <th>
                {{__("Subject")}}
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
                    @foreach($cols as $k => $col)
                        @if($k == 0 && hasRoute('edit'))
                            <td>
                                <a href="{{getRoute('edit',$item->{$item->getRouteKeyName()})}}">
                                    <b>
                                        {{$item?->{$cols[0]} }}
                                    </b>
                                </a>
                            </td>
                        @else
                            <td>
                                @switch($col)
                                    @case($col == 'user_id')
                                        <a href="{{route('admin.user.edit',$item->user?->email)}}">
                                            {{ $item->user?->name??'-' }}
                                        </a>
                                        @break
                                    @case($col == 'action')
                                        {{ getAction($item->$col) }}
                                        @break
                                    @default
                                        {{$item->$col}}
                                @endswitch
                            </td>
                        @endif
                    @endforeach
                    <td>
                        <a href="{{getModelLink($item->loggable_type,$item->loggable_id)}}">
                        {{getModelName($item->loggable_type,$item->loggable_id)}}
                        </a>
                    </td>
                    <td>

                        @if(strpos(request()->url(),'trashed') != false && hasRoute('restore'))
                            <a href="{{getRoute('restore',$item->{$item->getRouteKeyName()})}}"
                               class="btn btn-success btn-sm mx-1 d-xl-none d-xxl-none"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               data-bs-custom-class="custom-tooltip"
                               data-bs-title="{{__("Restore")}}">
                                <i class="ri-recycle-line"></i>
                            </a>
                        @else

                            <div class="dropdown d-xl-none d-xxl-none">
                                <a class="btn btn-outline-secondary dropdown-toggle" href="#"
                                   role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($buttons as $btn => $btnData)
                                        <li>
                                            <a class="dropdown-item {{$btnData['class']}}"
                                               href="{{getRoute($btn,$item->{$item->getRouteKeyName()})}}">
                                                <i class="{{$btnData['icon']}}"></i>
                                                &nbsp;
                                                {{__($btnData['title'])}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="d-none d-xl-block  d-xxl-block">
                            @foreach($buttons as $btn => $btnData)

                                @if(strpos($btnData['class'],'delete') == false )
                                    @if(strpos(request()->url(),'trashed') == false)

                                        <a href="{{getRoute($btn,$item->{$item->getRouteKeyName()})}}"
                                           class="btn {{$btnData['class']}} btn-sm mx-1"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-title="{{__($btnData['title'])}}">
                                            <i class="{{$btnData['icon']}}"></i>
                                        </a>
                                    @endif
                                @else
                                    @if( hasRoute('restore') && $item->trashed())
                                        <a class="btn btn-success btn-sm mx-1"
                                           href="{{getRoute('restore',$item->id)}}" {{--dont change this id to getRouteKeyName --}}
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-title="{{__("Restore")}}">
                                            <i class="ri-recycle-line"></i>
                                        </a>
                                    @else
                                        <a href="{{getRoute($btn,$item->{$item->getRouteKeyName()})}}"
                                           class="btn {{$btnData['class']}} btn-sm mx-1"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-title="{{__($btnData['title'])}}">
                                            <i class="{{$btnData['icon']}}"></i>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
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
        <i class="ri-shield-check-line"></i>
        {{__("User filter")}}:
    </h2>
    <searchable-multi-select
        :items='{{\App\Models\User::all('id','name')}}'
        title-field="name"
        value-field="id"
        xname="filter[user_id]"
        :xvalue='{{request()->input('filter.user_id','[]')}}'
        :close-on-Select="true"></searchable-multi-select>
@endsection
