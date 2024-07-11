@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit language")}} [{{$item->tag}}]
    @else
        {{__("Add new language")}}
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
                        {{__("Edit language")}} [{{$item->tag}}]
                    @else
                        {{__("Add new language")}}
                    @endif
                </h1>



                <div class="row">
                    <div class="col-md-8 mt-3">
                        <div class="form-group">
                            <label for="name" >
                                {{__('Name')}}
                            </label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="{{__('Name')}}" value="{{old('name',$item->name??null)}}"  />
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="tag" >
                                {{__('Tag')}}
                            </label>
                            <input name="tag" type="text" class="form-control @error('tag') is-invalid @enderror"  id="tag" placeholder="{{__('Tag')}}" value="{{old('tag',$item->tag??null)}}"  maxlength="7" />
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="emoji" >
                                {{__('Emoji')}}
                            </label>
                            <input name="emoji" type="text" class="form-control @error('emoji') is-invalid @enderror"  id="emoji" placeholder="{{__('emoji')}}" value="{{old('emoji',$item->emoji??null)}}"  maxlength="4" />
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="flag" >
                                {{__('Image')}}
                            </label>
                            <input name="img" type="file" class="form-control @error('img') is-invalid @enderror"  id="flag" placeholder="{{__('Flag')}}"   />
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <div class="form-check form-switch mt-1">
                            <br>
                            <input class="form-check-input   @error('rtl') is-invalid @enderror"
                                   name="rtl" type="checkbox" id="rtl" @if(old('rtl',$item->rtl??null) == 1) checked="" @endif
                                   value="1" >
                            <label for="rtl">
                                {{__('RTL')}}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <div class="form-check form-switch mt-1">
                            <br>
                            <input class="form-check-input   @error('is_default') is-invalid @enderror"
                                   name="is_default" type="checkbox" id="is_default" @if(old('is_default',$item->is_default??null) == 1) checked="" @endif
                                   value="1" >
                            <label for="is_default">
                                {{__('Default')}}
                            </label>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <label> &nbsp; </label>
                        <input name=""  id="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"   />
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
