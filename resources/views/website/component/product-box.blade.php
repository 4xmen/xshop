{{-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 col-12 p-4">--}}
{{--     <div class="box">--}}
{{--         <div class="fav @if($p->isFav()) liked @endif" data-id="{{$p->slug}}">--}}
{{--             <i class="far fa-heart"></i>--}}
{{--             <i class="fa fa-heart"></i>--}}
{{--         </div>--}}
<div class="card h-100">
    <img src="{{$p->thumbUrl()}}" class="card-img card-img-top" alt="{{$p->name}}" title="{{$p->name}}">
    <div class="card-body">
        <h6 class="card-title">
            {{$p->category->name}}
        </h6>
        <h4 class="card-brand">
            {{$p->name}}
        </h4>
        <p class="card-text">
            {{$p->excerpt}}
        </p>
        <div class="price">
            @if($p->hasDiscount())
                <del>
                    {{$p->price}}
                    {{config('app.currency_type')}}
                </del>
                <h4>
                    {{$p->getPrice()}}
                </h4>
            @else
                <h4
                {{$p->getPrice()}}
                </h4>
            @endif
        </div>
        @if($p->hasDiscount())
        <img class="offer" src="{{asset('images/sale.svg')}}" alt="">
        @endif
    </div>
    <div class="card-footer">
        <div class="text-body-secondary">
            @if($p->stock_quantity ==0)
                ناموجود
            @else
                <div class="button">
                    <a href="product.html">
                        <div class="button-wrapper">
                            <a href="{{route('card.add',$p->slug)}}" class="add-to-card text">
                                <i class="icofont-shopping-cart"></i> &nbsp;
                                افزودن به سبد خرید
                            </a>
                            <span class="icon">
                                <i class="fa fa-basket-shopping"></i>
                            </span>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{--</div>--}}
