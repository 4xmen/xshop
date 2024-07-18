@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit menu")}} [{{$item->name}}]
    @else
        {{__("Add new menu")}}
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
                    @if(isset($item))
                        <li>
                            {{__("You can add item after create menu")}}
                        </li>
                    @else
                        <li>
                            {{__("Added items view depends on theme part")}}
                        </li>
                    @endif
                </ul>
            </div>
            @if(isset($item))

                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-eye-2-line"></i>
                        {{__("Preview")}}
                    </h3>
                    <div class="p-2">
                        <ul class="list-group">
                            @foreach($item->items as $i)
                                <li class="list-group-item">
                                    {{$i->title}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="p-2 pt-0">
                        <a href="{{ route('admin.menu.sort',$item->id) }}" class="btn btn-primary w-100">
                            <i class="ri-sort-desc"></i>
                            {{__("Change items sort")}}
                        </a>
                    </div>
                </div>
            @endif

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit menu")}} [{{$item->name}}]
                    @else
                        {{__("Add new menu")}}
                    @endif

                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="name">
                                {{__('Name')}}
                            </label>
                            <input name="name" type="text"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="{{__('Name')}}"
                                   value="{{old('name',$item->name??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label> &nbsp;</label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>
                </div>
                @if(isset($item))

                    <h4 class="px-4">
                        {{__("Menu items")}}
                    </h4>
                    <menu-item-input
                        :morphs='@json(\App\Models\Menu::$mrohps)'
                        morph-search-link="{{route('v1.morph.search')}}"
                        xlang="{{config('app.locale')}}"
                        :items='@json($item->items)'
                        menu-id="{{$item->id}}"
                    ></menu-item-input>
                @endif
            </div>
        </div>
    </div>
@endsection
