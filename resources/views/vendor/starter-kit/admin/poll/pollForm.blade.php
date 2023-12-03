@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    @if (isset($poll))
        {{__("Edit poll")}} {{$poll->title}}
    @else
        {{__("Create poll")}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if (isset($poll))
                {{__("Edit poll")}} {{$poll->title}}
            @else
                {{__("Create poll")}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form class="" method="post"
              @if (isset($poll))
              action="{{route('admin.poll.update',$poll->slug)}}"
              @else
              action="{{route('admin.poll.store')}}"
            @endif
        >
            @csrf

            @if (isset($poll))
                <input type="hidden" name="id" value="{{$poll->id}}"/>
            @endif

            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="title">
                            {{__('Title')}}
                        </label>
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{__('Title')}}" value="{{old('title',$poll->title??null)}}"/>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="body">
                            {{__('Text')}}
                        </label>
                        <textarea name="body" class="ckeditorx form-control @error('body') is-invalid @enderror"
                                  placeholder="{{__('Text')}}">{{old('body',$poll->body??null)}}</textarea>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="chk">
                                {{__("Active")}}
                            </label>
                            <input type="checkbox" id="chk" name="active"
                                   @if (old('active',$poll->active??0) != 0)
                                   checked
                                   @endif
                                   class="float-end ml-4 mt-1 form-check-inline @error('active') is-invalid @enderror"
                                   value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                Options
                            </label>
                            <div id="row-base">
                                @if (isset($poll) || old('options',$poll->options??null) != null)

                                    @foreach(old('options',$poll->opinions??[]) as $op)
                                        <div class="row p-2">
                                            <div class="col-md-11">
                                                @if (isset($op->id))

                                                    <input type="text" class="form-control" name="oldop[{{$op->id}}]"
                                                           value="{{$op->title}}"
                                                           placeholder="options"/>
                                                @else
                                                    <input type="text" class="form-control" name="options[]"
                                                           value="{{$op}}"
                                                           placeholder="options"/>
                                                @endif
                                            </div>
                                            @if (!isset($op->id))
                                                <div class="col-md-1">
                                                    <div class="btn btn-danger rm-row">
                                                        <i class="fa fa-times"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="add-row btn btn-success">
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label> &nbsp;</label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
