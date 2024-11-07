@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit adv")}} [{{$item->title}}]
    @else
        {{__("Add new adv")}}
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
                        {{__("Max click zero is unlimited")}}
                    </li>
                    <li>
                        {{__("If not choose expire expire time will be unlimited")}}
                    </li>
                </ul>
            </div>
            @if (isset($item))
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-image-2-line"></i>
                        {{__("Image")}}
                    </h3>
                    <div class="pb-4">
                        <img src="{{$item->imgUrl()}}" class="img-fluid" alt="{{$item->title}}">
                    </div>
                </div>
            @endif

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit adv")}} [{{$item->title}}]
                    @else
                        {{__("Add new adv")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('Title')}}" value="{{old('title',$item->title??null)}}"  />
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="link">
                                {{__('Link')}}
                            </label>
                            <input name="link" type="url" class="form-control @error('link') is-invalid @enderror" placeholder="{{__('Link')}}" value="{{old('link',$item->link??null)}}"  />
                        </div>
                    </div>

                    <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label for="status">
                                    {{__('Status')}}
                                </label>
                                <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                    <option value="1"
                                            @if (old('status',$item->status??null) == '1' ) selected @endif >{{__("Published")}} </option>
                                    <option value="0"
                                            @if (old('status',$item->status??null) == '0' ) selected @endif >{{__("Draft")}} </option>
                                </select>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="image">
                                {{__('Image')}}
                            </label>
                            <input name="image" type="file" class="form-control @error('image') is-invalid @enderror" placeholder="{{__('Image')}}"  accept="image/*" />
                        </div>
                    </div>

                    <div class="col-md-5 mt-3">
                        <div class="form-group">
                            <label for="max_click">
                                {{__('Max click')}}
                            </label>
                            <input name="max_click" type="number" class="form-control @error('max_click') is-invalid @enderror" placeholder="{{__('Max click')}}" value="{{old('max_click',$item->max_click??0)}}"  />
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <label for="dp">
                            {{__("Expire")}}
                        </label>
{{--  WIP for lang change def tab--}}
                        <vue-datetime-picker-input :xmin="{{strtotime('yesterday')}}"
                        xid="dp" xname="expire" xtitle="Expire date"  @if(app()->getLocale() != 'fa')  def-tab="1" xshow="date"  @else xshow="pdate"  @endif
                        @if(isset($item)) :xvalue="{{strtotime($item->expire)}}" @endif
                        ></vue-datetime-picker-input>
                    </div>
                    <div class="col-md-12">
                        <label> &nbsp; </label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"   />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
