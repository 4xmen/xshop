@extends('admin.adminlayout')
@section('page_title')
    {{__("Languages translate")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')

        <div class="text-center pt-3">
{{--            <div class="card my-3">--}}
{{--                <div class="card-header">--}}
{{--                    {{__("Filter")}}--}}
{{--                </div>--}}
{{--                <form class="card-body text-start">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md">--}}
{{--                            <label for="lang">--}}
{{--                                {{__("Lang")}}--}}
{{--                            </label>--}}
{{--                            <select name="lang" id="lang" class="form-control">--}}
{{--                                <option value=""> {{__("All")}} </option>--}}
{{--                                @foreach($langs as $lang)--}}
{{--                                    @if($lang->is_default == '0')--}}
{{--                                    <option value="{{$lang->id}}">--}}
{{--                                        {{$lang->name}}--}}
{{--                                    </option>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-md">--}}
{{--                            <label for="lang">--}}
{{--                                {{__("Model")}}--}}
{{--                            </label>--}}
{{--                            <select name="lang" id="lang" class="form-control">--}}
{{--                                <option value=""> {{__("All")}} </option>--}}
{{--                                <option value="Product"> {{__("Product")}} </option>--}}
{{--                                <option value="Cat"> {{__("Cat")}} </option>--}}
{{--                                <option value="Post"> {{__("Post")}} </option>--}}
{{--                                <option value="Category"> {{__("Category")}} </option>--}}
{{--                                <option value="Slider"> {{__("Slider")}} </option>--}}
{{--                                <option value="Meta"> {{__("Props")}} </option>--}}
{{--                                <option value="Clip"> {{__("Clip")}} </option>--}}
{{--                                <option value="Gallery"> {{__("Gallery")}} </option>--}}
{{--                                <option value="Menu"> {{__("Menu")}} </option>--}}
{{--                                <option value="Setting"> {{__("Setting")}} </option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
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
                            <a href="{{route('admin.lang.ai',$lang->tag)}}" class="btn btn-outline-success w-100 mt-3 btn-sm">
                                <i class="ri-ai-generate"></i>
                                {{__("Translate with AI")}}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
