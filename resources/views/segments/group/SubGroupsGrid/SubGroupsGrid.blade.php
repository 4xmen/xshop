<section class='SubGroupsGrid content'>
    <div class="{{gfx()['container']}}">
        @if($group->children()->count() > 0)
            <div>
                <h3 class="text-center">
                    {{__("Sub groups")}}
                </h3>
                <div class="row">
                    @foreach($group->children as $subGroup)
                        <div class="col-md">
                            <div class="sub-group">
                                <img src="{{$subGroup->imgUrl()}}" alt="{{$subGroup->name}}" class="img-fluid" loading="lazy">
                                <h4>
                                    {{$subGroup->name}}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
