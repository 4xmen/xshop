@extends('website.layout.layout')
@section('title')
    {{$title}}
@endsection
@section('content')
    <div class="container">
        <div style="text-align: center; padding-top: 60px;">
            <h3>ارتباط با
                {{config('app.name')}}
            </h3>
            <p style="color: gray; text-align: center; padding-top: 10px; display: none">
                {{ \App\Helpers\getSetting('context')}}
            </p>
        </div>
        @include('starter-kit::component.err')

        <form class="" method="post" action="{{route('sendcontact')}}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div
                        style="background-color: #fcfcfc; border-top: 1px solid #e3e3e3;border-bottom: 1px solid #e3e3e3;">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12" style="padding-top: 20px;padding-bottom: 20px;">
                                    <h2 style="font-size:20px;padding-bottom: 15px;">اطلاعات تماس</h2>
                                    {!!  \App\Helpers\getSetting('concon') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ContactFormCenter-ESH">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <div class="form-group">
                                    <label for="full_name">
                                        {{--                        {{__('Name and lastname')}}--}}
                                    </label>
                                    <input name="full_name" type="text"
                                           class="form-control @error('full_name') is-invalid @enderror"
                                           placeholder="{{__('Name and lastname')}}"
                                           value="{{old('full_name',$item->full_name??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-5 mt-3">
                                <div class="form-group">
                                    <label for="Phone">
                                        {{--                        {{__('Phone')}}--}}
                                    </label>
                                    <input name="Phone" type="Phone"
                                           class="form-control @error('Phone') is-invalid @enderror"
                                           placeholder="{{__('Phone')}}" value="{{old('Phone',$item->Phone??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-5 mt-3">
                                <div class="form-group">
                                    <label for="email">
                                        {{--                        {{__('Email')}}--}}
                                    </label>
                                    <input name="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="{{__('Email')}}" value="{{old('email',$item->email??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-5 mt-3">
                                <div class="form-group">
                                    <label for="subject">
                                        {{--                        {{__('Subject')}}--}}
                                    </label>
                                    <input name="subject" type="text"
                                           class="form-control @error('subject') is-invalid @enderror"
                                           placeholder="{{__('Subject')}}"
                                           value="{{old('subject',$item->subject??null)}}"/>
                                </div>
                            </div>
                            <div class="col-md-10 mt-3">
                                <div class="form-group">
                                    <label for="body">
                                        {{--                        {{__('Your message...')}}--}}
                                    </label>
                                    <textarea name="bodya" style=" height: 150px;"
                                              class="form-control @error('bodya') is-invalid @enderror"
                                              placeholder="{{__('Question/Message')}}">{{old('body',$item->body??null)}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <label> &nbsp; </label>
                                <input name="" type="submit" class="btn btn-primary mt-2 w-100" value="{{__('Send')}}"
                                       style=" width: 200px; height: 44px; float: left;"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
@endsection

{{--@section('no-container-content')--}}


{{--    <div style="height: 350px; width: 100%; overflow: hidden; margin-top: 70px;display: none">--}}
{{--        --}}{{--<iframe style="position: relative; top: -55px; border: none;" src="https://www.google.com/maps/d/embed?mid=1nh4QKL5NsjxjrYPP0lSuXoqonivw3__V&ll=35.78018283181089%2C51.447350091079194&z=17&hl=fa" width="100%" height="400"></iframe>--}}
{{--        <iframe style="position: relative; top: -55px; border: none;" src="{{ \App\Helpers\getSetting('map')}}" width="100%" height="400"></iframe>--}}
{{--    </div>--}}
{{--<iframe src="https://www.google.com/maps/d/embed?mid=1dNzeybI2-o_F0vtHUEEVwURhtBA"  style="width: 100%;border: 0" height="480"></iframe>--}}

{{--@endsection--}}
