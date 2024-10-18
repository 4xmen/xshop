<section class='NataliaCategories'>
    <div class="{{gfx()['container']}}">
        <div class="row nata-content">
            <div class="col-md-6 pt-5 slider-content">
                <h1>
                    {{getSetting($data->area_name.'_'.$data->part.'_title')}}
                </h1>
                <h2>
                    {{getSetting($data->area_name.'_'.$data->part.'_subtitle')}}
                </h2>
                <ul>
                    @foreach(getCategorySubCatsBySetting($data->area_name.'_'.$data->part.'_category') as $category)
                        <li>
                            <a href="{{$category->webUrl()}}">
                                <img src="{{$category->svgUrl()}}" alt="{{$category->name}}" class="mx-2">
                                {{$category->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6 nata-bg"
                 style="background-image: url('{{$bg??asset('upload/images/'.$part->area_name . '.' . $part->part.'.webp')}}')">
                <img src="{{asset('upload/images/'.$part->area_name . '.' . $part->part.'.webp')}}" alt="">
            </div>
        </div>
    </div>
</section>
