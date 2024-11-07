<div class="setting-field col-md-{{$setting->size}}">
    <label for="{{$setting->key}}">
        {{$setting->title}}
        @if(config('app.xlang.active') && isset($setting->translatable) &&
($setting['type'] == 'LONGTEXT' || $setting['type'] == 'TEXT' || $setting['type'] == 'EDITOR'))
            <a href="{{route('admin.lang.model',[$setting->id, get_class($setting)])}}{{$setting['type'] == 'EDITOR'?'?editor=1':''}}">
                <i class="ri-translate"></i>
            </a>
        @endif

        {{--        // WIP translate--}}
    </label>

    @switch($setting->type)
        @case('LONGTEXT')
            <textarea name="{{$setting->key}}"  @if($setting->ltr) dir="ltr" @endif id="{{$setting->key}}"
                      class="form-control"
                      rows="5">{{old($setting->key, $setting->value)}}</textarea>
            @break
        @case('CODE')
            <textarea dir="ltr" name="{{$setting->key}}" id="{{$setting->key}}"
                      class="form-control"
                      rows="5">{{old($setting->key, $setting->value)}}</textarea>
            @break
        @case('TIME')
            <vue-time-picker :am-pm="false"
                             xid="{{$setting->key}}"
                             xname="{{$setting->key}}"
                             :xvalue="{{$setting->value}}"
                             xtitle="{{$setting->title}}"></vue-time-picker>
            @break
        @case('DATE')
            <vue-datetime-picker-input
                xid="{{$setting->key}}" xname="{{$setting->key}}"  @if(app()->getLocale() == 'fa')  xshow="pdate" @else xshow="date" @endif  xtitle="{{$setting->title}}" @if(app()->getLocale() != 'fa')  def-tab="1" @endif
            :xvalue="{{$setting->value}}"
            ></vue-datetime-picker-input>
            @break
        @case('DATETIME')
            <vue-datetime-picker-input
                xid="{{$setting->key}}" xname="{{$setting->key}}"  @if(app()->getLocale() == 'fa')  xshow="pdatetime" @else xshow="datetime" @endif  xtitle="{{$setting->title}}" @if(app()->getLocale() != 'fa')  def-tab="1" @endif
            :xvalue="{{$setting->value}}"
                :timepicker="true"
            ></vue-datetime-picker-input>
            @break
        @case('ICON')
            <remix-icon-picker xname="{{$setting->key}}" xvalue="{{old($setting->key, $setting->value)}}"></remix-icon-picker>
            @break
        @case('LOCATION')
            @php($latlng = explode(',',old($setting->key, $setting->value)))
            <lat-lng xname="{{$setting->key}}" :ilat="{{$latlng[0]}}" :ilng="{{$latlng[1]}}" :izoom="{{$latlng[2]}}" :dark-mode="true"></lat-lng>
            @break
        @case('EDITOR')
            <textarea name="{{$setting->key}}" id="{{$setting->key}}"
                      class="form-control ckeditorx"
                      rows="5">{{old($setting->key, $setting->value)}}</textarea>
            @break
        @case('CHECKBOX')
            <select name="{{$setting->key}}" id="{{$setting->key}}"
                    class="form-control @error('status') is-invalid @enderror">
                <option value="1"
                        @if (old($setting->key, $setting->value??0) == '1' ) selected @endif >{{__("True")}} </option>
                <option value="0"
                        @if (old($setting->key, $setting->value??0) == '0' ) selected @endif >{{__("False")}} </option>
            </select>
            @break
        @case('CATEGORY')
            <searchable-select
                @error('category_id') :err="true" @enderror
            :items='@json($cats)'
                title-field="name"
                value-field="id"
                xlang="{{config('app.locale')}}"
                xid="{{$setting->key}}"
                xname="{{$setting->key}}"
                @error('category_id') :err="true" @enderror
                xvalue='{{old($setting->key,$setting->value??null)}}'
                :close-on-Select="true"></searchable-select>
            @break
        @case('GROUP')
            <searchable-select
                @error('category_id') :err="true" @enderror
            :items='@json($groups)'
                title-field="name"
                value-field="id"
                xlang="{{config('app.locale')}}"
                xid="{{$setting->key}}"
                xname="{{$setting->key}}"
                @error('category_id') :err="true" @enderror
                xvalue='{{old($setting->key,$setting->value??null)}}'
                :close-on-Select="true"></searchable-select>
            @break
        @case('MENU')
            <searchable-select
                @error('category_id') :err="true" @enderror
            :items='@json($menus)'
                title-field="name"
                value-field="id"
                xid="{{$setting->key}}"
                xname="{{$setting->key}}"
                @error('category_id') :err="true" @enderror
                xvalue='{{old($setting->key,$setting->value??null)}}'
                :close-on-Select="true"></searchable-select>
            @break
        @case('COLOR')
            <br>
            <input type="color" id="{{$setting->key}}"
                   name="{{$setting->key}}" class="form-control-color w-100"
                   value="{{old($setting->key, $setting->value)}}" >
            @break
        @case('NUMBER')
            <br>
{{--            <input type="number" id="{{$setting->key}}"--}}
{{--                   name="" class="form-control"--}}
{{--                   value="" @if($setting->ltr) dir="ltr" @endif>--}}
            <increment xname="{{$setting->key}}" xvalue="{{old($setting->key, $setting->value)}}" @foreach($setting->getData() as $k => $v) {{$k}}="{{$v}}" @endforeach ></increment>
            @break
        @case('FILE')
            <div class="row">
                @php($ext = strtolower(pathinfo(str_replace('_','.',$setting->key), PATHINFO_EXTENSION)))
                <div class="col-md-5 ">
                    <input type="file" accept=".{{pathinfo(str_replace('_','.',$setting->key), PATHINFO_EXTENSION)}}" class="form-control" name="file[{{$setting->key}}]" id="{{$setting->key}}">
                </div>
                @if(!in_array($ext, ['svg','jpg','png','gif','webp'] ) )
                    <div class="col-md-2">
                        <a class="btn btn-primary w-100" href="{{asset('upload/file/'.str_replace('_','.',$setting->key))}}?{{time()}}">
                            <i class="ri-download-2-line"></i>
                        </a>
                    </div>
                @endif
                <div class="col-md-5 text-center">
                    @if($ext == 'mp4')
                        <video controls src="{{asset('upload/file/'.str_replace('_','.',$setting->key))}}?{{time()}}" class="img-fluid" style="max-height: 150px;max-width: 45%" ></video>
                        <br>
                    @elseif($ext == 'mp3')
                        <audio controls src="{{asset('upload/file/'.str_replace('_','.',$setting->key))}}?{{time()}}" class="img-fluid" style="max-height: 150px;max-width: 45%" ></audio>
                        <br>
                    @elseif(in_array($ext, ['svg','jpg','png','gif','webp'] ) )
                        <img src="{{asset('upload/images/'.str_replace('_','.',$setting->key))}}?{{time()}}"
                             class="img-fluid" style="max-height: 150px;max-width: 45%" alt="{{$setting->key}}">
                    @endif
                </div>

            </div>
            @break
        @default
            @if($setting->key == 'optimize')
                <select  class="form-control" name="{{$setting->key}}" id="{{$setting->key}}">
                    <option value="jpg"
                            @if (old($setting->key, $setting->value??'webp') == 'jpg' ) selected @endif >{{__("jpg")}} </option>
                    <option value="webp"
                            @if (old($setting->key, $setting->value??'webp') == 'webp' ) selected @endif >{{__("webp")}} </option>
                </select>
            @else
                <input type="text" id="{{$setting->key}}"
                       name="{{$setting->key}}" class="form-control"
                       value="{{old($setting->key, $setting->value)}}" @if($setting->ltr) dir="ltr" @endif>
            @endif
    @endswitch
</div>
