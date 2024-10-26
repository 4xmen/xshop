@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit user")}} [{{$item->name}}]
    @else
        {{__("Add new user")}}
    @endif -
@endsection
@section('form')

    <div class="row">
        <div class="col-lg-3">
            <div class="item-list mb-3">
                @include('components.err')

                <h3 class="p-3">
                    <i class="ri-message-3-line"></i>
                    {{__("Tips")}}
                </h3>
                <ul>
                    <li>
                        {{__("If you want to change the password, choose both the same. Otherwise, leave the password field blank.")}}
                    </li>
                    <li>
                        {{__("E-mail is unique each users")}}
                    </li>
                    @if(config('app.demo'))
                    <li>
                        {{__("You can't change email or password in demo version")}}
                    </li>
                    @endif
                </ul>
            </div>
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-user-3-line"></i>
                    {{__("Avatar")}}
                </h3>
                <img @if(isset($item)) src="{{$item->avatar()}}" @else src="{{asset('assets/default/unknown.svg')}}" @endif  class="img-fluid mb-3" alt="" data-open-file="#avatar-input">
                <input type="file" name="avatar" id="avatar-input"  accept="image/jpeg">
            </div>
        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit user")}} [{{$item->name}}]
                    @else
                        {{__("Add new user")}}
                    @endif
                </h1>
                <div class="row">
                    <div class="col-md-6 col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="name">
                                {{__('Name')}}
                            </label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="{{__('Name')}}" value="{{old('name',$item->name??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="email">
                                {{__('Email')}}
                            </label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="{{__('Email')}}" value="{{old('email',$item->email??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mt-3">
                        <div class="form-group">
                            <label for="role">
                                {{__('Role')}}
                            </label>
                            <searchable-select
                                :items='{{arrayNormolizeVueCompatible(\App\Models\User::$roles, true)}}'
                                title-field="name"
                                value-field="name"
                                xname="role"
                                @error('role') :err="true" @enderror
                                xvalue='{{old('role',$item->role??null)}}'
                                :close-on-Select="true"></searchable-select>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mt-3">
                        <div class="form-group">
                            <label for="mobile">
                                {{__('Mobile')}}
                            </label>
                            <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                   placeholder="{{__('Mobile')}}" value="{{old('mobile',$item->mobile??null)}}"
                                   min-length="10"/>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mt-3">
                        <div class="form-group">
                            <label for="password">
                                {{__('Password')}}
                            </label>
                            <input name="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="{{__('Password')}}" value="{{old('password',''??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mt-3">
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
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>




                    @if(isset($item) && $item->hasRole('user'))

                        <div class="col-12">
                            <br>
                            <button class="btn btn-secondary" type="button"
                                    data-bs-toggle="collapse" href="#collapseExample" role="button"
                                    aria-expanded="false" aria-controls="collapseExample">
                                {{__("ACL")}}
                                ({{$item->accesses()->count()}})
                            </button>
                            <div class="mt-2">
                                <div class="collapse" id="collapseExample">
                                    <div class="card card-body">
                                        @foreach($routes as $name => $route)

                                            <div class="switches-holder">

                                                <div class="rule-title">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input main-switch" type="checkbox"
                                                               role="switch"
                                                               id="main{{$name}}">
                                                        <label class="form-check-label"
                                                               for="main{{$name}}"> {{__($name)}} </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @foreach($route as $r)
                                                        <div class="col-md-3">
                                                            <div class="px-3 py-2">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch"
                                                                           name="acl[]"
                                                                           @if ($item->hasAccess("admin.{$name}.{$r}"))
                                                                               checked
                                                                           @endif
                                                                           value="admin.{{$name}}.{{$r}}"
                                                                           id="s{{$r}}">
                                                                    <label class="form-check-label"
                                                                           for="s{{$r}}">
                                                                        @if($r == 'all' || $r == 'index' | $r == 'list')
                                                                            {{__("Show list")}}
                                                                        @else
                                                                            {{__('!'.$r)}}
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js-content')
    <script>
        document.addEventListener('DOMContentLoaded',function () {
            document.querySelectorAll('.main-switch').forEach(function (chk) {
                chk.addEventListener('change', function () {
                    let state = this.checked;
                    this.closest('.switches-holder').querySelectorAll('.row input[type="checkbox"]').forEach(function (subCheck) {
                        subCheck.checked = state;
                    });
                });
            });
        });
    </script>
@endsection
