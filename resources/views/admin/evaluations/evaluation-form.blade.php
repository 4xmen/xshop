@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit evaluation")}} [{{$item->title}}]
    @else
        {{__("Add new evaluation")}}
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
                        {{__("Leave model ID empty to apply all items")}}
                    </li>
                </ul>
            </div>

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit evaluation")}} [{{$item->title}}]
                    @else
                        {{__("Add new evaluation")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="{{__('Title')}}" value="{{old('title',$item->title??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="model">
                                {{__("Model")}}
                            </label>
                            <select name="evaluationable_type" id="model" class="form-control">
                                <option value=""> {{__("All")}} </option>
                                <option value="{{\App\Models\User::class}}" @if(\App\Models\User::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("User")}} </option>
                                <option value="{{\App\Models\Customer::class}}" @if(\App\Models\Customer::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("Customer")}} </option>
                                <option value="{{\App\Models\Post::class}}" @if(\App\Models\Post::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("Post")}} </option>
                                <option value="{{\App\Models\Product::class}}" @if(\App\Models\Product::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("Product")}} </option>
                                <option value="{{\App\Models\Category::class}}" @if(\App\Models\Category::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("Category")}} </option>
                                <option value="{{\App\Models\Group::class}}" @if(\App\Models\Group::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("Group")}} </option>
                                <option value="{{\App\Models\Invoice::class}}" @if(\App\Models\Invoice::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("Invoice")}} </option>
                                <option value="{{\App\Models\Ticket::class}}" @if(\App\Models\Ticket::class == old('evaluationable_type',$item->evaluationable_type??null)) selected @endif> {{__("Tickets")}} </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="mid">
                                {{__("Model ID")}}
                            </label>
                            <input name="evaluationable_id"  type="text"
                                   id="mid"
                                   class="form-control @error('evaluationable_id') is-invalid @enderror"
                                   placeholder="{{__('Model ID')}}" value="{{old('evaluationable_id',$item->evaluationable_id??null)}}"/>
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
