<div class="container mt-5 mb-5" style="direction: rtl">
    @if($result)
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">
                {{__(":app Dear customer Your :product signed for you.",['product'=>$invoice->products->implode('name','، '),'app'=>config('site.name')])}}
            </h4>
            <p>اکنون می توانید به محصول دسترسی داشته باشید.</p>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            <b>{{__('Payment error')}}: {{$message}}</b>
        </div>
{{--        <p class="mt-4 "> کاربر گرامی میتوانید مجددا اقدام به پرداخت صورت حساب نمایید:</p>--}}
    @endif
</div>
