@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    @if (isset($adv))
        {{__("Edit adv")}} {{$adv->name}}
    @else
        {{__("Create adv")}}
    @endif
    -
@endsection

@section('content')
    <div class="container">
        <h1>
            @if (isset($adv))
                {{__("Edit adv")}} {{$adv->name}}
            @else
                {{__("Create adv")}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form class="" method="post"
              enctype="multipart/form-data"
              @if (isset($adv))
              action="{{route('admin.adv.update',$adv->id)}}"
              @else
              action="{{route('admin.adv.store')}}"
            @endif
        >
            @csrf

            @if (isset($adv))
                <input type="hidden" name="id" value="{{$adv->id}}"/>
            @endif

            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="title">
                            {{__('Title')}}
                        </label>
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('Title')}}" value="{{old('title',$adv->title??null)}}"  />
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="link">
                            {{__('Link')}}
                        </label>
                        <input name="link" type="url" class="form-control @error('link') is-invalid @enderror" placeholder="{{__('Link')}}" value="{{old('link',$adv->link??null)}}"  />
                    </div>
                </div>

                <div class="col-md-3 mt-3">
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="active" value="1"  @if (old('active',$adv->active??0) != 0)
                                checked
                                   @endif type="checkbox" id="active">
                            <label class="form-check-label" for="active">{{__("Active")}}</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="image">
                            {{__('Image')}}
                        </label>
                        <input name="image" type="file" class="form-control-file @error('image') is-invalid @enderror" placeholder="{{__('Image')}}" value="{{old('image',$adv->image??null)}}"  />
                    </div>
                </div>

                <div class="col-md-5 mt-3">
                    <div class="form-group">
                        <label for="max_click">
                            {{__('Max click')}}
                        </label>
                        <input name="max_click" type="number" class="form-control @error('max_click') is-invalid @enderror" placeholder="{{__('Max click')}}" value="{{old('max_click',$adv->max_click??0)}}"  />
                    </div>
                </div>
                <div class="col-md-12">
                    <label> &nbsp; </label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"   />
                </div>
            </div>


        </form>
    </div>
@endsection
