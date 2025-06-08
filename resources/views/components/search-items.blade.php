@if(count($products) == 0)
    <li>
        {{__("There is nothing to show!")}}
    </li>
@else
@foreach($products as $product)
    <li>
        <a class="product-search-item" href="{{$product->webUrl()}}">
            <img src="{{$product->imgUrl()}}" alt="{{$product->name}}">
            <div class="product-search-content">
                <h3>
                    {{$product->name}}
                </h3>
                <span>
                    {{$product->getPrice()}}
                </span>
            </div>
        </a>

    </li>
@endforeach
@endif
