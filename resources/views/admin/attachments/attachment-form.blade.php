@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit attachment")}} [{{$item->title}}]
    @else
        {{__("Add new attachment")}}
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
                        {{__("If you want to only attach to other staff members and do not want to appear in the website attachment list, uncheck `fillable`")}}
                    </li>
                    @if(isset($item) && $item->file == null)
                        <li>
                            {{__("There is noting file to show!")}}
                        </li>
                        <li>
                            {{__("Please upload file")}}
                        </li>
                    @endif

                </ul>
            </div>
            @if(isset($item))
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
                                <li>
                                    {{__("File size")}}: <b>{{formatFileSize($item->size)}}</b>
                                </li>
                            </ul>


                            <a href="{{$item->url()}}" class="btn btn-dark w-100">
                                <i class="ri-download-2-line"></i>
                                {{__("Download")}}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-attachment-line"></i>
                        {{__("Attaching")}}
                    </h3>
                    <div class="px-3 pb-4">
                        <morph-selector
                            :morphs='@json(\App\Models\Attachment::$mrohps)'
                            morph-search-link="{{route('v1.morph.search')}}"
                            xlang="{{config('app.locale')}}"
                            @if(isset($item))
                                xmorph="{{$item->attachable_type}}"
                                :xid="{{$item->attachable_id}}"
                            @endif
                        ></morph-selector>
                    </div>
                </div>
            @endif

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit attachment")}} [{{$item->title}}]
                    @else
                        {{__("Add new attachment")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" placeholder="{{__('Title')}}"
                                   value="{{old('title',$item->title??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="slug">
                                {{__('Slug')}}
                            </label>
                            <input name="slug" type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" placeholder="{{__('Slug')}}" value="{{old('slug',$item->slug??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="subtitle">
                                {{__('Subtitle')}}
                            </label>
                            <input name="subtitle" type="text"
                                   class="form-control @error('subtitle') is-invalid @enderror" id="subtitle"
                                   placeholder="{{__('Subtitle')}}" value="{{old('subtitle',$item->subtitle??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="body">
                                {{__('Description')}}
                            </label>
                            <textarea rows="4" name="body" id="body"
                                      class="ckeditorx form-control @error('body') is-invalid @enderror"
                                      placeholder="{{__('Description')}}">{{old('body',$item->body??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="file">
                                {{__('File')}}
                            </label>
                            <input name="file" type="file" class="form-control @error('file') is-invalid @enderror"
                                   id="file" placeholder="{{__('File')}}"
                                   accept=".png,.jpg,.svg,.mp4,.pdf,.docx,.zip,.rar,.mp3"/>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="my-1">&nbsp;</div>
                        <div class="form-check form-switch">
                            <input class="form-check-input   @error('is_fillable') is-invalid @enderror"
                                   name="is_fillable" type="checkbox" id="is_fillable"
                                   @if(old('is_fillable',$item->is_fillable??null) == 1) checked="" @endif
                                   value="1">
                            <label for="is_fillable">
                                {{__('Is fillable')}}
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label> &nbsp; </label>
                        <input type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
