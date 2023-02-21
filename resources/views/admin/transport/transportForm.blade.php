@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($transport))
        {{__('New discount')}}
    @else
        {{__('Edit discount')}}: {{$transport->title}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if(!isset($transport))
                {{__('New transport')}}
            @else
                {{__('Edit transport')}}: {{$transport->title}}
            @endif
        </h1>
        @include('starter-kit::component.err')

        <form enctype="multipart/form-data"  method="post"
              @if(!isset($transport)) action="{{route('admin.transport.store')}}"
              @else  action="{{route('admin.transport.update',$transport->id)}}" @endif>

            @csrf
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="title">
                            {{__('Title')}}
                        </label>
                        <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('Title')}}" value="{{old('title',$transport->title??null)}}"  />
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="price">
                            {{__('Price')}}
                        </label>
                        <input name="price" type="text" class="form-control @error('price') is-invalid @enderror currency" placeholder="{{__('Price')}}" value="{{old('price',$transport->price??null)}}"  />
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="description">
                            {{__('Description')}}
                        </label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="{{__('Description')}}"  >{{old('description',$transport->description??null)}}</textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-3 mr-5">
                    <div class="form-group">
                        <input id="is_default" name="is_default" type="checkbox" class="form-check-input @error('is_default') is-invalid @enderror" @if( isset($transport) && $transport->is_default) checked @endif/>
                        <label class="form-check-label" for="is_default">
                            {{__('Is default')}}
                        </label>
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
@section('content-with-js')
@endsection
