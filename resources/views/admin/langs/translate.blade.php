@extends('admin.adminlayout')
@section('page_title')
    {{__("Translate model")}}: {{($model->{$translates[0]})}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')

        <h3>
            {{__("Translate model")}}: {{($model->{$translates[0]})}}
        </h3>

        <h4 class="lang-support">
            {{__("Main language content")}}:({{config('app.xlang_main')}})
        </h4>
        <table class="table table-bordered">
            <tr>
                <th>
                    {{__("Title")}}
                </th>
                <th>
                    {{__("Value")}}
                </th>
            </tr>
            @foreach($translates as $tr)
                <tr>
                    <th>
                        {{$tr}}
                    </th>
                    <th>
                        {{($model->{$tr})}}
                    </th>
                </tr>
            @endforeach
        </table>


        <form action="{{route( 'admin.lang.modelSave',[$model->id,$cls])}}" method="post">
            @csrf
            @foreach($langs as $lang)
                <h4 class="lang-support">
                    {{__("Translate model")}}: {{$lang->name}} ({{$lang->tag}})
                </h4>
                @foreach($translates as $tr)
                    <div class="form-group mt-2">
                        <label for="{{$lang->tag}}{{$tr}}">
                            {{$tr}}:
                        </label>
                        <div class="row">
                            <div class="col-md-10">

                                @if( $tr == 'body' || $tr == 'desc' || $tr == 'description' || $tr == 'excerpt' )

                                    <textarea
                                        class="form-control @if($tr == 'body' || $tr == 'desc' || $tr == 'description' ) ckeditorx @endif"
                                        rows="4" id="{{$lang->tag}}{{$tr}}"
                                        name="data[{{$lang->tag}}][{{$tr}}]">{{gettype($model->getTranslation($tr,$lang->tag)) == 'string' ? $model->getTranslation($tr,$lang->tag):'' }}</textarea>
                                @else
                                    <input type="text" id="{{$lang->tag}}{{$tr}}" name="data[{{$lang->tag}}][{{$tr}}]"
                                           value="{{gettype($model->getTranslation($tr,$lang->tag)) == 'string' ? $model->getTranslation($tr,$lang->tag):'' }}"
                                           placeholder="" class="form-control">
                                @endif
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <a href="{{route('admin.lang.aiText',[$model->id,$cls,$lang->tag,$tr])}}" class="btn-ai" title="{{__("AI translate form original source")}}">
                                    <i class="ri-translate"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
            <button class="btn btn-outline-dark w-100 my-3">
                {{__("Save")}}
            </button>
        </form>


    </div>
@endsection
