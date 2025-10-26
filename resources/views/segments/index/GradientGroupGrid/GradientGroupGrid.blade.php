<section class="GradientGroupGrid live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <p>
            {{getSetting($data->area_name.'_'.$data->part.'_subtitle')}}
        </p>
        <div class="row">
            @foreach(getSubGroupSetting($part->area_name . '_' . $part->part.'_group') as $group)
                <div class="col-lg-6 col-md-12">
                    <div class="group-gradient-item">
                        <div class="row">
                            <div class="col-4 gg-img-container">
                                <a href="{{$group->webUrl()}}">
                                    <img src="{{$group->imgUrl()}}" class="float-end" alt="{{$group->name}}">
                                </a>
                            </div>
                            <div class="col-8">
                                <h3>
                                    {{$group->name}}
                                </h3>
                                <p>
                                    {{$group->subtitle}}
                                </p>
                                <a href="{{$group->webUrl()}}">
                                    {{getSetting($data->area_name.'_'.$data->part.'_btn')}}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
