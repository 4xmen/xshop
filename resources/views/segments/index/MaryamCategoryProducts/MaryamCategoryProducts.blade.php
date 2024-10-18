<section class='MaryamCategoryProducts'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>

        <div class="maryam-row">
            @foreach(getCategoryProductBySetting($part->area_name . '_' . $part->part.'_category',12) as $product)
                <a class="maryam-item" href="{{$product->webUrl()}}">
                    <img src="{{$product->imgUrl()}}" alt="{{$product->name}}" class="img-fluid" loading="lazy">
                </a>
            @endforeach
        </div>
    </div>
</section>
