@include('components.panel-header')
<div id="panel-preloader">
    <div class="loader"></div>
</div>
<input type="hidden" id="panel-dir" @if(langIsRTL(config('app.locale'))) value="rtl" @else value="ltr" @endif>
<form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="container pt-3" id="app">

        @include('components.err')
        @if(count($settings) == 0)
            <h3 class="text-center pt-2">
                {{__("There is nothing to show!")}}
            </h3>
        @else
            <div class="row">
                @foreach($settings as $setting)
                    @include('components.setting-field')
                @endforeach
            </div>
        @endif
    </div>
    <button class="action-btn circle-btn"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Save all settings")}}"
    >
        <i class="ri-save-2-line"></i>
    </button>


    @if(config('app.env') == 'production')
    <button
        href="{{getRoute('sort')}}"
        class="action-btn circle-btn"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        data-bs-custom-class="custom-tooltip"
        data-bs-title="{{__("Save and build")}}"
        name="build"
        value="1"
        style="inset-inline-end: 1.2rem;inset-inline-start: auto;"
    >
        <i class="ri-hammer-line"></i>
    </button>
    @endif
</form>
@include('components.panel-footer')
