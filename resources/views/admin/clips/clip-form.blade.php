@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit clip")}} [{{$item->title}}]
    @else
        {{__("Add new clip")}}
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
                        {{__("Add cover to better results")}}
                    </li>
                    <li>
                        {{__("You can create / edit clip as draft, publish it when you want")}}
                    </li>
                </ul>
            </div>
            @if(isset($item))
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-message-3-line"></i>
                        {{__("Preview")}}
                    </h3>
                    <div class="p-2">
                            <video src="{{$item->fileUrl()}}" poster="{{$item->imgUrl()}}" controls
                                   style="max-width: 100%"></video>
                    </div>
                </div>
            @endif
            @if(isset($item))
                <div class="item-list mb-3">
                    <div class="p-3">
                        @include('components.panel-attachs',['attachs' => $item->attachs])
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit clip")}} [{{$item->title}}]
                    @else
                        {{__("Add new clip")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
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
                            <label for="body">
                                {{__('Description')}}
                            </label>
                            <textarea name="body" class="ckeditorx form-control @error('body') is-invalid @enderror"
                                      placeholder="{{__('Description')}}">{{old('body',$item->body??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label>
                                {{__("Tags")}}
                            </label>
                            <tag-input xname="tags" splitter=",,"
                                       xtitle="{{__("Tags, Press enter")}}"
                                       @if(isset($item))
                                           xvalue="{{old('title',implode(',,',$item->tags->pluck('name')->toArray()??''))}}"
                                @endif
                            ></tag-input>

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
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="cover">
                                {{__('Cover')}}
                            </label>
                            <input name="cover" id="cover" type="file"
                                   class="form-control @error('cover') is-invalid @enderror"
                                   placeholder="{{__('Cover')}}" accept="image/*"/>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="clip">
                                {{__('Video clip')}}
                            </label>
                            <input name="clip" id="clip" type="file"
                                   class="form-control @error('clip') is-invalid @enderror"
                                   placeholder="{{__('Video clip')}}" accept=".mp4"/>
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
