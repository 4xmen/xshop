<aside class="mt-2">
    <div class="side-item">
        <h4>
            {{__("Search")}}
        </h4>
        <form action="" class="side-data">
            <div class="input-group mb-3">
                <input type="search" class="form-control" placeholder="{{__('Search')}}...">
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
                {!! showCatNested(\App\Models\Category::all(['id','name','parent_id'])) !!}
            </ul>
        </div>
    </div>
</aside>
