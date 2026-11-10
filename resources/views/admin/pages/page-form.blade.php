@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit page")}} [{{$item->id}}]
    @else
        {{__("Add new page")}}
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
                    @if(isset($item))
                        <li>
                            {{__("You can set the theme of this item exclusively")}} : <a
                                href="{{route('admin.area.design.model',['page','Page',$item->id])}}"
                                class="btn btn-secondary btn-sm"> <i class="ri-palette-line"></i> </a>
                        </li>
                        <li>
                            {{__("You can add some attachment to this item")}}
                        </li>
                        <li>
                            {{__("What the visitor sees")}} : <a href="{{$item->webUrl()}}" target="_blank"
                                                                 class="btn btn-primary btn-sm">
                                {{__("Preview")}}
                            </a>
                        </li>
                    @endif
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
                        {{__("Edit page")}} [{{$item->id}}]
                    @else
                        {{__("Add new page")}}
                    @endif
                </h1>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="{{__('Title')}}" value="{{old('title',$item->title??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="slug">
                            {{__('Slug')}}
                        </label>
                        <input name="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                               placeholder="{{__('Slug')}}" value="{{old('slug',$item->slug??null)}}"/>
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
                                {{__('Page Text')}}
                            </label>
                            <textarea name="body"
                                      class="ckeditorx seo-analyze form-control @error('body') is-invalid @enderror"
                                      placeholder="{{__('Post Text')}}"
                                      rows="8">{{old('body',$item->body??null)}}</textarea>
                            {{--                                    @trix(\App\Post::class, 'body')--}}

                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="group_id">
                                {{__('Page parent')}}
                            </label>
                            <select name="parent_id" class="form-control  @error('parent_id') is-invalid @enderror"
                                    id="parent_id">
                                @foreach($pages as $page )
                                    <option value=""> {{__("No parent")}} </option>
                                    <option value="{{ $page->id }}"
                                            @if (old('group_id',$item->parent_id??null) == $page->id ) selected @endif > {{$page->title}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
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
                    <div class="col-md-4 mt-3">
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
                    <div class="col-md-12">
                        <label> &nbsp;</label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>
                </div>

            </div>
            @if(isset($item))
                <div class="item-list my-3">

                    <h3 class="p-3">
                        <i class="ri-message-3-line"></i>
                        {{__("Markups")}}
                    </h3>
                    <div class="mt-4">
                        <code-editor
                            value='{{base64_encode(old('markups', $item->markups)??'')}}'
                            xname="markups"
                            :btns='@json($item->markupKeywords())'
                            default-syntax="html"
                        ></code-editor>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
