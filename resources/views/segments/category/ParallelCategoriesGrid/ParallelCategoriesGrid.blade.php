<section class='ParallelCategoriesGrid'>
    <div class="{{gfx()['container']}}">
        @if(count($category->parallelCategories()) > 0)
            <div>
                <h3>
                    {{getSetting($data->area_name.'_'.$data->part.'_title')}}
                </h3>
                <div class="row">
                    @foreach($category->parallelCategories() as $subCat)
                        <div class="col-md">
                            <div class="parallel-category">
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
