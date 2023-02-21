<div class="box">
    <div class="fav @if($p->isFav()) liked @endif" data-id="{{$p->slug}}">
        <i class="far fa-heart"></i>
        <i class="fa fa-heart"></i>
    </div>
    @if($p->hasDiscount())
        <div class="ribbon">
            <span class="ribbon1"><span>10%</span></span>
        </div>
    @endif
    <a href="{{route('product',$p->slug)}}">
        <img src="{{$p->thumbUrl()}}" class="img-fluid" alt="{{$p->name}}" title="{{$p->name}}">
    </a>
    <a href="{{route('product',$p->slug)}}">
        <h4>
            {{$p->name}}
        </h4>
        <h5>
            کد محصول:
           {{$p->getCode()}}
        </h5>
        @if(!$p->hasDiscount())
            @if($p->stock_quantity == 0)
                <b class="text-danger d-block text-center p-2">
                    ناموجود
                </b>
            @else
                <b class="d-block text-center p-2">
                    {{$p->getPrice()}}
                </b>
            @endif

        @else
            @if($p->stock_quantity != 0)

                <div class="row text-center p-3">
                    <div class="col-md">
                        <del>
                            {{$p->price}}
                            {{config('app.currency_type')}}
                        </del>
                    </div>
                    <div class="col-md">

                        <b> {{$p->getPrice()}}</b>
                    </div>
                </div>
            @else
                <b class="text-danger d-block text-center">
                    ناموجود
                </b>
            @endif
        @endif
    </a>
    @if($p->stock_quantity > 0)
        <div class="pb-3 text-center">
            <a href="{{route('card.add',$p->slug)}}" class="add-to-card btn btn-primary">
                <i class="icofont-shopping-cart"></i> &nbsp;
                افزودن به سبد خرید
            </a>
        </div>
    @endif
</div>
