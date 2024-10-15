<section class='MainCategoriesSlider'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <div id="main-cats">
            @foreach(\App\Models\Category::whereNull('parent_id')->limit(10)->get() as $category)
                <div class="item slider-content">
                    <a class="main-category" href="{{$category->webUrl()}}">
                        <img src="{{$category->imgUrl()}}" alt="{{$category->name}}" title="{{$category->name}}" >
                        <h4>
                            {{$category->name}}
                        </h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
