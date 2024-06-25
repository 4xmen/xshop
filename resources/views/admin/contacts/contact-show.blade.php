@extends('layouts.app')
@section('content')
    <table class="table table-bordered table-striped mb-4">
        <tr>
            <th>
                {{__("Date")}}
            </th>
            <td>
                {{$item->created_at->ldate('Y/m/d H:i')}}
            </td>
        </tr>
        <tr>
            <th>
                {{__("Subject")}}
            </th>
            <td>
                {{($item->subject)}}
            </td>
        </tr>
        <tr>
            <th>
                {{__("Name and lastname")}}
            </th>
            <td>
                {{($item->name)}}
            </td>
        </tr>
        <tr>
            <th>
                {{__("Mobile")}}
            </th>
            <td>
                {{($item->mobile)}}
            </td>
        </tr>
        <tr>
            <th>
                {{__("Email")}}
            </th>
            <td>
                {{($item->email)}}
            </td>
        </tr>
        <tr>
            <th>
                {{__("Question/Message")}}
            </th>
            <td>
                {!! $item->body !!}
            </td>
        </tr>

    </table>

    <form action="{{route('admin.contact.reply',$item->hash)}}" class="mt-4" method="post">
        @csrf
        <div class="form-group">
            <h4 style="text-align: center;">
                <label for="bodya">
                    {{__("Post reply")}}
                </label>
            </h4>
            <textarea type="" id="bodya" name="bodya" rows="10" placeholder="{{__("Reply message...")}}" class="form-control ckeditorx"></textarea>
        </div>
        <button type="submit"  class="btn btn-primary w-100 my-4" >
            {{__('Reply')}}
        </button>
    </form>
@endsection
