<aside class="mt-2">
    @cache('product_sidebar'. cacheNumber(), 90)
    <div class="side-item">
        <h4>
            {{__("Search")}}
        </h4>
        <form action="{{route('client.search')}}" class="side-data">
            <div class="input-group mb-3">
                <input type="search" name="q" class="form-control" placeholder="{{__('Search')}}...">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                    <i class="ri-search-2-line"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="side-item">
        <h4>
            {{__("Categories")}}
        </h4>
        <div class="side-data side-list">
            <ul class="ps-3">
                {!! showCatNested(\App\Models\Category::all(['id','name','parent_id','slug'])) !!}
            </ul>
        </div>
    </div>
    @endcache
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
