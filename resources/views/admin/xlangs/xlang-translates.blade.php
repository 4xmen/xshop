@extends('layouts.app')
@section('content')

    @include('components.err')

    <div class="row">
        @foreach($langs as $lang)

            <div class="col-md-4 mb-4">
                <div class="item-list p-3">
                    <h5 class="text-center">
                        {{$lang->name}} [ {{$lang->emoji}} ]
                    </h5>
                    <img src="{{$lang->imgUrl()}}" class="img-fluid my-3" alt="{{$lang->tag}}">
                    @if($lang->tag != 'en')

                        <a href="{{route('admin.lang.download',$lang->tag)}}"
                           class="btn btn-outline-light w-100 mb-3 btn-sm">
                            <i class="ri-download-2-line"></i>
                            {{__("Download json file")}}
                        </a>
                    @else
                        <a class="btn btn-outline-light w-100 mb-3 btn-sm disabled">
                            <i class="ri-download-2-line"></i>
                            {{__("Download json file")}}
                        </a>
                    @endif
                    <form action="{{route('admin.lang.upload',$lang->tag)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="json" id="file" class="form-control mb-2">
                        <button class="btn btn-outline-primary btn-sm w-100 mt-2 " @if($lang->tag == 'en') disabled @endif>
                            <i class="ri-upload-2-line"></i>
                            {{__("Upload file")}}
                        </button>
                    </form>
                    <a  @if($lang->tag != 'en')   href="{{route('admin.lang.ai',$lang->tag)}}" @endif class="btn btn-outline-success w-100 mt-3 btn-sm ">
                        <i class="ri-ai-generate"></i>
                        {{__("Translate with AI")}}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
