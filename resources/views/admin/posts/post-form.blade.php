@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit post")}} [{{$item->title}}]
    @else
        {{__("Add new post")}}
    @endif -
@endsection
@section('form')

    <div class="row">
        <div class="col-lg-3">

            @include('components.err')
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-message-3-line"></i>
                    {{__("Tips")}}
                </h3>
                <ul>
                    <li>
                        {{__("Recommends")}}
                    </li>
                </ul>
            </div>
            @if (isset($item))
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-image-2-line"></i>
                        {{__("Index image")}}
                    </h3>
                    <div data-open-file="#customFile">
                        <img src="{{$item->imgUrl()}}" class="img-fluid" alt="{{$item->title}}">
                    </div>
                </div>
            @endif
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-list-check"></i>
                    {{__("Groups")}}
                </h3>
                <div>
                    <ul class="group-control">
                        {!!showCatNestedControl($cats,old('cat',isset($item)?$item->groups()->pluck('id')->toArray():[]))!!}
                    </ul>
                </div>
            </div>
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-price-tag-3-line"></i>
                    {{__("Tags")}}
                </h3>
                <div>
{{--                    {{json_encode($item->tags->pluck('name')->toArray())}}--}}
                    <tag-input xname="tags" splitter=",,"
                               xtitle="{{__("Tags, Press enter")}}"
                               @if(isset($item))
                               xvalue="{{old('title',implode(',,',$item->tags->pluck('name')->toArray()??''))}}"
                               @endif
                    ></tag-input>
{{--                    <input type="text" name="tags" class="taggble" @if(isset($item))--}}
{{--                        value="{{implode(',',$item->tag_names)}}"--}}
{{--                        @endif>--}}
                </div>
            </div>
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-remixicon-line"></i>
                    {{__("Icon")}}
                </h3>
                <div class="p-1 text-center pb-4">
                    <remix-icon-picker xname="icon" xvalue="{{old('icon',$item->icon??null)}}"></remix-icon-picker>
                </div>
            </div>
            @if(isset($item))
            <div class="item-list mb-3">
                <div class="p-3">
                @include('components.panel-attachs',['attachs' => $item->attachs])
                </div>
            </div>
            @endif

            @if(isset($item))
                <div class="item-list mb-3">
                    <div class="p-3">
                        <div class="form-group">
                            <label for="canonical" class="my-2">
                                {{__('Canonical')}}
                            </label>
                            <input type="text" id="canonical" name="canonical"
                                   value="{{old('canonical',$item->canonical??null)}}"
                                   placeholder="{{__('canonical')}}"
                                   class="form-control">
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit post")}} [{{$item->title}}]
                    @else
                        {{__("Add new post")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="{{__('Title')}}" value="{{old('title',$item->title??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-9 mt-3">
                        <label for="slug">
                            {{__('Slug')}}
                        </label>
                        <input name="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                               placeholder="{{__('Slug')}}" value="{{old('slug',$item->slug??null)}}"/>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="form-group mt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="table_of_contents"  @if (old('table_of_contents',$item->table_of_contents??0) != 0)
                                    checked
                                       @endif type="checkbox" id="table_of_contents">
                                <label class="form-check-label" for="table_of_contents">{{__('Table of contents')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="subtitle">
                                {{__('Subtitle')}}
                            </label>
                            <textarea name="subtitle"
                                      class="form-control  @error('subtitle') is-invalid @enderror"
                                      placeholder="{{__('Subtitle')}}"
                                      rows="4">{{old('subtitle',$item->subtitle??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="body">
                                {{__('Post Text')}}
                            </label>
                            <textarea name="body" class="ckeditorx seo-analyze form-control @error('body') is-invalid @enderror"
                                      placeholder="{{__('Post Text')}}"
                                      rows="8">{{old('body',$item->body??null)}}</textarea>
                            {{--                                    @trix(\App\Post::class, 'body')--}}


                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mt-3">
                            <label for="title">
                                {{__('Keyword')}} [{{__("SEO")}}]
                            </label>
                            <input name="keyword" type="text" id="keyword"
                                   class="form-control @error('keyword') is-invalid @enderror"
                                   placeholder="{{__('Keyword')}}" value="{{old('keyword',$item->keyword??null)}}"/>
                        </div>

                        <div id="seo-hint">
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label for="group_id">
                                {{__('Main group')}}
                            </label>
                            <select name="group_id" class="form-control  @error('group_id') is-invalid @enderror" id="group_id">
                                @foreach($cats as $cat )
                                    <option value="{{ $cat->id }}"
                                            @if (old('group_id',$item->group_id??null) == $cat->id ) selected @endif > {{$cat->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label for="image">
                                {{__('Index image')}}
                            </label>

                            <div class="custom-file">
                                <input type="file" class="form-control" id="customFile" name="image"
                                       accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
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
                    <div class="col-md-3 mt-3 pt-2">
                        <div class="form-group mt-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="is_pin"  @if (old('is_pin',$item->is_pinned??0) != 0)
                                    checked
                                       @endif type="checkbox" id="ispin">
                                <label class="form-check-label" for="ispin">{{__('Pin')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label> &nbsp;</label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
