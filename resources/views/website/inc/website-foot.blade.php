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

</body>
</html>
