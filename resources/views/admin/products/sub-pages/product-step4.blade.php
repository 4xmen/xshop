<meta-input
    props-api-link="{{route('v1.category.prop','')}}/"

    @if(isset($item))
        :metaz='@json($item->getAllMeta())'
        :quantitiez='@json($item->quantities)'
        product-id="{{$item->id}}"
        :imgz='@json($item->getMedia()->toArray())'
    @endif
></meta-input>


