@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit contact")}} [{{$item->id}}]
    @else
        {{__("Add new contact")}}
    @endif -
@endsection
@section('form')

    <div class="row">
        <div class="col-lg-3">

            @include('components.err')
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-message-3-line"></i>
                    {{__("Tips")}}
                </h3>
                <ul>
                    <li>
                        {{__("Recommends")}}
                    </li>
                </ul>
            </div>

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit contact")}} [{{$item->id}}]
                    @else
                        {{__("Add new contact")}}
                    @endif
                </h1>

            </div>
        </div>
    </div>
@endsection
