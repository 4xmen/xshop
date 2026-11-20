<section class="SupporterBox live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="support row">
            <div class="support-left col-lg-5">
                <div class="support-status">
                    <span class="support-dot"></span>
                    {{getSetting($data->area_name.'_'.$data->part.'_title')}}
                </div>
                {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
            </div>

            <div class="support-grid col-lg-8">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{getSetting($data->area_name.'_'.$data->part.'_link1')}}" class="support-card ">
                            <div class="support-icon">
                                <i class="ri-chat-1-line"></i>
                            </div>
                            <div class="support-text">
                                <strong>{{getSetting($data->area_name.'_'.$data->part.'_title1')}}</strong>
                                <span>{{getSetting($data->area_name.'_'.$data->part.'_subtitle1')}}</span>
                            </div>
                            <i class="ri-arrow-right-up-line support-arrow"></i>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{getSetting($data->area_name.'_'.$data->part.'_link2')}}"
                           class="support-card  col-md-6">
                            <div class="support-icon">
                                <i class="ri-info-card-line"></i>
                            </div>
                            <div class="support-text">
                                <strong>{{getSetting($data->area_name.'_'.$data->part.'_title2')}}</strong>
                                <span>{{getSetting($data->area_name.'_'.$data->part.'_subtitle2')}}</span>
                            </div>
                            <i class="ri-arrow-right-up-line support-arrow"></i>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="tel:{{getSetting('tel')}}" class="support-card  col-md-6">
                            <div class="support-icon">
                                <i class="ri-phone-line"></i>
                            </div>
                            <div class="support-text">
                                <strong>{{getSetting('tel')}}</strong>
                                <span>{{getSetting($data->area_name.'_'.$data->part.'_subtitle3')}}</span>
                            </div>
                            <i class="ri-arrow-right-up-line support-arrow"></i>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="mailto:{{getSetting('email')}}" class="support-card  col-md-6">
                            <div class="support-icon">
                                <i class="ri-mail-line"></i>
                            </div>
                            <div class="support-text">
                                <strong>{{getSetting('email')}}</strong>
                                <span>{{getSetting($data->area_name.'_'.$data->part.'_subtitle3')}}</span>
                            </div>
                            <i class="ri-arrow-right-up-line support-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
