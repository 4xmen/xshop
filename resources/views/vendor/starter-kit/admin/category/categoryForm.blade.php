@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    @if(!isset($ccat))
        {{__('New category')}}
    @else
        {{__('Edit category')}}: {{$ccat->name}}
    @endif
    -
@endsection
@section('content')
    <div class="container">

        <h1>
            @if(!isset($ccat))
                {{__('New category')}}
            @else
                {{__('Edit category')}}: {{$ccat->name}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form method="post" @if(!isset($ccat)) action="{{route('admin.category.store')}}"
              @else  action="{{route('admin.category.update',$ccat->slug)}}" @endif>
            @csrf

            <div class="form-group row">
                <div class="col-md-8 mt-3">
                    <label for="name">
                        {{__('Category name')}}
                    </label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           placeholder="{{__('Category name')}}" value="{{old('name',$ccat->name??null)}}"/>
                </div>
                <div class="col-md-8 mt-3">
                    <label for="parent">
                        {{__('Category Parent')}}
                    </label>
                    <select name="parent" id="parent"
                            class="form-control @error('parent') is-invalid @enderror">
                        <option value=""> {{__('No parent')}} </option>
                        @foreach($cats as $cat )
                            <option value="{{ $cat->id }}"
                                    @if (old('parent',$ccat->parent->id??null) == $cat->id ) selected @endif > {{$cat->name}} </option>
                        @endforeach
                    </select>
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
