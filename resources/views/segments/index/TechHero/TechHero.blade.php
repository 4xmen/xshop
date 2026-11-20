<section class="tech-hero py-4 TechHero live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}} px-3 px-xl-4">

        @php($products = \App\Models\Product::with('category')->whereIn('category_id',json_decode(getSetting($data->area_name.'_'.$data->part.'_categories')))->where('status',1)->orderByDesc('stock_quantity')->limit(5)->get())
        <div class="row g-3">

            <div class="col-12 col-lg-8">
                <div class='SliderHero'>
                    @foreach($products as $k => $product)
                        <article class="item pro-hero">
                            <div>
                                <span>{{$product->category->name}} / {{$product->name}}</span>
                                <h1>
                                    {{$product->name}}
                                </h1>
                                <p>
                                    {{$product->excerpt}}
                                </p>

                                <p>
                                    {{__("Starting at")}} <strong>{{$product->getPrice()}}</strong>
                                </p>

                                <div>
                                    <a href="{{$product->category->webUrl()}}" class="btn btn-primary rounded-pill">
                                        <i class="ri-arrow-right-up-line"></i>
                                        {{__("Explore Collection")}}
                                    </a>
                                    <a href="{{$product->webUrl()}}" class="btn rounded-pill">
                                        {{__("Discover More")}}
                                    </a>
                                </div>
                            </div>

                            <img src="{{$product->imgUrl()}}" alt="Pulse Sport smartwatch">
                        </article>
                        @if($k == 2)
                            @break
                        @endif
                    @endforeach
                </div>
                <div class="box-v">
                    @foreach($products as $k => $product)
                    <a href="#" class="prevw-item" onclick="window.nextHeroSlider({{$k}})">
                        <img src="{{$product->imgUrl()}}" alt="">
                        <span>
                            <strong>{{$product->name}}</strong>
                            <small>From $249</small>
                        </span>
                    </a>
                    @if($k == 2)
                        @break
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div>
                    <article>
                        <span>{{$products[3]->category->name}}</span>
                        <h2>{{$products[3]->name}}</h2>
                        <p>{{$products[3]->excerpt}}</p>
                        <strong>
                            {{$products[3]->getPrice()}}
                        </strong>
                        <img src="{{$products[3]->imgUrl()}}" alt="{{$products[3]->name}}">
                        <a href="{{$products[3]->webUrl()}}" aria-label="{{$products[3]->name}}">
                            <i class="ri-arrow-up-right-line"></i>
                        </a>
                    </article>

                    <article>
                        <span>{{$products[4]->category->name}}</span>
                        <h2>{{$products[4]->name}}</h2>
                        <p>{{$products[4]->excerpt}}</p>
                        <strong>
                            {{$products[4]->getPrice()}}
                        </strong>
                        <img src="{{$products[4]->imgUrl()}}" alt="{{$products[4]->name}}">
                        <a href="{{$products[4]->webUrl()}}" aria-label="{{$products[4]->name}}">
                            <i class="ri-arrow-up-right-line"></i>
                        </a>
                    </article>
                </div>
            </div>

        </div>

        <div class="row g-3 mt-2">

            @foreach(getPagesSet($data->area_name.'_'.$data->part.'_pages') as $page)
                <div class="col-12 col-sm-6 col-lg-3">
                    <div>
                        <i class="{{$page->icon}}"></i>
                        <p>
                            <a href="{{$page->webUrl()}}">
                                <strong>
                                    {{$page->title}}
                                </strong>
                            </a>
                            <span>{{$page->subtitle}}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

