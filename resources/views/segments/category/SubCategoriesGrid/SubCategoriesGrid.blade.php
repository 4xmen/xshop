<section class='SubCategoriesGrid content'>
    <div class="{{gfx()['container']}}">
        @if($category->children()->count() > 0)
            <div>
                <h3 class="text-center">
                    {{__("Sub categories")}}
                </h3>
                <div class="row">
                    @foreach($category->children as $subCat)
                        <div class="col-md">
                            <div class="sub-category">
                                <img src="{{$subCat->imgUrl()}}" alt="{{$subCat->name}}" class="img-fluid" loading="lazy">
                                <h4>
                                    {{$subCat->name}}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
