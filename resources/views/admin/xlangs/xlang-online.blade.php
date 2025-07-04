@extends('layouts.app')
@section('content')

    @include('components.err')

    <div class="general-form mb-3">

        <h1>
            {{__("Online edit")}}: {{$lang->name}} ({{config('app.xlang.main')}})
        </h1>

        <h5>
            {{__("Tips")}}:
        </h5>
        <ul>
            <li>
                {{ __("Leave blank to skip translating this string") }}
            </li>
            <li>
                {{ __("Please do not modify the base (English) string. If this is necessary Double-click to edit.") }}
            </li>
            <li>
                {{ __("To add a new string, click the “+” icon at the end of the table") }}
            </li>

        </ul>

        <form action="{{route('admin.lang.editSave',$lang->tag)}}" method="post" id="online-edit-translate">
            <input type="hidden" name="json" value="{}">
            @csrf
            <table class="table" id="translate-table">
                <tbody>
                <tr>
                    <td colspan="2">
                        <input type="search" class="form-control text-center" id="qTranslate"
                               placeholder="{{__("Search")}}">
                    </td>
                </tr>
                @foreach($translates as $k => $v)
                    <tr data-content="{{$k.' '.$v}}" class="tr-content">
                        <td @if($lang->rtl) dir="rtl" @endif>
                            <input type="text" value="{{$v}}"
                                   class="form-control @if(mb_strlen(trim($v)) == 0) border-warning  @endif"
                                   />
                        </td>
                        <td dir="ltr">
                            <input readonly type="text" class="form-control"  value="{{$k}}" minlength="1">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>




            <div class="w-100 btn btn-outline-light mb-3" id="add-translate">
                <i class="ri-add-box-line"></i>
            </div>

            <div class="w-100 btn btn-outline-secondary mb-3" id="sort-translate">
                <i class="ri-sort-alphabet-asc"></i>
            </div>

            <button class="btn btn-outline-success w-100">
                {{__("Save")}}
            </button>
        </form>
    </div>
@endsection
