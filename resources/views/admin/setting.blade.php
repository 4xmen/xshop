@extends('admin.adminlayout')
@section('page_title')
    {{__("Setting")}}
    -
@endsection
@section('content')

    @include('starter-kit::component.err')

    <form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <ul class="list-group">
            @foreach($settings as $set)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="{{$set->key}}">
                                    {{$set->title}}
                                </label>
                                @switch($set->type)
                                    @case('longtext')
                                        <textarea name="{{$set->key}}" id="{{$set->key}}" class="form-control"
                                                  rows="5">{{$set->value}}</textarea>
                                        @break
                                    @case('checkbox')
                                        <div class="row">
                                            <div class="col-md">
                                            </div>
                                            <div class="col-md">
                                                <label>
                                                    <input type="radio" name="{{$set->key}}"
                                                           @if($set->value == 'yes')  checked @endif value="yes">
                                                    {{__("Yes")}}
                                                </label>
                                            </div>
                                            <div class="col-md">
                                                <label>
                                                    <input type="radio" name="{{$set->key}}" value="no"
                                                           @if($set->value == 'no')  checked @endif>
                                                    {{__("No")}}
                                                </label>
                                            </div>
                                        </div>
                                        @break
                                    @case('code')
                                        <textarea dir="ltr" name="{{$set->key}}" id="{{$set->key}}" class="form-control"
                                                  rows="5">{{$set->value}}</textarea>
                                        @break
                                    @case('editor')
                                        <textarea name="{{$set->key}}" id="{{$set->key}}" class="ckeditor form-control"
                                                  rows="5">{{$set->value}}</textarea>
                                        @break
                                    @case('category')
                                        <select name="{{$set->key}}" id="{{$set->key}}" class="form-control">
                                            @foreach($cats as $cat )
                                                <option @if (old($set->key,$set->value??null) == $cat->id ) selected
                                                        @endif value="{{$cat->id }}"> {{$cat->name}} </option>
                                            @endforeach
                                        </select>
                                        @break
                                    @case('cat')
                                        <select name="{{$set->key}}" id="{{$set->key}}" class="form-control">
                                            @foreach($pcats as $cat )
                                                <option @if (old($set->key,$set->value??null) == $cat->id ) selected
                                                        @endif value="{{$cat->id }}"> {{$cat->name}} </option>
                                            @endforeach
                                        </select>
                                        @break
                                    @case('image')
                                        <img src="{{asset('images/'.str_replace('_','.',$set->key))}}?{{time()}}"
                                             class="img-fluid" style="max-height: 150px;max-width: 45%" alt="cover">
                                        <input type="file" name="pic[{{$set->key}}]" id="{{$set->key}}"
                                               accept="image/*"
                                               class="form-control-file"/>
                                        @break
                                    @default
                                        <input type="{{$set->type}}" name="{{$set->key}}" id="{{$set->key}}"
                                               class="form-control" value="{{$set->value}}"/>
                                @endswitch
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </li>
            @endforeach
            <li class="list-group-item">
                <input type="submit" value="{{__("Save")}}" class="btn btn-primary"/>
                <input type="reset" value="{{__("Reset")}}" class="btn btn-secondary"/>
            </li>
        </ul>
    </form>

    @if(auth()->user()->hasRole('super-admin'))
        <form class="border p-3 m-3" method="post" action="{{route('admin.setting.store')}}">
            <h3>
                {{__("Add new setting")}}
            </h3>
            @csrf

            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="section">
                            {{__('Section')}}
                        </label>
                        <input name="section" type="text" class="form-control @error('section') is-invalid @enderror"
                               placeholder="{{__('Section')}}" value="{{old('section',$setting->section??null)}}"/>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="type">
                            {{__('Type')}}
                        </label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="text"
                                    @if (old('type') == 'text' ) selected @endif >{{__("Short text")}} </option>
                            <option value="longtext"
                                    @if (old('longtext') == 'long' ) selected @endif >{{__("Long text")}} </option>
                            <option value="code"
                                    @if (old('code') == 'code' ) selected @endif >{{__("Code")}} </option>
                            <option value="editor"
                                    @if (old('editor') == 'editor' ) selected @endif >{{__("Editor text")}} </option>
                            <option value="category"
                                    @if (old('type') == 'category' ) selected @endif >{{__("Category")}} </option>
                            <option value="cat"
                                    @if (old('type') == 'cat' ) selected @endif >{{__("Product category")}} </option>
                            <option value="checkbox"
                                    @if (old('type') == 'checkbox' ) selected @endif >{{__("Checkbox")}} </option>
                            <option value="image"
                                    @if (old('type') == 'image' ) selected @endif >{{__("Image")}} </option>

                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="title">
                            {{__('Title')}}
                        </label>
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{__('Title')}}" value="{{old('title',$setting->title??null)}}"/>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="key">
                            {{__('Key')}}
                        </label>
                        <input name="key" type="text" class="form-control @error('key') is-invalid @enderror"
                               placeholder="{{__('Key')}}" value="{{old('key',$setting->key??null)}}"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <label> &nbsp;</label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Add to setting')}}"/>
                </div>
            </div>
        </form>
    @endif
@endsection
@section('js-content')
    <script>
        document.querySelector('#price').classList.add('currency');
    </script>
@endsection
