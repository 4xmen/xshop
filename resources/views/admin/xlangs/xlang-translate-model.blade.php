@extends('layouts.app')
@section('title')
    {{__("Translate model")}}: {{($model->{$translates[0]})}}
    -
@endsection
@section('content')

    @include('components.err')


    <div class="general-form mb-3">

        <h1>
            {{__("Translate model")}}: {{($model->{$translates[0]})}}
        </h1>

        <h4 class="lang-support p-3">
            {{__("Main language content")}}:({{config('app.xlang.main')}})
        </h4>
        <div class="p-3">
            <table class="table">
                <tr>
                    <th class="w-25">
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
                        <td>
                            {{($model->{$tr})}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>

    <form action="{{route( 'admin.lang.modelSave',[$model->id,$cls])}}" method="post">

        @csrf
        @foreach($langs as $lang)
            <div class="general-form mb-3">
                <h1 class="lang-support">
                    {{__("Translate model")}}: {{$lang->name}} ({{$lang->tag}})
                </h1>
                @foreach($translates as $tr)
                    <div class="form-group px-3 pt-2">
                        <label for="{{$lang->tag}}{{$tr}}">
                            {{$tr}}:
                        </label>
                        <div class="row">
                            <div class="col-md-10">

                                @if( $tr == 'body' || $tr == 'desc' || $tr == 'description' || $tr == 'excerpt' || $tr == 'table' || request()->has('editor'))

                                    <textarea
                                        @if(langIsRTL($lang->tag)) dir="rtl" @else dir="ltr" @endif
                                    class="form-control @if($tr == 'body' || $tr == 'desc' || $tr == 'description' || $tr == 'table' || request()->has('editor')) ckeditorx @endif"
                                        rows="4" id="{{$lang->tag}}{{$tr}}"
                                        name="data[{{$lang->tag}}][{{$tr}}]">{{gettype($model->getTranslation($tr,$lang->tag)) == 'string' ? $model->getTranslation($tr,$lang->tag):'' }}</textarea>
                                @else
                                    <input @if(langIsRTL($lang->tag)) dir="rtl" @else dir="ltr" @endif type="text"
                                           id="{{$lang->tag}}{{$tr}}" name="data[{{$lang->tag}}][{{$tr}}]"
                                           value="{{gettype($model->getTranslation($tr,$lang->tag)) == 'string' ? $model->getTranslation($tr,$lang->tag):'' }}"
                                           placeholder="" class="form-control">
                                @endif
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <a href="{{route('admin.lang.aiText',[$model->id,$cls,$lang->tag,$tr])}}" class="btn-ai"
                                   title="{{__("AI translate form original source")}}">
                                    <i class="ri-translate"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button class="btn btn-outline-dark w-100 my-3">
            {{__("Save")}}
        </button>
    </form>

@endsection
