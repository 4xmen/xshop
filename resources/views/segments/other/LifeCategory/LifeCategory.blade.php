<section class="LifeCategory live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="row">
            @foreach(getCategoriesSet($data->area_name.'_'.$data->part.'_categories') as $category)
                <div class="col-lg">
                    <div class="life-grid-item">
                        <a href="{{$category->webUrl()}}">
                            <img src="{{$category->imgUrl()}}" alt="{{$category->name}}">
                            <div class="life-content">
                                <span class="badge bg-danger d-inline-block m-2">
                                    {{__("Products")}}: {{number_format($category->products->count())}}
                                </span>
                                <h2>
                                    {{$category->name}}
                                </h2>
                                <span class="more">
                                    <i class="ri-arrow-right-up-line"></i>
                                    {{__("Detail")}}
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
