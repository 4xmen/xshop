@extends('admin.adminlayout')
@section('page_title')
    {{__("Languages translate")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')

        <div class="text-center pt-3">
            <div class="row">
                @foreach($langs as $lang)
                    <div class="col-md-4">
                        <div class="lang-item">
                            <h5>
                                {{$lang->name}}
                            </h5>
                            <a href="{{route('admin.lang.download',$lang->tag)}}" class="btn btn-outline-dark w-100 mb-3 btn-sm">
                                <i class="ri-download-2-line"></i>
                                {{__("Download json file")}}
                            </a>
                            <form action="{{route('admin.lang.upload',$lang->tag)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="json" id="file" class="form-control">
                                <button class="btn btn-outline-primary btn-sm w-100 mt-2">
                                    <i class="ri-upload-2-line"></i>
                                    {{__("Upload file")}}
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
