@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($ccat))
        {{__('New product category')}}
    @else
        {{__('Edit product category')}}: {{$ccat->name}}
    @endif
    -
@endsection
@section('content')
    <div class="container">

        <h1>
            @if(!isset($ccat))
                {{__('New product category')}}
            @else
                {{__('Edit product category')}}: {{$ccat->name}}
                <img src="{{$ccat->thumbUrl()}}" class="x64 float-start" alt="">
                <img src="{{$ccat->backUrl()}}" class="x64 float-start" alt="">
{{--                {{$ccat->imgUrl()}}--}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form method="post" @if(!isset($ccat)) action="{{route('admin.cat.store')}}"
              @else  action="{{route('admin.cat.update',$ccat->slug)}}" @endif enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-md-12 mt-3">
                    <label for="name">
                        {{__('Product category name')}}
                    </label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           placeholder="{{__('Product category name')}}" value="{{old('name',$ccat->name??null)}}"/>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="parent">
                        {{__('Product category Parent')}}
                    </label>
                    <select name="parent" id="parent"
                            class="form-control @error('parent') is-invalid @enderror">
                        <option value=""> {{__('No parent')}} </option>
                        @foreach($cats as $cat )
                            <option value="{{ $cat->id }}"
                                    @if (old('parent',$ccat->parent_id??null) == $cat->id ) selected @endif > {{$cat->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="image">
                            {{__('Thumbnail')}}
                        </label>
                        <input name="image" type="file" class="form-control-file @error('image') is-invalid @enderror" placeholder="{{__('Image')}}" value="{{old('image')}}"  />
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="image">
                            {{__('Image')}}
                        </label>
                        <input name="image2" type="file" class="form-control-file @error('image2') is-invalid @enderror" placeholder="{{__('Image')}}" value="{{old('image2')}}"  />
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="description">
                        {{__('Description')}}
                    </label>
                    <textarea rows="5" name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="{{__('Description')}}">{{old('description',$ccat->description??null)}}</textarea>
                </div>
                <div class="col-md-12">
                    <label> &nbsp;</label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                </div>
            </div>
        </form>
    </div>
@endsection
