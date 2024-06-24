@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit transport")}} [{{$item->title}}]
    @else
        {{__("Add new transport")}}
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

            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-remixicon-line"></i>
                    {{__("Icon")}}
                </h3>
                <div class="p-1 text-center pb-4">
                    <remix-icon-picker xname="icon" xvalue="{{old('icon',$item->icon??null)}}"></remix-icon-picker>
                </div>
            </div>

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit transport")}} [{{$item->title}}]
                    @else
                        {{__("Add new transport")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" id="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('Title')}}" value="{{old('title',$item->title??null)}}"  />
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="price">
                                {{__('Price')}}
                            </label>
                            <currency-input xname="price" xid="price" @error('price')
                            :err="true" @enderror :xvalue="{{old('price',$item->price??null)}}"></currency-input>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="description">
                                {{__('Description')}}
                            </label>
                            <textarea id="description"  name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="{{__('Description')}}"   >{{old('description',$item->description??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 mr-5">
                        <div class="form-group">

                            <div class="form-check form-switch">
                                <input value="1" class="form-check-input  @error('is_default') is-invalid @enderror" name="is_default" @if( isset($item) && $item->is_default) checked @endif type="checkbox" id="is_default">
                                <label class="form-check-label" for="is_default"> {{__('Is default')}}</label>
                            </div>
                        </div>


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
