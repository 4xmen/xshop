<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="stock_quantity" class="my-2">
                {{__('Stock quantity')}}
            </label>
            <input type="number" id="stock_quantity" name="stock_quantity"
                   value="{{old('stock_quantity',$item->stock_quantity??0)}}"
                   placeholder="{{__('Stock quantity')}}"
                   class="form-control">
        </div>
        <div class="form-group">
            <label for="status" class="my-2">
                {{__("Status")}}
            </label>
            <select class="form-control" name="stock_status" id="status">
                @foreach(\App\Models\Product::$stock_status as $k => $v)
                    <option
                        value="{{ $v }}" {{ old("stock_status", $item->stock_status??null) == $v ? "selected" : "" }}>{{ __($v) }}</option>
                @endforeach
            </select>
        </div>
        <label for="tags" class="mt-2">
            {{__("Tags")}}
        </label>
            <tag-input xname="tags" splitter=",," xid="tags"
                       xtitle="{{__("Tags, Press enter")}}"
                       @if(isset($item))
                           xvalue="{{old('title',implode(',,',$item->tags->pluck('name')->toArray()??''))}}"
                @endif
            ></tag-input>

    </div>
    <div class="col-md-6">
        <h5>
            {{__("Categories")}}
        </h5>
        <ul class="group-control">
            {!!showCatNestedControl($cats,old('cat',isset($item)?$item->categories()->pluck('id')->toArray():[]))!!}
        </ul>
    </div>
</div>


<div>

    <div class="form-group">
        <label for="table">
            {{__('Description Table')}}
        </label>
        <textarea name="table" class="ckeditorx @error('description') is-invalid @enderror"
                  placeholder="{{__('Description Table')}}"
                  id="table"
                  rows="8">{{old('table',$item->table??null)}}</textarea>
    </div>
</div>
<div class="accordion mt-2" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                {{__("Discounts")}}
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
             data-bs-parent="#accordionExample">
            <div class="accordion-body">
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
                    @if(isset($item))
                        @foreach($item->discounts as $dis)
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
                                        <span class="ri-close-line"></span>
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
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                {{__("New Discount")}}
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
             data-bs-parent="#accordionExample">
            <div class="accordion-body">
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
