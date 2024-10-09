@extends('layouts.app')
@section('title')
    {{__("Setting")}} -
@endsection
@section('content')
    <div class="row">
        <div class="mb-5 pb-5">
            <div class="row">
                {{--  list side bar start--}}
                <div class="col-xl-3">
                    @include('components.err')
                    <div class="item-list mb-3">
                        <h3 class="p-3">
                            <i class="ri-message-3-line"></i>
                            {{__("Tips")}}
                        </h3>
                        <ul>
                            <li>
                                {{__("Recommends")}}
                            </li>
                        </ul>

                        <div class="p-2">
                            <a href="{{ route('admin.setting.cache-clear') }}" class="btn btn-secondary d-block">
                                {{__("Clear caches")}}
                            </a>
                        </div>
                    </div>

                    <div class="item-list mb-3">
                        <h3 class="p-3">
                            <i class="ri-file-2-line"></i>
                            {{__("Sections")}}
                        </h3>
                        <div class="p-2">

                            <div class="section-group">
                                @foreach(\App\Models\Setting::groupBy('section')->pluck('section')->toArray() as $sec)
                                    <a href="#{{$sec}}" class="section-group-item">
                                        {{__(ucfirst($sec))}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="item-list mb-3">
                        <h3 class="p-3">
                            <i class="ri-add-line"></i>
                            {{__("Add new setting")}}
                        </h3>
                        @if(auth()->user()->hasRole('developer'))
                            <form class="p-2 m-3 mt-0" method="post" action="{{route('admin.setting.store')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="section">
                                        {{__('Section')}}
                                    </label>
                                    <input name="section" type="text"
                                           class="form-control @error('section') is-invalid @enderror"
                                           placeholder="{{__('Section')}}"
                                           value="{{old('section',$setting->section??null)}}"/>
                                </div>

                                <div class="form-group">
                                    <label for="type">
                                        {{__('Type')}}
                                    </label>
                                    <select name="type" id="type"
                                            class="form-control @error('type') is-invalid @enderror">
                                        @foreach(\App\Models\Setting::$settingTypes as $type)
                                            <option value="{{$type}}"
                                                    @if (old('type') == $type ) selected @endif >{{__($type)}} </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title">
                                        {{__('Title')}}
                                    </label>
                                    <input name="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="{{__('Title')}}"
                                           value="{{old('title')}}"/>
                                </div>

                                <div class="form-group">
                                    <label for="key">
                                        {{__('Key')}}
                                    </label>
                                    <input name="key" type="text"
                                           class="form-control @error('key') is-invalid @enderror"
                                           placeholder="{{__('Key')}}" value="{{old('key')}}"/>
                                </div>
                                <div class="form-group">
                                    <label for="size">
                                        {{__('Size')}}
                                    </label>
                                    <input name="size" type="number"
                                           class="form-control @error('size') is-invalid @enderror"
                                           placeholder="{{__('Size')}}" value="{{old('size',12)}}"/>
                                </div>

                                <label> &nbsp;</label>
                                <input name="" type="submit" class="btn w-100 btn-primary mt-2"
                                       value="{{__('Add to setting')}}"/>
                            </form>

                        @endif
                    </div>


                </div>
                <div class="col-xl-9 ps-xl-0" id="setting-sections">
                    <form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @foreach(\App\Models\Setting::groupBy('section')->pluck('section')->toArray() as $sec)
                            <section id="{{$sec}}">
                                <div class="row">
                                    @foreach($settings as $setting)
                                        @if($setting->section == $sec)
                                            @include('components.setting-field')
                                        @endif
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                        <button class="action-btn circle-btn"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-title="{{__("Save all settings")}}"
                        >
                            <i class="ri-save-2-line"></i>
                        </button>
                    </form>
                </div>
                <div class="mb-5">
                    &nbsp;
                </div>
            </div>
        </div>
@endsection
