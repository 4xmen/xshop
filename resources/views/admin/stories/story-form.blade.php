@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit story")}} [{{$item->title}}]
    @else
        {{__("Add new story")}}
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
            @if(isset($item))
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-image-2-line"></i>
                        {{__('Feature image')}}
                    </h3>
                    <img src="{{$item->imgUrl()}}" alt="{{$item->name}}" data-open-file="#image" class="img-fluid mb-4">

                </div>
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-file-info-line"></i>
                        {{__("File")}}
                    </h3>
                    @if($item->file != null)
                        <div class="m-3">
                            <ul>
                                <li>
                                    {{__("File name")}}: <b>{{$item->file}}</b>
                                </li>
                                <li>
                                    {{__("File ext")}}: <b>{{$item->ext}}</b>
                                </li>

                            </ul>

                            <a href="{{$item->url()}}" class="btn btn-dark w-100">
                                <i class="ri-download-2-line"></i>
                                {{__("Download")}}
                            </a>
                        </div>
                    @endif
                </div>
            @endif

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit story")}} [{{$item->title}}]
                    @else
                        {{__("Add new story")}}
                    @endif
                </h1>


                <div class="row">

                    <div class="form-group row">
                        <div class="col-md-6 mt-3">
                            <label for="name">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                   placeholder="{{__('Title')}}" value="{{old('title',$item->title??null)}}"/>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="slug">
                                {{__('Slug')}}
                            </label>
                            <input name="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                                   placeholder="{{__('Slug')}}" value="{{old('slug',$item->slug??null)}}"/>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="image">
                                    {{__('Feature image')}}
                                </label>
                                <input accept=".jpg,.png,.svg" name="image" type="file"
                                       class="form-control @error('image') is-invalid @enderror" id="image"
                                       placeholder="{{__('Feature image')}}"/>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label for="svg">
                                    {{__('File')}}
                                </label>
                                <input accept=".mp4,.png,.gif,.jpg" name="file" type="file"
                                       class="form-control @error('file') is-invalid @enderror" id="svg"/>
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

                        <div class="col-md-12 mt-3">
                            <label for="description">
                                {{__('Description')}}
                            </label>
                            <textarea rows="5" name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="{{__('Description')}}">{{old('description',$item->description??null)}}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label> &nbsp;</label>
                            <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
