<section class="ContactSummery live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="row pt-4">
            <div class="col-md-6">
                <img src="{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}" class="img-fluid"
                     alt="{{getSetting($data->area_name.'_'.$data->part.'_title')}}">
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div>
                    <h1>
                        {{getSetting($data->area_name.'_'.$data->part.'_title')}}
                    </h1>
                    {!!  getSetting($data->area_name.'_'.$data->part.'_subtitle') !!}
                </div>
            </div>
            <div class="col-12 summery-detail">
                <h2 class="pt-4">
                    {{__("Contact us")}}
                </h2>
                <ul>
                    <li>
                        <a href="{{getSetting($data->area_name.'_'.$data->part.'_address_link')}}">
                            <i class="ri-map-pin-line float-start"></i>
                            {{getSetting($data->area_name.'_'.$data->part.'_address')}}
                        </a>
                    </li>
                    <li>
                        <a href="tel:{{getSetting('tel')}}" dir="ltr">
                            <i class="ri-phone-line float-start"></i>
                            {{getSetting('tel')}}
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{getSetting('email')}}" dir="ltr">
                            <i class="ri-mail-line float-start"></i>
                           {{getSetting('email')}}
                        </a>
                    </li>
                </ul>
                <a href="{{getSetting($data->area_name.'_'.$data->part.'_link')}}" class="btn btn-primary">
                    {{getSetting($data->area_name.'_'.$data->part.'_btn')}}
                </a>
            </div>
        </div>
    </div>
</section>
