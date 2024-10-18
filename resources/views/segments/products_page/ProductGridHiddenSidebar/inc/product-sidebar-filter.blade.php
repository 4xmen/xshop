<aside class="mt-2">
    <div class="side-item">
        <h4>
            {{__("Filter")}}
        </h4>
        <div class="side-data">
            <meta-filter
                props-api-link="{{route('v1.category.prop','')}}/"
                @if(isset($category))
                    category="{{$category->id}}"
                @endif
            >
            </meta-filter>
        </div>
    </div>
</aside>
