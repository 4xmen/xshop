@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($xlang))
        {{__('New language')}}
    @else
        {{__('Edit language')}}: {{$xlang->title}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if(!isset($xlang))
                {{__('New language')}}
            @else
                {{__('Edit language')}}: {{$xlang->name}}
                <img src="{{$xlang->imgUrl()}}" alt="{{$xlang->name}}" class="x64 float-end">
            @endif
        </h1>
        @include('starter-kit::component.err')

        <form enctype="multipart/form-data" method="post"
              @if(!isset($xlang)) action="{{route('admin.lang.store')}}"
              @else  action="{{route('admin.lang.update',$xlang->id)}}" @endif>

            @csrf
            <div class="row">
                <div class="col-md-8 mt-3">
                    <div class="form-group">
                        <label for="name" >
                            {{__('Name')}}
                        </label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="{{__('Name')}}" value="{{old('name',$xlang->name??null)}}"  />
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="tag" >
                            {{__('Tag')}}
                        </label>
                        <input name="tag" type="text" class="form-control @error('tag') is-invalid @enderror"  id="tag" placeholder="{{__('Tag')}}" value="{{old('tag',$xlang->tag??null)}}"  maxlength="7" />
                    </div>
                </div>
                <div class="col-md-8 mt-3">
                    <div class="form-group">
                        <label for="flag" >
                            {{__('Flag')}}
                        </label>
                        <input name="img" type="file" class="form-control @error('img') is-invalid @enderror"  id="flag" placeholder="{{__('Flag')}}" value="{{old('img',$xlang->img??null)}}"  />
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <div class="form-check form-switch mt-1">
                        <br>
                        <input class="form-check-input   @error('rtl') is-invalid @enderror"
                               name="rtl" type="checkbox" id="rtl" @if(old('rtl',$xlang->rtl??null) == 1) checked="" @endif
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
                               name="is_default" type="checkbox" id="is_default" @if(old('is_default',$xlang->is_default??null) == 1) checked="" @endif
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


        </form>
    </div>
@endsection
@section('content-with-js')
@endsection
