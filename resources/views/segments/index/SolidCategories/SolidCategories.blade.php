<section class="SolidCategories live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="solid-grid-container">
        @foreach(getCategoriesSet($data->area_name.'_'.$data->part.'_categories') as $category)
            <div class="solid-grid-item">
                <a href="{{$category->webUrl()}}">
                    <img src="{{$category->imgUrl()}}" alt="{{$category->name}}">
                </a>
                <h2>
                    {{$category->name}}
                </h2>
            </div>
        @endforeach

    </div>
</section>
