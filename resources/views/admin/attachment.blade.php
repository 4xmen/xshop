@extends('admin.adminlayout')
@section('page_title')
    {{__("Attachment")}}
    -
@endsection
@section('content')
    <div class="container">
        @include('starter-kit::component.err')
        <form action="{{route('admin.attachment.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-md-12 mt-3">
                    <label for="title">
                        {{__('Title')}}
                    </label>
                    <input id="title" name="title" type="text" class="form-control @error('name') is-invalid @enderror"
                           placeholder="{{__('Title')}}" value="{{old('title')}}"/>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="file">
                            {{__('File')}}
                        </label>
                        <input id="file" accept=".pdf" name="file" type="file" class="form-control-file @error('file') is-invalid @enderror" placeholder="{{__('File')}}" />
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <br>
                    <button class="btn btn-primary">
                        {{__("Save")}}
                    </button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered">
            <tr>
                <th>
                    {{__("Title")}}
                </th>
                <th>
                    {{__("Date")}}
                </th>
                <th>
                    {{__("File")}}
                </th>
                <th>
                    {{__("Action")}}
                </th>
            </tr>
            @foreach($attaches as $q)
                <tr>
                    <td>
                        {{$q->title}}
                    </td>
                    <td>
                        {{$q->created_at->jdate('Y/m/d')}}
                    </td>
                    <td>
                        <a href="{{url('/')}}{{$q->file}}" class="btn btn-dark" target="_blank">
                            <span class="fa fa-file-pdf"></span>
                        </a>
                    </td>
                    <td>
                        <a href="{{route('admin.attachment.delete',$q->id)}}"
                           class="btn btn-danger  delete-confirm">
                            <i class="fa fa-times"></i> &nbsp;
                            {{__("Delete")}}
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        <hr>
        {{$attaches->links()}}
    </div>
@endsection
