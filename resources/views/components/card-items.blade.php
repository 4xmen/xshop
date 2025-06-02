@foreach(\App\Models\Product::whereIn('id', json_decode(\Cookie::get('card'), true))
        ->where('status', 1)
        ->get() as $product)
        <li>
            <div class="product-card-item">
                <img src="{{$product->imgUrl()}}" alt="{{$product->name}}">
                <div class="product-card-content">
                    <h3>
                        {{$product->name}}
                    </h3>
                    <span>
                        {{$product->getPrice()}}
                    </span>
                    <a href="{{ route('client.product-card-toggle',$product->slug) }}"
                       class="btn btn-outline-danger btn-sm float-end mt-2">
                        <i class="ri-delete-bin-line"></i>
                    </a>
                </div>
            </div>

        </li>
@endforeach
