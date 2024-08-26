<section class='NsCard'>
    <div class="container-fluid">
        @include('components.err')
        @if(cardCount() == 0 )
            <div class="alert alert-info">
                {{__("There is nothing added to card!")}}
            </div>
        @else {{--  count 0--}}
        <form method="post" class="safe-form" >

            <input type="hidden" class="safe-url" data-url="{{route('client.card.check')}}">
            @csrf
            <ns-card
            :items='@json(cardItems())'
            :qs='{{\Cookie::get("q")}}'
            symbol="{{config('app.currency.symbol')}}"
            @if(auth('customer')->check())
                :addresses='@json(auth('customer')->user()->addresses)'
            @endif
            card-link="{{route('client.product-card-toggle','')}}/"
            discount-link="{{route('client.card.discount','')}}/"
            product-link="{{route('client.product','')}}/"
            :transports='@json(transports())'
            :def-transport="{{defTrannsport()}}"
            :can-pay="{{!auth('customer')->check() || auth('customer')->user()->mobile == null ||  auth('customer')->user()->mobile == '' || auth('customer')->user()->addresses()->count() == 0?'false':'true'}}"
            :translate='{{vueTranslate([
            'shopping-card' => __('Shopping card'),
            'transport' => __('Transport'),
            'discount-pay' => __('Payment & discount'),
            'total-price' => __('Total price'),
            'image' => __('Image'),
            'name' => __('Name'),
            'quantity' => __('Quantity'),
            'price' => __('Price'),
            'count' => __('Count'),
            'sent-to' => __('Sent to'),
            'check-dis' => __('Check discount'),
            'check' => __('Check'),
            'extra-desc' => __('Extra description'),
            'your-msg' => __('Your message for this order...'),
            'pay-now' => __('Pay now'),
            'plz' => __('Please, Login or complete information to pay'),
            ])}}'
            >
                <br>
                @if(!auth('customer')->check())
                    <a href="{{ route('client.sign-in') }}" class="btn btn-danger text-light btn-lg w-100">
                        {{__("You need to sign in/up to continue")}}
                    </a>
                @else
                    {{__("Welcome back")}}: <strong> {{auth('customer')->user()->name}} </strong>
                    @if(auth('customer')->user()->mobile == null ||  auth('customer')->user()->mobile == '' || auth('customer')->user()->addresses()->count() == 0)
                        <a href="{{ route('client.profile') }}" class="btn btn-danger text-light btn-lg w-100">
                            {{__("You need complete your information")}}
                        </a>
                    @endif
                @endif
            </ns-card>
        @endif {{--  count 0--}}

        </form>
    </div>
</section>
