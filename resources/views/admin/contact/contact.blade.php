@extends('admin.adminlayout')

@section('content')
    <div class="p-5">
        @include('starter-kit::component.err')
        <table class="table table-bordered table-striped mb-4">
            <tr>
                <th>
                    {{__("Date")}}
                </th>
                <td>
                    {{$con->created_at->jdate('Y/m/d H:i')}}
                </td>
            </tr>
            <tr>
                <th>
                    {{__("Subject")}}
                </th>
                <td>
                    {{($con->subject)}}
                </td>
            </tr>
            <tr>
                <th>
                    {{__("Name and lastname")}}
                </th>
                <td>
                    {{($con->full_name)}}
                </td>
            </tr>
            <tr>
                <th>
                    {{__("Phone")}}
                </th>
                <td>
                    {{($con->phone)}}
                </td>
            </tr>
            <tr>
                <th>
                    {{__("Email")}}
                </th>
                <td>
                    {{($con->email)}}
                </td>
            </tr>
            <tr>
                <th>
                    {{__("Question|Message")}}
                </th>
                <td>
                    {{($con->body)}}
                </td>
            </tr>

        </table>

        <a href="{{route('admin.contact.delete',$con->id)}}"
           class="btn-danger btn delete-confirm">
            {{__("Delete")}}
            <i class="fa fa-times"></i>
        </a>

        <div style="padding-top: 35px;padding-bottom: 10px;"></div>


        <form action="{{route('admin.contact.reply',$con->id)}}" method="post">
            @csrf
            <div class="form-group">
                <h4 style="text-align: center;">
                    <label for="bodya">
                        {{__("Post reply")}}
                     </label>
                </h4>
                <textarea type="" id="bodya" name="bodya" rows="10" placeholder="{{__("body")}}" class="form-control"></textarea>
            </div>
            <button type="submit"  class="btn btn-primary" style=" width: 90px; height: 37px;">
                {{__('Reply')}}
            </button>
        </form>
    </div>
@endsection
