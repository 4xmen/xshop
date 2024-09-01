<aside class="p-4">
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
    <h4>
        {{__("Recent posts")}}
    </h4>
    <ul class="recent">
        @foreach(\App\Models\Post::where('status',1)->orderByDesc('id')->limit(5)->get() as $pst)
            <li>
                <a href="{{$pst->webUrl()}}">
                    <img src="{{$pst->imgUrl()}}" alt="{{$pst->title}}" class="float-start me-2">
                    <h6>
                        {{$pst->title}}
                    </h6>
                    <p class="text-muted">
                        {{$pst->subtitle}}
                    </p>
                </a>
            </li>
        @endforeach
    </ul>
    <h4>
        {{__("Groups")}}
    </h4>

    <ul class="list-group">
        @foreach(\App\Models\Group::whereNull('parent_id')->get() as $grp)
        <li class="list-group-item">
            <a href="{{$grp->webUrl()}}">
                {{$grp->name}}
            </a>
        </li>
        @endforeach
    </ul>
</aside>
