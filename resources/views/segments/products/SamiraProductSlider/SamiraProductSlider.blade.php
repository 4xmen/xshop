<section id='SamiraProductSlider'>
    <div class="{{gfx()['container']}}">
        <div id="samira-container">
            <div id="sam-nxt" class="sld-btn">
                <i class="ri-arrow-right-line"></i>
            </div>
            <div id="sam-prv" class="sld-btn">
                <i class="ri-arrow-left-line"></i>
            </div>
            <div id="samira-slider">

                @foreach(getCategoryProductBySetting($part->area_name . '_' . $part->part.'_category') as $product)
                    <div class="item slider-content">

                        <div class="row">

                            <div class="col-md-8 cloudy">
                                <a href="{{$product->webUrl()}}">
                                    <img src="{{$product->imgUrl()}}" alt="{{$product->name}}" loading="lazy">
                                </a>
                                <img src="{{asset('upload/images/index.SamiraProductSlider.webp')}}" alt="" class="bg">
                                <img src="{{asset('upload/images/circle-3d-minify.svg')}}" alt="" class="circle">
                            </div>
                            <div class="col-md-4">
                                <h4 class="mb-4">
                                    {{$product->name}}
                                </h4>

                                <a href="{{$product->webUrl()}}" class="btn btn-outline-light">
                                    {{__("View product")}}
                                    <i class="ri-arrow-right-circle-fill float-end"></i>
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
