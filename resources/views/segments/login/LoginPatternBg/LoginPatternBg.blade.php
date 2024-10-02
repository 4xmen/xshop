<section id='LoginPatternBg' class="content"
>
    <div id="login-container"
         style="background-image: url('{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}')">
        <form @if(!config('app.sms.sign')) action="{{route('client.sign-in-do')}}" @endif id="login-form" method="post">
            @csrf
            <h3>
                {{$subtitle}}
            </h3>
            <div class="text-start">
                @include('components.err')
            </div>
            <div id="login-content">
                @if(!config('app.sms.sign'))
                    <label>
                        {{__("Email")}}
                    </label>
                    <input type="email" class="form-control" placeholder="{{__("Email")}}" name="email"
                           value="{{old('email')}}">
                    <label class="mt-2">
                        {{__("Password")}}
                    </label>
                    <input type="password" class="form-control" placeholder="{{__('Password')}}" name="password">
                    <button class="btn btn-outline-primary w-100 mt-3">
                        {{__("Sign-in")}}
                    </button>
                @else
                    <label>
                        {{__("Mobile")}}
                    </label>
                    <input type="tel" maxlength="12" class="form-control text-center"
                           id="tel" placeholder="{{__("09xxxxxxxx")}}">
                    <div class="not-send">
                        <label>
                            {{__("Auth code")}}
                        </label>
                        <input type="tel" maxlength="5" minlength="5" id="auth" class="form-control text-center"
                               placeholder="xxxxx">


                        <button type="button" class="btn btn-outline-primary w-100 mt-3"
                                id="send-auth-check" data-route="{{route('client.check-auth')}}"
                                data-profile="{{route('client.profile')}}">
                            {{__("Check authenticate code")}}
                        </button>


                    </div>
                    <div class="sent">
                        <button type="button" class="btn btn-outline-primary w-100 mt-3"
                                id="send-auth-code" data-route="{{route('client.send-sms')}}">
                            {{__("Send authenticate code")}}
                        </button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>
