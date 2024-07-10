@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit gallery")}} [{{$item->title}}]
    @else
        {{__("Add new gallery")}}
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
                        {{__("You can add images after create gallery")}}
                    </li>
                    <li>
                        {{__("You can choose more than image to upload")}}
                    </li>
                    <li>
                        {{__("We recommending add title each images")}}
                    </li>
                </ul>
            </div>
            @if (isset($item))
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-image-2-line"></i>
                        {{__("Index image")}}
                    </h3>
                    <div class="pb-4">
                        <img src="{{$item->imgUrl()}}" data-open-file="#image" class="img-fluid" alt="{{$item->title}}">
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
                        {{__("Edit gallery")}} [{{$item->title}}]
                    @else
                        {{__("Add new gallery")}}
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
                            <label for="description">
                                {{__('Description')}}
                            </label>
                            <textarea id="description" name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="{{__('Description')}}"
                                      rows="3">{{old('description',$item->description??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
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
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="image">
                                {{__('Index image')}}
                            </label>
                            <input name="image" accept=".jpg,.png,.jpeg,.gif,.svg" type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   placeholder="{{__('Index image')}}" id="image"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label> &nbsp; </label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('out-of-form')
    @if (isset($item))
        @if($item->images->count() > 0)

        <div class="card mt-3">
            <div class="card-header">
                {{__("Images")}}
            </div>
            <form action="{{route('admin.gallery.title',$item->slug)}}" method="post">
                <div class="card-body">
                    @csrf
                    <div class="row">

                        @foreach($item->images as $img)
                            <div class="col-md-3">
                                <a href="{{route('admin.image.destroy',$img->id)}}" class="btn btn-danger delete-confirm rm-img ms-2">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                                <img src="{{$img->imgUrl()}}"  class="img-squire" alt="">
                                <div class="row mt-2">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="titles[{{$img->id}}]"
                                               value="{{$img->title}}"/>
                                    </div>
                                    <div class="col-md-2">
                                        @if(config('app.xlang'))
                                            <a href="{{route('admin.lang.model',[$img->id,\Xmen\StarterKit\Models\Image::class])}}"
                                               class="btn btn-outline-dark translat-btn">
                                                <i class="ri-translate"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="{{__("Save")}}"/>
                </div>
            </form>
        </div>
        @endif

        <div class="pb-5">
            <form class="card mt-3 mb-5" method="post" enctype="multipart/form-data"
                  action="{{route('admin.image.store',$item->slug)}}">
                @csrf
                <div class="card-header">
                    {{__("Upload new images")}}
                </div>
                <div class="card-body">
                    <input type="file" class="form-control" name="image[]" multiple accept="image/*"
                           id="gallery_images"/>
                    <ul id="newimgs">

                    </ul>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-dark" value="{{__("Upload images")}}"/>
                </div>
            </form>
        </div>
    @endif
@endsection
