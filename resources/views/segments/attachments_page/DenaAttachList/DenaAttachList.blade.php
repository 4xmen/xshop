<section class='DenaAttachList content'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <p class="text-muted">
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </p>

        <div id="dena-list">
            @foreach($attachs as $attach)
                <div class="dena-item">
                    <span class="dena-tag">
                        {{$attach->ext}}
                    </span>
                    <span class="dena-size">
                        {{formatFileSize($attach->size)}}
                    </span>
                    <h3>
                        <a href="{{$attach->webUrl()}}">
                        {{$attach->title}}
                        </a>
                    </h3>
                    <p class="text-muted">
                        {{$attach->subtitle}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
