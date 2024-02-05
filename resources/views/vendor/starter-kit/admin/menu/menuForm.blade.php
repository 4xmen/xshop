@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    @if (isset($menu))
        {{__("Edit Menu")}} {{$menu->name}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if (isset($menu))
                {{__("Edit Menu")}} {{$menu->name}}
            @endif
        </h1>
        @include('starter-kit::component.err')


        <div class="row">
            <div class="col-md-6  p-3">
                <ol class="list-group menu-x" id="draggable">
                    <li class="list-group-item" data-can="false">
                            <span>
                                {{__("Empty title")}}
                            </span>
                        <input id="empy-title" type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input type="hidden" name="menu[][meta]" value="">
                        <input type="hidden" name="menu[][kind]" value="empty">
                        <ol>

                        </ol>
                    </li>
                    <li class="list-group-item" data-can="false">
                        <span>
                            {{__("Posts")}}
                        </span>
                        <input type="text" id="news-auto" placeholder="{{__("Posts search")}}" class="form-control mt-2" />
                        <input id="news-title" type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input type="hidden" name="menu[][meta]" value="">
                        <input type="hidden" name="menu[][kind]" value="news">
                        <input type="hidden" id="nid" name="menu[][menuableid]" value="">
                        <input type="hidden" name="menu[][menuabletype]" value="App\News">
                    </li>
                    <li class="list-group-item" data-can="false">
                            <span>
                                {{__("Category")}}
                            </span>
                        <select name="menu[][menuableid]"
                                class="form-control">
                            @foreach($cats as $cat )
                                <option value="{{$cat->id }}"> {{$cat->name}} </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="menu[][menuabletype]" value="App\Category">
                        <input id="cat-title" type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input type="hidden" name="menu[][meta]" value="">
                        <input type="hidden" name="menu[][kind]" value="cat">
                    </li>
                    <li class="list-group-item" data-can="false">
                            <span>
                                {{__("Category with Sub Category")}}
                            </span>
                        <select name="menu[][menuableid]" class="form-control">
                            @foreach($cats as $cat )
                                <option value="{{$cat->id }}"> {{$cat->name}} </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="menu[][menuabletype]" value="App\Category">
                        <input id="cat-sub-title" type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input type="hidden" name="menu[][meta]" value="">
                        <input type="hidden" name="menu[][kind]" value="cat-sub">
                    </li>
                    <li class="list-group-item" data-can="false">
                            <span>
                                {{__("Category with sub posts")}}
                            </span>
                        <select name="menu[][menuableid]" class="form-control">
                            @foreach($cats as $cat )
                                <option value="{{$cat->id }}"> {{$cat->name}} </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="menu[][menuabletype]" value="App\Category">
                        <input id="cat-post-title" type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input type="hidden" name="menu[][meta]" value="">
                        <input type="hidden" name="menu[][kind]" value="cat-news">
                    </li>
                    <li class="list-group-item" data-can="false">
                        <span>
                            {{__("Tag")}}
                        </span>
                        <input type="text" placeholder="{{__("Tag search")}}" name="menu[][meta]" id="tag-auto1"  class="form-control mt-2" />
                        <input id="tag-title"  type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input type="hidden" name="menu[][kind]" value="tag">
                    </li>
                    <li class="list-group-item" data-can="false">
                        <span>
                        {{__("Tag with sub posts")}}
                        </span>
                        <input type="text" id="tag-auto2" placeholder="{{__("Tag search")}}"  name="menu[][meta]"  class="form-control mt-2" />
                        <input id="tag-sub-title" type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input type="hidden" name="menu[][kind]" value="tag-sub">
                    </li>
                    <li class="list-group-item" data-can="false">
                            <span>
                                {{__("Direct link")}}
                            </span>
                        <input id="link-title" type="text" name="menu[][title]" class="form-control mt-2"
                               placeholder="{{__("Title")}}"/>
                        <input id="link-link" type="url" name="menu[][meta]" class="form-control mt-2"
                               placeholder="link">
                        <input type="hidden" name="menu[][kind]" value="link">
                    </li>
                </ol>
            </div>
            <div class="col-md-6 p-3">
                <div class="alert alert-info">
                    {{__("Double click on to remove item")}}
                </div>
                <form class="" method="post"
                      enctype="multipart/form-data"
                      @if (isset($menu))
                      action="{{route('admin.menu.update',$menu->id)}}"
                    @endif
                >
                    @csrf
                    <ol class="menu-manage menu-x" id="menu-manage">
                        {!!\App\Helpers\showMenuMange2($menu->menuItems()->whereNull('parent')->orderBy('sort')->get())!!}
                    </ol>
                    <input type="hidden" name="info" value="[]" id="sorted"/>
                    <input type="button" id="save-menu" class="btn btn-primary" value="{{__("Save")}}">
                    <a href="{{route('admin.menu.show',$menu->id)}}" target="_blank" class="btn btn-secondary">
                        {{__("Preview")}}
                    </a>
                </form>
            </div>
        </div>
        <input type="hidden" id="tag-search" value="{{route('admin.ckeditor.tagsearch','')}}"/>
        <input type="hidden" id="news-search" value="{{route('admin.ckeditor.newssearch','')}}"/>
        <input type="hidden" id="rm-item" value="{{route('admin.menu.remItem','')}}"/>

    </div>
@endsection
