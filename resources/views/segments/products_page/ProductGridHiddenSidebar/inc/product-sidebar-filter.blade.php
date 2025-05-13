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
                :translate='{{vueTranslate([
                    'only' => __('Only available'),
                    'all' => __('All'),
                    "sort-by" => __('Sort by'),
                    "newset" => __('Newest'),
                    "oldest" => __('Oldest'),
                    'more-expensive' => __('More expensive'),
                    'cheaper' => __('Cheaper'),
                    'favorite' => __('Favorite'),
                    'more-sale' => __('More sale'),
                    'apply-filter' => __('Apply filter'),
                ])}}'
            >
            </meta-filter>
        </div>
    </div>
</aside>
