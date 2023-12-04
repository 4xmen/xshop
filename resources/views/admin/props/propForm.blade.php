@extends('admin.adminlayout')

@section('content')
    <div class="container">

        @if(isset($p))
            <h5 class="text-center">
                {{__(" Property edit")}} [ {{$p->name}}]
            </h5>
        @else
            <h5>
                {{__("New Property")}}
            </h5>
        @endif
        @include('starter-kit::component.err')
        <form
            @if(isset($p))
                action="{{route('admin.props.update',$p->id)}}"
            @else
                action="{{route('admin.props.store')}}"
            @endif
            method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{__("Name")}}:</label>
                <input type="text" name="name" class="form-control" id="name" pattern="[a-z]+"
                       placeholder="{{__("Name")}}" required
                       value="{{old('name',$p->name??null)}}">
            </div>
            <div class="form-group">
                <label for="label">{{__("Label")}}:</label>
                <input type="text" name="label" class="form-control" id="label" required placeholder="{{__("Label")}}"
                       value="{{old('label',$p->label??null)}}">
            </div>
            <div class="form-group">
                <label for="width">{{__("Width")}}:</label>
                <input type="text" placeholder="{{__("Width")}}" name="width" class="form-control" id="width" required
                       value="{{old('width',$p->width??'col-md-12')}}">
            </div>

            <div class="form-group">
                <label for="required">{{__("Required")}}:</label>
                <select name="required" id="required" class="form-control" required>
                    <option
                        value="0" {{ old('required',$p->required??null) == '0' ? 'selected' : '' }} > {{__("Not required")}}
                    </option>
                    >
                    <option
                        value="1" {{ old('required',$p->required??null) == '1' ? 'selected' : '' }} > {{__("Required")}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="searchable">{{__("Searchable")}}:</label>
                <select name="searchable" id="searchable" class="form-control" required>
                    <option
                        value="0" {{ old('searchable',$p->searchable??null) == '0' ? 'selected' : '' }} > {{__("not searchable")}}
                    </option>
                    >
                    <option
                        value="1" {{ old('searchable',$p->searchable??null) == '1' ? 'selected' : '' }} > {{__("Searchable")}}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="xtype">{{__("Type")}}:</label>
                <select name="type" id="xtype" class="form-control" required>
                    <option
                        value="text" {{ old('type',$p->type??null) == 'text' ? 'selected' : '' }} > {{__("Text type")}}</option>
                    <option
                        value="number" {{ old('type',$p->type??null) == 'number' ? 'selected' : '' }} > {{__("Number type")}}</option>
                    <option
                        value="color" {{ old('type',$p->type??null) == 'color' ? 'selected' : '' }} > {{__("Color type")}}</option>
                    <option
                        value="checkbox" {{ old('type',$p->type??null) == 'checkbox' ? 'selected' : '' }}> {{__("Checkbox type")}}</option>
                    <option
                        value="select" {{ old('type',$p->type??null) == 'select' ? 'selected' : '' }}> {{__("Select type")}}</option>
                    <option
                        value="multi" {{ old('type',$p->type??null) == 'multi' ? 'selected' : '' }}> {{__("Multi select type")}}</option>
                    <option
                        value="singlemulti" {{ old('type',$p->type??null) == 'singlemulti' ? 'selected' : '' }}>{{__("Single Select & multi search")}}</option>
                </select>
            </div>
            <div class="form-group">
                <label>{{__("Category")}}</label>
                {{--                            <select--}}
                {{--                                multiple--}}
                {{--                                name="category[]"--}}
                {{--                                id="category"--}}
                {{--                                class="form-control"--}}
                {{--                                data-placeholder="Select category"--}}
                {{--                                required>--}}
                {{--                                <option value=""></option>--}}
                {{--                                @foreach($allCategories as $cat)--}}
                {{--                                    <option value="{{ $cat->id }}"--}}
                {{--                                            @if(isset($cats) && in_array($cat->id,$cats)) selected @endif > {{$cat->name}} </option>--}}
                {{--                                @endforeach--}}
                {{--                            </select>--}}
                {{--                            --}}
                <div class="cats-x3">
                    @foreach($allCategories as $k => $cat)

                        <div class="form-check form-switch">
                            <input class="form-check-input" value="{{ $cat->id }}"
                                   @if(isset($cats) && in_array($cat->id,$cats)) checked @endif  name="category[]"
                                   type="checkbox" id="c{{$k}}">
                            <label class="form-check-label" for="c{{$k}}"> {{$cat->name}} </label>
                        </div>
                    @endforeach
                </div>

            </div>
            <div>
            </div>
            <div class="form-group">
                <label>
                    {{__("Is effective price?")}}
                </label>
                <input type="checkbox" @if( isset($p) && $p->priceable) checked @endif name="priceable"
                       class="form-check">
            </div>
            <div class="card-header">
                {{__("Icon")}}
            </div>
            <div class="card-body">
                <remix-icon-picker xname="icon" xval="{{old('icon',$p->icon??null)}}"></remix-icon-picker>
            </div>
            @if(isset($p))
                <input type="hidden" id="options" value='{{$p->options}}'>
            @endif

            <div class="form-group">
                <label for="unit">{{__("Unit")}}:</label>
                <input type="text" placeholder="{{__("Unit")}}" name="unit" class="form-control" id="unit"
                       value="{{old('unit',$p->unit??null)}}">
            </div>


            <div id="xoptions">
                <h2>
                    {{__("Options")}}
                </h2>
                <div class="content">
                </div>
                <div class="btn btn-success m-2" style="float: left" id="add-options">
                    <div class="fa fa-plus"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <input type="submit" value="{{__("Save")}}" class="btn btn-primary"/>
            </div>
        </form>
    </div>

@endsection
