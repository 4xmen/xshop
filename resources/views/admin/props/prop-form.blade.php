@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit prop")}} [{{$item->name}}]
    @else
        {{__("Add new prop")}}
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
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-remixicon-line"></i>
                    {{__("Icon")}}
                </h3>
                <div class="p-1 text-center pb-4">
                    <remix-icon-picker xname="icon" xvalue="{{old('icon',$item->icon??null)}}"></remix-icon-picker>
                </div>
            </div>
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-list-check"></i>
                    {{__("Categories")}}
                </h3>
                <div>
                    <ul class="group-control">
                        {!!showCatNestedControl($cats,old('cat',isset($item)?$item->categories()->pluck('id')->toArray():[]))!!}
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit prop")}} [{{$item->name}}]
                    @else
                        {{__("Add new prop")}}
                    @endif
                </h1>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="name">{{__("Name")}}:</label>
                            <input type="text" name="name" class="form-control" id="name" pattern="[a-z]+"
                                   placeholder="{{__("Name")}}" required
                                   value="{{old('name',$item->name??null)}}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="label">{{__("Label")}}:</label>
                            <input type="text" name="label" class="form-control" id="label" required placeholder="{{__("Label")}}"
                                   value="{{old('label',$item->label??null)}}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="width">{{__("Width")}}:</label>
                            <input type="text" placeholder="{{__("Width")}}" name="width" class="form-control" id="width" required
                                   value="{{old('width',$item->width??'col-md-12')}}">
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="required">{{__("Required")}}:</label>
                            <select name="required" id="required" class="form-control" required>
                                <option
                                    value="0" {{ old('required',$item->required??null) == '0' ? 'selected' : '' }} > {{__("Not required")}}
                                </option>
                                >
                                <option
                                    value="1" {{ old('required',$item->required??null) == '1' ? 'selected' : '' }} > {{__("Required")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="searchable">{{__("Searchable")}}:</label>
                            <select name="searchable" id="searchable" class="form-control" required>
                                <option
                                    value="0" {{ old('searchable',$item->searchable??null) == '0' ? 'selected' : '' }} > {{__("not searchable")}}
                                </option>
                                >
                                <option
                                    value="1" {{ old('searchable',$item->searchable??null) == '1' ? 'selected' : '' }} > {{__("Searchable")}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="unit">{{__("Unit")}}:</label>
                            <input type="text"  placeholder="{{__("Unit")}}" name="unit" class="form-control" id="unit"
                                   value="{{old('unit',$item->unit??null)}}">
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 py-1">

                        <div class="form-group mt-4">

                            <div class="form-check form-switch">
                                <input class="form-check-input" name="priceable"  @if (old('priceable',$item->priceable??0) != 0)
                                    checked
                                       @endif type="checkbox" id="priceable">
                                <label class="form-check-label" for="priceable"> {{__("Is effective price?")}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label id="type">
                              {{__("Type")}}
                        </label>
                        <props-type-input
                            xtitle="Select type"
                            :is-required="true"
                            :xid="type"
                            xname="type"
                            :types='@json(\App\Models\Prop::$prop_types)'
                            @if(isset($item))
                                :xoptions='{!! old('options',$item->options) !!}'
                            @else
                                :xoptions='{{old('options')}}'
                            @endif
                            xvalue="{{old('type',$item->type??'')}}"
                        ></props-type-input>
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
