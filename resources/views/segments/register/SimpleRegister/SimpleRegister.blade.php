<section class='SimpleRegister'>
    <div class="{{gfx()['container']}}">
        <form action="/blah" method="post" class="safe-form" id="email-register">
            @csrf
            @include('components.err')
            <input type="hidden" class="safe-url" data-url="{{route('client.sign-up-now')}}">
            <h5 class="text-center">
                {{__("Register or Reset password")}}
            </h5>
            <div class="form-group my-2">
                <label for="email">
                    {{__("Email")}}
                </label>
                <input type="email" id="email" required name="email" value="{{old('email')}}" placeholder="{{__("Email")}}" class="form-control">
            </div>

            <button class="btn btn-secondary w-100">
                <i class="ri-user-add-line"></i>
                {{__("Sign-up")}}
            </button>
        </form>
    </div>
</section>
