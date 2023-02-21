@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Menus preview")}} {{$menu->name}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("Menus preview")}} {{$menu->name}}
        </h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    {!!\Xmen\StarterKit\Helpers\showMenuMange($menu->menuItems()->whereNull('parent')->orderBy('sort')->get())!!}

                </ul>
            </div>
        </nav>
    </div>
@endsection
