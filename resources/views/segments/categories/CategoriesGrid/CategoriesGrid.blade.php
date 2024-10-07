<section class='CategoriesGrid'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <div class="row cat-grid-list">
            @foreach( getCategorySubCatsBySetting($data->area_name.'_'.$data->part.'_category',getSetting($data->area_name.'_'.$data->part.'_limit')) as $category )
                <div class="col-md p-0">
                    <div class="cat-grid-item">
                        <a href="{{$category->webUrl()}}">
                            <img src="{{$category->imgUrl()}}" alt="{{$category->name}}"
                                 title="{{$category->name}}" loading="lazy" >
                            <h3 class="py-3">
                                {{$category->name}}
                            </h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
