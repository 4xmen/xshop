@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    @if (isset($clip))
        {{__("Edit clip")}} {{$clip->title}}
    @else
        {{__("Create clip")}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if (isset($clip))
                {{__("Edit clip")}} {{$clip->title}}
            @else
                {{__("Create clip")}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        @if(isset($clip) && strlen($clip->file) == 0 )
            <div class="alert alert-danger">
                {{__("clip or cover not uploaded...")}}
            </div>
        @endif
        <form class="" method="post"
              enctype="multipart/form-data"
              @if (isset($clip))
              action="{{route('admin.clip.update',$clip->slug)}}"
              @else
              action="{{route('admin.clip.store')}}"
            @endif
        >
            @csrf

            @if (isset($clip))
                <input type="hidden" name="id" value="{{$clip->id}}"/>
            @endif

            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="title">
                            {{__('Title')}}
                        </label>
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{__('Title')}}" value="{{old('title',$clip->title??null)}}"/>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="body">
                            {{__('Description')}}
                        </label>
                        <textarea name="body" class="ckeditorx form-control @error('body') is-invalid @enderror"
                                  placeholder="{{__('Description')}}">{{old('body',$clip->body??null)}}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            {{__("Tags")}}
                        </div>
                        <div class="card-body">
                            <input type="text" name="tags" class="taggble" @if(isset($clip))
                            value="{{implode(',',$clip->tag_names)}}"
                                @endif>

                        </div>
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
                               @if (old('active',$clip->active??0) != 0)
                               checked
                               @endif
                               class="float-end ml-4 mt-1 form-check-inline @error('active') is-invalid @enderror"
                               value="">
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="cover">
                            {{__('Cover')}}
                        </label>
                        <input name="cover" id="cover" type="file"
                               class="form-control-file @error('cover') is-invalid @enderror"
                               placeholder="{{__('Cover')}}"/>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="clip">
                            {{__('Video clip')}}
                        </label>
                        <input name="clip" id="clip" type="file"
                               class="form-control-file @error('clip') is-invalid @enderror"
                               placeholder="{{__('Video clip')}}"/>
                    </div>
                </div>

                <div class="col-md-12">
                    <label> &nbsp;</label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                </div>
                @if(isset($clip))
                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-header">
                                {{__("preview")}}
                            </div>
                            <div class="row">
                                <div class="col-md-6 p-4">
                                    <img src="{{Storage::url('clips/'.$clip->cover)}}" class="img-fluid" alt="cover">
                                </div>
                                <div class="col-md-6 p-4">
                                    <video src="{{Storage::url('clips/'.$clip->file)}}" controls style="max-width: 100%" ></video>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
@endsection
