@extends('starter-kit::layouts.adminlayout')
@section('page_title')
  @if(!isset($gallery))
    {{__('New Gallery')}}
  @else
    {{__('Edit Post')}}: {{$gallery->title}}
  @endif
  -
@endsection
@section('content')
  <div class="container">

    <h1>
      @if(!isset($gallery))
        {{__('New Gallery')}}
      @else
        {{__('Edit Post')}}: {{$gallery->title}}
      @endif
    </h1>
    @include('starter-kit::component.err')

    <form enctype="multipart/form-data" class="row" method="post"
          @if(!isset($gallery)) action="{{route('admin.gallery.store')}}"
          @else  action="{{route('admin.gallery.update',$gallery->slug)}}" @endif>
      @csrf

      <div class="col-md-9">
        <div class="row">
          <div class="col-md-12 mt-3">
            <div class="form-group">
              <label for="title">
                {{__('Title')}}
              </label>
              <input name="title" type="text" id="title" class="form-control @error('title') is-invalid @enderror"
                     placeholder="{{__('Title')}}" value="{{old('title',$gallery->title??null)}}"/>
            </div>
          </div>
          <div class="col-md-12 mt-3">
            <div class="form-group">
              <label for="description">
                {{__('Description')}}
              </label>
              <textarea id="description" name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="{{__('Description')}}"
                        rows="3">{{old('description',$gallery->description??null)}}</textarea>
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
                        @if (old('status',$gallery->status??null) == '1' ) selected @endif >{{__("Published")}} </option>
                <option value="0"
                        @if (old('status',$gallery->status??null) == '0' ) selected @endif >{{__("Draft")}} </option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mt-3">
            <div class="form-group">
              <label for="image">
                {{__('Index image')}}
              </label>
              <input name="image" type="file" class="form-control-file @error('image') is-invalid @enderror"
                     placeholder="{{__('Index image')}}" value="{{old('image',$gallery->image??null)}}"/>
            </div>
          </div>
          <div class="col-md-12">
            <label> &nbsp; </label>
            <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        @if (isset($gallery))
          <div class="card mb-3">
            <div class="card-header">
              {{__("Index image")}}
            </div>
            <div class="card-body">
              <img src="{{$gallery->imgurl()}}" class="img-fluid" alt="{{$gallery->title}}">
            </div>
          </div>
        @endif
      </div>
    </form>

    @if (isset($gallery))
      <div class="card mt-3">
        <div class="card-header">
          {{__("Images")}}
        </div>
        <div class="card-body">
          <form action="{{route('admin.gallery.updatetitle',$gallery->slug)}}" method="post">
            @csrf
              <div class="row">

            @foreach($gallery->images as $img)
              <div class="col-md-3">
                <a href="{{route('admin.image.delete',$img->id)}}" class="del-conf">
                  <i class="fa fa-times"></i>
                </a>
                <img src="{{$img->imgUrl()}}" class="img-squire" alt="">
                  <div class="row">
                      <div class="col-md-9">
                          <input type="text" class="form-control" name="titles[{{$img->id}}]" value="{{$img->title}}"/>
                      </div>
                      <div class="col-md-3">
                          @if(config('app.xlang'))
                              <a href="{{route('admin.lang.model',[$img->id,\Xmen\StarterKit\Models\Image::class])}}"
                                 class="btn btn-outline-dark translat-btn">
                                  <i class="ri-translate"></i>
                              </a>
                          @endif
                      </div>
                  </div>
              </div>
            @endforeach
              </div>
            <br>
            <input type="submit"  class="btn btn-primary" value="{{__("Save")}}"/>
          </form>
        </div>
      </div>
      <form class="card mt-3" method="post" enctype="multipart/form-data"
            action="{{route('admin.image.store',$gallery->slug)}}">
        @csrf
        <div class="card-header">
          {{__("Upload new images")}}
        </div>
        <div class="card-body">
          <input type="file" name="image[]" multiple accept="image/*" id="gallery_images"/>
        </div>
        <ul id="newimgs">

        </ul>
        <input type="submit" class="btn btn-dark" value="{{__("Upload images")}}"/>

      </form>
    @endif

  </div>
@endsection
