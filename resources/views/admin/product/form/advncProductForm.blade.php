<div class="wizard-form">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="stock_quantity">
                    {{__('Stock quantity')}}
                </label>
                <input type="number" id="stock_quantity" name="stock_quantity"
                       value="{{old('stock_quantity',$product->stock_quantity??0)}}"
                       placeholder="{{__('Stock quantity')}}"
                       class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="status">
                    {{__("Status")}}
                </label>
                <select class="form-control" name="stock_status" id="status">
                    @foreach( App\Helpers\stockTypes() AS $k => $v)
                        <option
                            value="{{ $k }}" {{ old("contact_way", $product->stock_status??null) == $k ? "selected" : "" }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{__("Product categories")}}
        </div>
        <div class="card-body">
            <ul class="category-control">
                {!!\Xmen\StarterKit\Helpers\showCatNestedControl($cats,old('cat',isset($product)?$product->categories()->pluck('id')->toArray():[]))!!}
            </ul>
        </div>
    </div>

    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{__("Tags")}}
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <input type="text" name="tags" class="taggble" @if(isset($product))
                    value="{{implode(',',$product->tag_names)}}"
                        @endif>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        {{__("Discounts")}}
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <table class="table" id="discounts">
                        <tr>
                            <th>
                                {{__("Type")}}
                            </th>
                            <th>
                                {{__("Amount")}}
                            </th>
                            <th>
                                {{__("Discount code")}}
                            </th>
                            <th>
                                {{__("Expire date")}}
                            </th>
                            <th>
                                -
                            </th>
                        </tr>
                        @if(isset($product))
                            @foreach($product->discounts as $dis)
                                <tr>
                                    <td>
                                        {{$dis->type}}
                                    </td>
                                    <td>
                                        {{$dis->amount}}
                                    </td>
                                    <td>
                                        {{$dis->code}}
                                    </td>
                                    <td>
                                        {{$dis->expire->jdate('Y/m/d')}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-id="{{$dis->id}}">
                                            <span class="fa fa-times"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                    <input type="hidden" id="discount-rem" name="discount[remove]" value="[]">

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        {{__("New Discount")}}
                    </button>
                </h2>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <table class="table" id="new-discount">
                        <thead>
                        <tr>
                            <th>
                                {{__("Type")}}
                            </th>
                            <th>
                                {{__("Amount")}}
                            </th>
                            {{--                           <th>--}}
                            {{--                               {{__("Discount code")}}--}}
                            {{--                           </th>--}}
                            <th>
                                {{__("Expire date")}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <label>
                                    {{__("by price")}}
                                    <input type="radio" checked name="discount[type]" value="price">
                                </label>
                                &nbsp;
                                &nbsp;
                                <label>
                                    {{__("by percent")}}
                                    <input type="radio" name="discount[type]" value="percent">
                                </label>
                            </td>
                            <td>
                                <input type="text" id="price-amount" placeholder="{{__("Amount")}}"
                                       name="discount[amount]" class="form-control">
                            </td>
                            {{--                           <td>--}}
                            {{--                               <input type="text" placeholder="{{__("Discount code")}}" name="discount[code]" class="form-control">--}}
                            {{--                           </td>--}}
                            <td>
                                <input placeholder="{{__("Expire date")}}" type="text" data-reuslt="#exp-date"
                                       class="form-control dtp">
                                <input type="hidden" name="discount[expire]" id="exp-date">
                            </td>
                            <td>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
