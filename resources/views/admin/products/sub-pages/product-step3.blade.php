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
        <label for="canonical" class="my-2">
            {{__('Canonical')}}
        </label>
        <input type="text" id="canonical" name="canonical"
               value="{{old('canonical',$item->canonical??null)}}"
               placeholder="{{__('canonical')}}"
               class="form-control">
    </div>
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
<hr>
<h4 class="my-4">
    {{__("Discounts")}}
    <a href="{{route('admin.discount.create')}}?product_id={{$item->id??null}}" class="btn btn-light float-end">
        <i class="ri-add-line"></i>
        {{__("Add new discount")}}
    </a>
</h4>
<table class="table" id="discounts">
    <tr>
        <th>
            {{__("Title")}}
        </th>
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
                    {{$dis->title}}
                </td>
                <td>
                    {{$dis->type}}
                </td>
                <td>
                    {{number_format($dis->amount)}}
                    @if($dis->type == "PERCENT")
                        %
                    @endif
                </td>
                <td>
                    {{$dis->code}}
                </td>
                <td>
                    {{$dis->expire?->ldate('Y-m-d H:i:s')??'-'}}
                </td>
                <td>
                    <a href="{{ route('admin.discount.destroy',$dis->id) }}" class="btn btn-danger" data-id="{{$dis->id}}">
                        <span class="ri-close-line"></span>
                    </a>
                    <a href="{{route('admin.discount.edit',$dis->id)}}" class="btn btn-primary ms-1">
                        <i class="ri-edit-line"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    @endif
</table>



{{--<div class="row">--}}
{{--    <div class="col-md-6">--}}
{{--        <div class="form-group mt-4">--}}
{{--            <label for="title">--}}
{{--                {{__('Title')}}--}}
{{--            </label>--}}
{{--            <input name="discount[type]" type="text" id="title"--}}
{{--                   class="form-control @error('discount.type') is-invalid @enderror"--}}
{{--                   placeholder="{{__('Title')}}" value="{{old('discount.type')}}"/>--}}
{{--        </div>--}}
{{--        <div class="form-group mt-4">--}}
{{--            <label for="type">--}}
{{--                {{__('Type')}}--}}
{{--            </label>--}}
{{--            <select name="discount[type]" id="type"--}}
{{--                    class="form-control @error('type') is-invalid @enderror">--}}
{{--                @foreach(\App\Models\Discount::$doscount_type as $k => $v)--}}
{{--                    <option--}}
{{--                        value="{{ $v }}" {{ old("discount",\App\Models\Discount::$doscount_type[0]) == $v ? "selected" : "" }}>{{ __($v) }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <div class="form-group mt-4">--}}
{{--            <label for="amount">--}}
{{--                {{__('Amount')}}--}}
{{--            </label>--}}

{{--            <currency-input xname="discount[amount]" xid="amount" xtitle="{{__('Amount')}}"--}}
{{--                            @error('amount')--}}
{{--                            :err="true"--}}
{{--                            @enderror :xvalue="{{old('discount.amount')}}"></currency-input>--}}
{{--        </div>--}}
{{--        <div class="form-group mt-4">--}}
{{--            <label for="expire">--}}
{{--                {{__('Expire  date')}}--}}
{{--            </label>--}}
{{--            <vue-datetime-picker-input--}}
{{--                :xmin="{{strtotime('yesterday')}}"--}}
{{--                xid="dp" xname="discount[expire]" xshow="datetime" xtitle="Expire date" def-tab="1"--}}
{{--                :timepicker="true"--}}
{{--            ></vue-datetime-picker-input>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-6 mt-3">--}}
{{--        <div class="form-group">--}}
{{--            <label for="body">--}}
{{--                {{__('Description')}}--}}
{{--            </label>--}}
{{--            <textarea name="body" class="ckeditorx form-control @error('body') is-invalid @enderror"--}}
{{--                      placeholder="{{__('Description')}}"--}}
{{--                      rows="4">{{old('body',$item->body??null)}}</textarea>--}}

{{--        </div>--}}
{{--    </div>--}}

{{--</div>--}}
<hr>
<div class="mt-4">
    @include('components.panel-attachs',['attachs' => $item->attachs??[]])
</div>
