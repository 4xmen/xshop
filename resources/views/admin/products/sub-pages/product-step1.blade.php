    <div class="row">
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="name">
                    {{__('Name')}}
                </label>
                <input name="name" type="text"
                       id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="{{__('Name')}}"
                       value="{{old('name',$item->name??null)}}"/>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="name">
                    {{__('Slug')}}
                </label>
                <input name="slug" type="text"
                       id="slug"
                       class="form-control @error('slug') is-invalid @enderror"
                       placeholder="{{__('Slug')}}"
                       value="{{old('slug',$item->slug??null)}}"/>
            </div>
        </div>


        <div class="col-lg-3 mt-3">
            <div class="form-group">
                <label for="price">
                    {{__('Base price')}}
                </label>

                <currency-input name="price" xid="price" @error('price')
                :err="true" @enderror :xvalue="{{old('price',$item->price??null)}}"></currency-input>
            </div>
        </div>
        <div class="col-lg-3 mt-3">
            <div class="form-group">
                <label for="categoryId">
                    {{__('Main product category')}}1
                </label>

{{--                        data-url="{{route('props.list','')}}/"--}}
                    <searchable-select
                        @error('category_id') :err="true" @enderror
                        :items='@json($cats)'
                        title-field="name"
                        value-field="id"
                        xlang="{{config('app.locale')}}"
                        xid="categoryId"
                        xname="category_id"
                        @error('category_id') :err="true" @enderror
                        xvalue='{{old('category_id',$item->category_id??null)}}'
                        :close-on-Select="true"></searchable-select>
            </div>
        </div>
        <div class="col-lg-3 mt-3">
            <div class="form-group">
                <label for="price">
                    {{__('SKU')}}
                </label>
                <input name="sku" type="text"
                       id="sku"
                       class="form-control @error('sku') is-invalid @enderror"
                       placeholder="{{__('SKU')}}"
                       value="{{old('sku',$item->sku??null)}}"/>
            </div>
        </div>
        <div class="col-lg-3 mt-3">
            <div class="form-group">
                <label for="status">
                    {{__('Status')}}
                </label>
                <select name="status" id="status"
                        class="form-control @error('status') is-invalid @enderror">
                    <option value="1"
                            @if (old('status',$item->status??null) == '1' ) selected @endif >{{__("Published")}} </option>
                    <option value="0"
                            @if (old('status',$item->status??null) == '0' ) selected @endif >{{__("Draft")}} </option>
                </select>
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
                          rows="4">{{old('excerpt',$item->excerpt??null)}}</textarea>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="form-group">
                <label for="description">
                    {{__('Description Text')}}
                </label>
                <textarea name="desc" class="form-control ckeditorx @error('description') is-invalid @enderror"
                          placeholder="{{__('Description Text')}}"
                          id="description"
                          rows="8">{{old('description',$item->description??null)}}</textarea>
            </div>
        </div>
    </div>
