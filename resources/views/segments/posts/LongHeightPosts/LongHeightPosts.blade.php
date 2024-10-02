<section class='LongHeightPosts'
         style="background-image: url('{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}')">
    <div class="{{gfx()['container']}}">
        <h1>
            <a href="{{getGroupBySetting($data->area_name.'_'.$data->part.'_group')->webUrl()}}">
                {{getGroupBySetting($data->area_name.'_'.$data->part.'_group')->name}}
            </a>
        </h1>


        <div class="row">
            @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group',4) as $post )
                <div class="col-lg-3 col-md-6">
                    <div class="post-height-img-item" style="background-image: url('{{$post->imgUrl()}}')">
                        <a class="post-height-img-detail" href="{{$post->webUrl()}}">

                            <h4>
                                {{$post->title}}
                            </h4>
                            <p>
                                {{$post->subtitle}}
                            </p>

                        </a>
                    </div>
                </div>

            @endforeach
        </div>

        <h3>
            <a href="" class="btn btn-outline-primary float-end">
                {{getSetting($data->area_name.'_'.$data->part.'_btn')}}
            </a>
            {{getGroupBySetting($data->area_name.'_'.$data->part.'_group')->subtitle}}
        </h3>
    </div>
</section>
