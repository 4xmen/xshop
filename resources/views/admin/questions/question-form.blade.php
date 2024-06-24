@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit question")}} [{{$item->id}}]
    @else
        {{__("Add new question")}}
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
                        <i class="ri-info-i"></i>
                        {{__("Information")}}
                    </h3>
                    <ul>
                        <li>
                            {{__("Added by:")}}
                            <a href="{{route('admin.customer.edit',$item->customer->id)}}">
                                {{$item->customer->name}}
                            </a>
                        </li>
                        <li>
                            {{__("Question for:")}}
                            <a href="{{route('admin.product.edit',$item->product->id)}}">
                                {{$item->product->name}}
                            </a>
                        </li>
                    </ul>
                </div>

            @endif

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit question")}} [{{$item->id}}]
                    @else
                        {{__("Add new question")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="body" >
                                {{__('Question')}}
                            </label>
                            <textarea name="body"  id="body" class="form-control @error('body') is-invalid @enderror" placeholder="{{__('Question')}}"  >{{old('body',$item->body??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="answer" >
                                {{__('Answer')}}
                            </label>
                            <textarea name="answer"  id="answer" class="form-control @error('answer') is-invalid @enderror" placeholder="{{__('Answer')}}"  >{{old('answer',$item->answer??null)}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
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
        </div>
    </div>
@endsection
