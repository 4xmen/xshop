@extends('website.layout')
@section('title')
    کدهای رهگیری -
@endsection
@section('body-class')  @endsection
@section('content')
    <div id="main-conetent">
        <div class="container p-5 text-center">
            {!! \App\Helpers\getSetting('post') !!}
            <ul class="list-group">
                @foreach($attaches as $a)
                    <li class="list-group-item" style="border-bottom: 1px solid crimson">
                        <a href="{{url('/')}}{{$a->file}}" target="_blank" class="d-block">
                            <h4 class="mt-2">
                                {{$a->title}}
                            </h4>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
