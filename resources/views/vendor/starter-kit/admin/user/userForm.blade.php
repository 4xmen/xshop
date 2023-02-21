@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    @if (isset($user))
        {{__("Edit user")}} {{$user->name}}
    @else
        {{__("Create user")}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if (isset($user))
                {{__("Edit user")}} {{$user->name}}
            @else
                {{__("Create user")}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form class="" method="post"
              @if (isset($user))
              action="{{route('admin.user.update',$user->id)}}"
              @else
              action="{{route('admin.user.store')}}"
              @endif
              >
            @csrf

            @if (isset($user))
                <input type="hidden" name="id" value="{{$user->id}}"/>
            @endif
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="name">
                            {{__('Name')}}
                        </label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               placeholder="{{__('Name')}}" value="{{old('name',$user->name??null)}}"/>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="email">
                            {{__('Email')}}
                        </label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="{{__('Email')}}" value="{{old('email',$user->email??null)}}"/>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="role">
                            {{__('Role')}}
                        </label>
                        <select name="role" id="" class="form-control @error('role') is-invalid @enderror">
                            <option value="super-admin"
                                    @if (old('role',$user->role??null) == 'super-admin') selected @endif >{{__("Admin")}} </option>
                            <option value="manager"
                                    @if (old('role',$user->role??null) == 'manager' ) selected @endif >{{__("User")}} </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="mobile">
                            {{__('Mobile')}}
                        </label>
                        <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                               placeholder="{{__('Mobile')}}" value="{{old('mobile',$user->mobile??null)}}"
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
                               value="{{old('password_confirmation',$user->password_confirmation??null)}}"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <label> &nbsp;</label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                </div>
            </div>
        </form>
    </div>
@endsection
