<section class='MainCategoriesIcon live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <h1 class="text-center">
            {{getSetting($part->area_name . '_' . $part->part.'_title')}}
        </h1>
        <div class="cat-icon-box">
            <div class="row">
                @foreach(getMainCategory(getSetting($part->area_name . '_' . $part->part.'_limit')) as $category)
                    <div class="col-md">
                        <div class=" l-box">
                            <a class="main-category" href="{{$category->webUrl()}}">
                                <img src="{{$category->svgUrl()}}" alt="{{$category->name}}"
                                     title="{{$category->name}}">
                            </a>
                        </div>
                        <a class="main-category" href="{{$category->webUrl()}}">
                            <h4>
                                {{$category->name}}
                            </h4>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
