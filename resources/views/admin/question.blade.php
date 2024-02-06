@extends('admin.adminlayout')
@section('page_title')
    {{__("Setting")}}
    -
@endsection
@section('content')
    @include('starter-kit::component.err')
    <table class="table table-striped table-bordered text-center">
        <tr>
            <th>
                #
            </th>
            <th>
                {{__("Question / Answer")}}
            </th>
            <th>
                {{__("Product")}}
            </th>
            <th>
                {{__("Action")}}
            </th>
        </tr>
        @foreach($qs as $q)
            <tr>
                <td>
                    {{$q->id}}
                </td>
                <td>
                    {{$q->body}}
                    <hr>
                    <form action="{{route('admin.question.update',$q->id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea placeholder="{{__("Answer")}}" name="answer" class="form-control" id="answer" rows="3">{{$q->answer}}</textarea>
                        </div>
                        <button class="btn btn-primary">
                            {{__("Answer")}}
                        </button>
                    </form>
                </td>
                <td>
                    {{$q->product->name}}
                    @if($q->product->getMedia()->count() > 0)
                        <hr>
                        <img src="{{$q->product->thumbUrl()}}" class="feature-image" alt="">
                    @endif
                </td>
                <td>
                    <a href="{{route('admin.question.delete',$q->id)}}"
                       class="btn btn-danger  delete-confirm">
                        <i class="fa fa-times"></i> &nbsp;
                        {{__("Delete")}}
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
    <hr>
    {{$qs->links()}}
@endsection
