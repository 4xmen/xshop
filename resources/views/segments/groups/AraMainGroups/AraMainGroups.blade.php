<section class='AraMainGroups'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area->name.'_'.$data->part.'_title')}}
        </h1>
        <p>
            {{getGroupBySetting($data->area->name.'_'.$data->part.'_group')->subtitle}}
        </p>
        <div class="ara-row">
            @foreach(getSubGroupSetting($data->area->name.'_'.$data->part.'_group') as $group)
                <div class="ara-group">
                    <a href="{{$group->webUrl()}}">

                        <img src="{{$group->imgUrl()}}" class="img-fluid" alt="">
                        <div class="ara-data">
                            <h3>
                                {{$group->name}}
                            </h3>
                            <p>
                                {{$group->subtitle}}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-3 text-center">
            <a href="{{getGroupBySetting($data->area->name.'_'.$data->part.'_group')->webUrl()}}" class="btn btn-outline-primary">
                {{getSetting($data->area->name.'_'.$data->part.'_title')}}
            </a>
        </div>
    </div>
</section>
