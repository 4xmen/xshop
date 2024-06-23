<meta-input
    props-api-link="{{route('v1.category.prop','')}}/"
    @if(isset($item))
        :metaz='@json($item->getAllMeta())'
    @endif
></meta-input>
