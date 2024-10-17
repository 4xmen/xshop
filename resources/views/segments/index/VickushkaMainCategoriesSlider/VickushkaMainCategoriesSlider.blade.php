<section class='VickushkaMainCategoriesSlider'>
    <div class="{{gfx()['container']}}">
        <div class="row">

            @foreach(getMainCategory() as $category)
                <div class="col-md">

                        <div class="v-main-category" data-id="#v-cat-{{$category->id}}">
                            <img src="{{$category->svgUrl()}}" alt="svg {{$category->name}}">
                            <h4 class="text-center">
                                {{$category->name}}
                            </h4>
                        </div>
                </div>
            @endforeach
        </div>

        <h2 class="text-center mb-5">
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h2>

        <div id="v-cats" class="text-center">
            @foreach(getMainCategory() as $category)
                <div class="v-item" id="v-cat-{{$category->id}}">
                    <h3 class="mb-3">
                        {{$category->name}}
                    </h3>
                    <h4 class="text-muted mb-4">
                        {{$category->subtitle}}
                    </h4>
                    <div class="row">
                        @foreach($category->children as $subCat)
                            <div class="col-md-4">
                                <a href="{{$subCat->webUrl()}}">
                                    <img src="{{$subCat->imgUrl()}}" alt="{{$subCat->name}}" class="v-sub-img">
                                    <h5>
                                        {{$subCat->name}}
                                    </h5>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
