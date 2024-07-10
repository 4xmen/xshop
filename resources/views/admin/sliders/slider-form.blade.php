@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit slider")}} [{{$item->id}}]
    @else
        {{__("Add new slider")}}
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
            @if(isset($item))
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-message-3-line"></i>
                        {{__("Preview")}}
                    </h3>
                    <div class="p2 pb-5">
                        <img src="{{$item->imgUrl()}}" data-open-file="#cover" class="img-fluid" alt="image">
                    </div>
                </div>
            @endif
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-message-3-line"></i>
                    {{__("Slider data")}}
                </h3>
                <div class="p2 pb-3">
                    <slider-data @if(isset($item)) :dataz='{{$item->data}}' @endif></slider-data>
                </div>
            </div>
        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit slider")}} [{{$item->id}}]
                    @else
                        {{__("Add new slider")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="body">
                                {{__('Description')}}
                            </label>
                            <textarea name="body" class="ckeditorx form-control @error('body') is-invalid @enderror"
                                      placeholder="{{__('Description')}}">{{old('body',$item->body??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
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
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="cover">
                                {{__('Image')}}
                            </label>
                            <input name="cover" id="cover" type="file"
                                   accept="image/*"
                                   class="form-control @error('cover') is-invalid @enderror"
                                   placeholder="{{__('Image')}}"/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label> &nbsp;</label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
