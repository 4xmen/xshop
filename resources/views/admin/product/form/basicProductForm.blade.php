<div class="wizard-form">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="name">
                    {{__('Name')}}
                </label>
                <input name="name" type="text"
                       id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="{{__('Name')}}"
                       value="{{old('name',$product->name??null)}}"/>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
                <label for="price">
                    {{__('Base price')}}
                </label>
                <input name="price" type="text"
                       id="price"
                       class="form-control currency @error('price') is-invalid @enderror"
                       placeholder="{{__('Base price')}}"
                       value="{{old('price',$product->price??null)}}"/>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
                <label for="categoryId">
                    {{__('Main product category')}}
                </label>

                <select name="cat_id" id="categoryId" data-url="{{route('props.list','')}}/"
                        class="form-control sel2  @error('category_id') is-invalid @enderror">
                    @foreach($cats as $cat )
                        <option value="{{ $cat->id }}"
                                @if (old('category_id',$product->cat_id??null) == $cat->id ) selected @endif > {{$cat->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
                <label for="price">
                    {{__('SKU')}}
                </label>
                <input name="sku" type="text"
                       id="sku"
                       class="form-control @error('sku') is-invalid @enderror"
                       placeholder="{{__('SKU')}}"
                       value="{{old('sku',$product->sku??null)}}"/>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="excerpt">
                    {{__('Excerpt')}}
                </label>
                <textarea name="excerpt"
                          class="form-control @error('excerpt') is-invalid @enderror"
                          placeholder="{{__('Excerpt')}}"
                          id="excerpt"
                          rows="4">{{old('excerpt',$product->excerpt??null)}}</textarea>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="description">
                    {{__('Description Text')}}
                </label>
                <textarea name="desc" class="form-control @error('description') is-invalid @enderror"
                          placeholder="{{__('Description Text')}}"
                          id="description"
                          rows="8">{{old('description',$product->description??null)}}</textarea>
            </div>
        </div>
    </div>
</div>

