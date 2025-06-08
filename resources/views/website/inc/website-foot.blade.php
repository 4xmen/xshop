    </div>
    @yield('custom-foot')
    <input type="hidden" id="api-display-url" value="{{route('v1.visitor.display')}}">
    <input type="hidden" id="api-fav-toggle" value="{{route('client.product-fav-toggle','')}}/">
    <input type="hidden" id="api-compare-toggle" value="{{route('client.product-compare-toggle','')}}/">

    @if(auth()->check() && (auth()->user()->hasRole('developer') || auth()->user()->hasRole('admin')))
    <a id="do-edit" data-bs-custom-class="custom-tooltip"
       data-bs-toggle="tooltip" data-bs-placement="auto"
       title="{{__("Customize theme")}}">
        <i class="ri-settings-2-line"></i>
    </a>
    <input type="hidden" id="live-url" value="{{route('admin.setting.live','')}}/">
    @endif
    <div id="live-card-modal">
        <div id="live-card-container">
            <a href="{{ route('client.card') }}" class="btn btn-outline-primary d-block">
                <i class="ri-shopping-bag-2-line"></i>
                {{__("Go to card")}}
            </a>
            <div id="live-card-list">
                @include('components.card-items')
            </div>
        </div>
    </div>
    <div id="live-search-content">
        <div id="live-search-data">
            {{__("You need to type at least 4 characters to perform a search...")}}
        </div>
        <div class="text-center">
            <i class="ri-loader-4-line" id="search-ajax-loader"></i>
        </div>
    </div>
</body>
</html>
