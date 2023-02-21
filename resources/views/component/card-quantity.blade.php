<div class="quantity @if($pro->getPurePriceDef($q->price) == $pro->getPurePrice()) active @endif"
     data-price="{{$pro->getPurePriceDef($q->price)}}"
     data-count="{{$q->count}}">
    <input type="checkbox" name="data[{{$pro->id}}]" value='{{$q}}' @if($pro->getPurePriceDef($q->price) == $pro->getPurePrice()) checked @endif>
    @foreach(\App\Helpers\jsonOrder( $q->data ) as $k => $meta)
        @if($k != 'color' && $k != 'count' && $k != 'price')
            <span>
                {{\App\Helpers\getPropLabel($k)}}
                <b>
{{--                    @if(!is_numeric(\App\Helpers\showMeta($k,$meta)))--}}
                        {!! \App\Helpers\showMeta($k,$meta) !!}
{{--                    @endif--}}
                </b>
           </span>
        @elseif($k == 'color')
            <div style="background: {{$meta}};width: 15px;height: 15px;float: right;margin: 4px;"></div>
        @endif
    @endforeach
    <hr>
    <b>
        {{number_format($pro->getPurePriceDef($q->price))}} {{config('app.currency_type')}}
    </b>

</div>
