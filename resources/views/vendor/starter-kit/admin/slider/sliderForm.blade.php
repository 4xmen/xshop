@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    @if (isset($slider))
        {{__("Edit slider")}} {{$slider->name}}
    @else
        {{__("Create slider")}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if (isset($slider))
                {{__("Edit slider")}} {{$slider->name}}
            @else
                {{__("Create slider")}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        @if(isset($slider) && strlen($slider->image) == 0 )
            <div class="alert alert-danger">
                {{__("slider or cover not uploaded...")}}
            </div>
        @endif
        <form class="" method="post"
              enctype="multipart/form-data"
              @if (isset($slider))
              action="{{route('admin.slider.update',$slider->id)}}"
              @else
              action="{{route('admin.slider.store')}}"
            @endif
        >
            @csrf

            @if (isset($slider))
                <input type="hidden" name="id" value="{{$slider->id}}"/>
            @endif

            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="body">
                            {{__('Description')}}
                        </label>
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror"
                                  placeholder="{{__('Description')}}">{{old('body',$slider->body??null)}}</textarea>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <br>
                        <br>
                        <label for="chk">
                            {{__("Active")}}
                        </label>
                        <input type="checkbox" id="chk" name="active"
                               @if (old('active',$slider->active??0) != 0)
                               checked
                               @endif
                               class="float-left ml-4 mt-1 form-check-inline @error('active') is-invalid @enderror"
                               value="">
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="cover">
                            {{__('Image')}}
                        </label>
                        <input name="cover" id="cover" type="file"
                               class="form-control-file @error('cover') is-invalid @enderror"
                               placeholder="{{__('Image')}}"/>
                    </div>
                </div>

                <div class="col-md-12">
                    <label> &nbsp;</label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                </div>
                @if(isset($slider))
                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                {{__("preview")}}
                            </div>
                            <div class="row">
                                <div class="col-md-12 p-4">
                                    <img src="{{$slider->imgUrl()}}" class="img-fluid" alt="cover">
                                </div>
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
@endsection
