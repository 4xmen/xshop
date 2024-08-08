<section id='AvisaCustomer'>
    <div class="{{gfx()['container']}}">
        <div class="row">
            <div class="col-lg-3">
                <img src="{{asset('assets/default/unknown.svg')}}" alt="[avatar]" class="avisa-avatar">
                <div class="text-center ">
                    {{__("Welcome back")}}
                    <br>
                    <strong>
                        {{auth('customer')->user()->name}}
                    </strong>
                </div>
                <ul class="tab-control" id="avisa-tabs">
                    <li>
                        <a href="#summary" class="active">
                            <i class="ri-home-2-line"></i>
                            {{__("Summary")}}
                        </a>
                    </li>
                    <li>
                        <a href="#invoices">
                            <i class="ri-file-list-3-line"></i>
                            {{__("Invoices")}}
                        </a>
                    </li>
                    <li>
                        <a href="#profile">
                            <i class="ri-user-3-line"></i>
                            {{__("Profile")}}
                        </a>
                    </li>
                    <li>
                        <a href="#addresses">
                            <i class="ri-map-pin-user-line"></i>
                            {{__("Addresses")}}
                        </a>
                    </li>
                    <li>
                        <a href="#credit">
                            <i class="ri-bank-card-2-line"></i>
                            {{__("Credit")}}
                        </a>
                    </li>
                    <li>
                        <a href="#tickets">
                            <i class="ri-inbox-2-line"></i>
                            {{__("Tickets")}}
                        </a>
                    </li>
                    <li>
                        <a href="#tickets">
                            <i class="ri-mail-add-line"></i>
                            {{__("Submit new ticket")}}
                        </a>
                    </li>
                    <li>
                        <a href="#comments">
                            <i class="ri-message-2-line"></i>
                            {{__("Comments")}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('client.sign-out')}}">
                            <i class="ri-logout-box-line"></i>
                            {{__("Sign-out")}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9" id="tabs-content">

                <div class="mt-lg-5 mb-lg-5"> &nbsp;</div>
                <div class="mt-lg-5 mb-lg-5"> &nbsp;</div>
                @include('components.err')
                <div class="tab active" id="summary">
                    <div class="row">
                        <div class="avisa-grid col-lg-3 col-md-6">
                            <div class="grid-item">
                                <i class="ri-list-check-3"></i>
                                <h2>
                                    {{number_format(auth('customer')->user()->invoices()->count())}}
                                </h2>
                                <h3>
                                    {{__("Invoices")}}
                                </h3>
                            </div>
                        </div>
                        <div class="avisa-grid col-lg-3 col-md-6">
                            <div class="grid-item">
                                <i class="ri-bank-card-2-line"></i>
                                <h3>
                                    {{__("Credits")}}
                                </h3>
                                <h2>
                                    {{number_format(auth('customer')->user()->credit)}}
                                    {{config('app.currency.symbol')}}
                                </h2>
                            </div>
                        </div>
                        <div class="avisa-grid col-lg-3 col-md-6">
                            <div class="grid-item">
                                <i class="ri-message-3-line"></i>
                                <h2>
                                    {{number_format(auth('customer')->user()->tickets()->count())}}
                                </h2>
                                <h3>
                                    {{__("Tickets")}}
                                </h3>
                            </div>
                        </div>
                        <div class="avisa-grid col-lg-3 col-md-6">
                            <div class="grid-item">
                                <i class="ri-map-pin-line"></i>
                                <h2>
                                    {{number_format(auth('customer')->user()->addresses()->count())}}
                                </h2>
                                <h3>
                                    {{__("Addresses")}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    @if(cardCount() > 0)
                        <div class="alert alert-info mt-4">
                            <a href="{{ route('client.card') }}" class="btn btn-primary float-end">
                                {{__("Continue")}}
                            </a>
                            <h5 class="alert-heading">
                                {{__("System notification")}}
                            </h5>
                            {{__("You have some products in your shopping card.")}}
                            <br>
                        </div>
                    @endif
                    @if( auth('customer')->user()->name == null || trim(auth('customer')->user()->name) == '')
                        <div class="alert alert-danger mt-4">
                            <h5 class="alert-heading">
                                {{__("System notification")}}
                            </h5>
                            {{__("Your information is insufficient, Please complete your information")}}
                        </div>
                    @endif
                    @if(  auth('customer')->user()->addresses()->count() == 0)
                        <div class="alert alert-danger mt-4">
                            <h5 class="alert-heading">
                                {{__("System notification")}}
                            </h5>
                            {{__("You need at least one address to order, Please add address")}}
                        </div>
                    @endif
                </div>
                <div class="tab" id="invoices">
                    <table class="table table-striped text-center">
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                {{__("Datetime")}}
                            </th>
                            <th>
                                {{__("Orders count")}}
                            </th>
                            <th>
                                {{__("Total price")}}
                            </th>
                            <th>
                                {{__("Status")}}
                            </th>
                            <th>
                                -
                            </th>
                        </tr>
                        @foreach(auth('customer')->user()->invoices as $inv)
                            <tr>
                                <td>
                                    {{$inv->hash}}
                                </td>
                                <td>
                                    {{$inv->created_at->ldate('Y-m-d H:i')}}
                                </td>
                                <td>
                                    {{number_format($inv->count)}}
                                </td>
                                <td>
                                    <b>
                                        {{number_format($inv->total_price)}}
                                        {{config('app.currency.symbol')}}
                                    </b>
                                </td>
                                <td>
                                    <span class="inv-{{$inv->status}}">
                                            {{__($inv->status)}}
                                    </span>
                                </td>
                                <td style="width: 170px">
                                    <a href="{{ route('client.invoice',$inv->hash) }}"
                                       class="btn btn-outline-primary btn-sm ">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    @if($inv->status == 'PENDING')
                                        <a href="#" class="btn btn-outline-primary btn-sm ms-2">
                                            <i class="ri-secure-payment-line"></i>
                                            {{__("Pay now")}}
                                        </a>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab" id="profile">
                    <div class="alert alert-info">
                        {{__("If you want to change the password, choose both the same. Otherwise, leave the password field blank.")}}
                    </div>
                    <form action="{{route('client.profile.save')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="name">
                                        {{__('Name')}}
                                    </label>
                                    <input name="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="{{__('Name')}}"
                                           value="{{old('name',auth('customer')->user()->name??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="email">
                                        {{__('Email')}}
                                    </label>
                                    <input name="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="{{__('Email')}}"
                                           value="{{old('email',auth('customer')->user()->email??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="mobile">
                                        {{__('Mobile')}}
                                    </label>
                                    <input name="mobile" type="text" @if(config('app.sign.sms'))  readonly
                                           @endif  class="form-control @error('mobile') is-invalid @enderror"
                                           placeholder="{{__('Mobile')}}"
                                           value="{{old('mobile',auth('customer')->user()->mobile??null)}}"
                                           min-length="10"/>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="password">
                                        {{__('Password')}}
                                    </label>
                                    <input name="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="{{__('Password')}}" value="{{old('password',''??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label for="password_confirmation">
                                        {{__('password repeat')}}
                                    </label>
                                    <input name="password_confirmation" type="password"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           placeholder="{{__('password repeat')}}"
                                           value="{{old('password_confirmation',$item->password_confirmation??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> &nbsp;</label>
                                <input name="" type="submit" class="btn btn-primary mt-3 w-100 "
                                       value="{{__('Save')}}"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab" id="credit">
                    <div class="avisa-grid">
                        <div class="grid-item">
                            <i class="ri-bank-card-2-line"></i>
                            <h3>
                                {{__("Credits")}}
                            </h3>
                            <h2>
                                {{number_format(auth('customer')->user()->credit)}}
                                {{config('app.currency.symbol')}}
                            </h2>

                        </div>
                    </div>
                    <h5 class="my-3">
                        {{__("Credit history")}}
                    </h5>
                    @foreach(auth('customer')->user()->credits as $cr)
                        <div class="alert alert-info">
                            @if($cr->invoice_id != null)
                                <a href="{{ route('client.invoice',$cr->invoice()->hash) }}"
                                   class="btn btn-outline-primary btn-sm ">
                                    <i class="ri-eye-line"></i>
                                </a>
                            @endif
                            [{{$cr->created_at->ldate('Y-m-d H:i')}}]
                            <b class="ms-4">
                                {{number_format($cr->amount)}} {{config('app.currency.symbol')}}
                            </b>
                            @php($data = json_decode($cr->data))
                            @if(isset($data->message))
                                <i class="ms-4">
                                    {{$data->message}}
                                </i>
                            @endif
                        </div>
                    @endforeach
                    {{-- WIP add credit manual--}}

                </div>
                <div class="tab" id="tickets">

                    {{-- WIP tikets--}}
                </div>
                <div class="tab" id="comments">

                    {{-- WIP comments--}}
                </div>
                <div class="tab" id="submit-ticket">
                    {{-- WIP submit new ticket --}}
                </div>
                <div class="tab" id="addresses">
                    {{-- WIP submit new ticket --}}
                </div>
            </div>
        </div>
    </div>
</section>
