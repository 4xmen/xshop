<div class="wizard-form">
    <div class="row">
        <div class="col-md-6 mt-3">
            <div class="form-group pt-3" >

                <div class="form-check form-switch">
                    <input name="active" class="form-check-input @error('active') is-invalid @enderror" type="checkbox" value="1"  id="active"  @if (old('active',$product->active??0) != 0)
                        checked
                        @endif>
                    <label class="form-check-label" for="active">{{__('Active')}}</label>
                </div>
        </div>
    </div>

    <input type="hidden" id="jDataSrc" value='{!! $product->category->props??'[]' !!}'>
    <input type="hidden" id="jDef" value='{!! $product->meta??'[]' !!}'>
    <meta-element id="jdata" ref="metaEl"  :searchable="false" :defz="def" :jdata='jdata'></meta-element>
    <div id="meta" class="row"></div>

    <div id="metaprice">
        <meta-price   ref="metaPr" :jdata='jdata' :images='{!! isset($product)?$product->getMedia():'[]' !!}'
                      :defz='{!! isset($product)?$product->quantities()->pluck('data'):'[]' !!}' ></meta-price>
    </div>
    @if(isset($product))
        <input type="hidden" name="id" value="{{$product->id}}"/>
        <input type="hidden" id="metaz" value='@json($product->getAllMeta())'>
    @endif
</div>
