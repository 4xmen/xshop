<div id='FarhadSocial'>
    <div id="fari-btn">
        <i class="ri-customer-service-2-fill"></i>
    </div>
    <div id="fari-collapse">
        <a href="tel:{{getSetting('tel')}}" " data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
           data-bs-title="{{__("Phone")}}">
           <i class="ri-phone-line"></i>
        </a>
        @foreach(getSettingsGroup('social_')??[] as $k => $social)
            <a href="{{$social}}" data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
               data-bs-title="{{ucfirst($k)}}">
                <i class="ri-{{$k}}-line"></i>
            </a>
        @endforeach
    </div>
</div>
