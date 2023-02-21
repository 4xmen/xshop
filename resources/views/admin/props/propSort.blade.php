@extends('admin.adminlayout')

@section('content')
    <div class="container">
        <h5 class="text-center"> {{__("Properties sort")}} "{{$cat->name}}"
        </h5>
        @include('starter-kit::component.err')
        <div class="table-responsive">
            <ol class="srt list-group">
                @foreach($props as $k=>$p)
                    <li data-id="{{$p->id}}" class="list-group-item">
                        <b>{{$p->label}}</b>
                        -
                        {{$p->name}}
                        -
                        <i style="color: #a779e9">
                            {{$p->type}}
                        </i>

                    </li>
                @endforeach
            </ol>
            <form action="{{route('admin.props.sortStore')}}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="sort" id="sort-result" value="[]">
                <input type="submit" value="{{__("Save sort")}}" class="btn btn-primary"/>
            </form>
        </div>
    </div>
@endsection
