@extends('layouts.app')
@section('title')
    {{__("Reply comment")}} -
@endsection
@section('content')
    <form action="{{route('admin.comment.replying',$item->id)}}" method="post">
        @csrf

        <div>
            <div class="general-form ">

                <h4 class="p-3">
                    <i class="ri-message-2-line"></i>
                    {{$item->body}}
                </h4>

                <input type="hidden" id="{{$item->id}}" name="id">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="body" >
                                {{__('Message replay')}}
                            </label>
                            <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" placeholder="{{__('Message')}}"  >{{old('body')}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <label> &nbsp; </label>
                        <input  type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"   />
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
