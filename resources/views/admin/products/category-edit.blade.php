@include('components.panel-header')
<div id="panel-preloader">
    <div class="loader"></div>
</div>
<input type="hidden" id="panel-dir" @if(langIsRTL(config('app.locale'))) value="rtl" @else value="ltr" @endif>
<form action="{{route('admin.product.category-save',$product->slug)}}" method="post" id="ajax-sync-form">
@csrf
<div class="container pt-4" >
    @include('components.err')
    <h5>
        {{__("Categories")}} [{{$product->name}}]
    </h5>
    <ul class="nested-ul">
        {!!showCatNestedControl($cats,old('cat',isset($product)?$product->categories()->pluck('id')->toArray():[]))!!}
    </ul>
</div>
<button class="action-btn circle-btn"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        data-bs-custom-class="custom-tooltip"
        data-bs-title="{{__("Save")}}"
        id="categories-save-btn"
>
    <i class="ri-save-2-line"></i>
</button>
</form>
@include('components.panel-footer')
