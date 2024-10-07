@php($productFav = getCategoryProductBySetting($data->area_name.'_'.$data->part,1) )
@if(count($productFav) > 0)
<section class="FavProductWithMeta py-5">
    <div class="{{gfx()['container']}}">
        <h4 class="text-center text-muted">
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h4>
        <h1 class="text-center my-2">
            {{$productFav[0]->name}}
        </h1>
        <div class="row">
            @foreach($productFav[0]->fullMeta(4) as $meta)

                <div class="col-md text-center">
                    <i class="{{$meta['data']['icon']}}"></i>
                    <h5>
                        {{$meta['data']['label']}}
                    </h5>
                    <p>
                        {!! $meta['human_value'] !!}
                    </p>
                </div>
            @endforeach
            <div class="col-12">
                <img src="{{$productFav[0]->originalOptimizedImageUrl()}}" class="img-fluid" alt=" {{$productFav[0]->name}}" loading="lazy">
            </div>
        </div>
    </div>
</section>
@endif
