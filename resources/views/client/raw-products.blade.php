@foreach($products as $product)
    <div class="{{getSetting('grid-class')}}">
        @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
    </div>
@endforeach
