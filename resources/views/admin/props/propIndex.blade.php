@extends('admin.adminlayout')

@section('content')
    <div class="container">
        <h5 class="text-center"> {{__("Properties list")}}
            <a class="btn btn-primary float-start" href="{{route('admin.props.create')}}">
                <i class="fa fa-plus"></i>
            </a>
        </h5>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__("Name")}}</th>
                    <th>{{__("Label")}}</th>
                    <th>{{__("Type")}}</th>
                    <th>{{__("Product category")}}</th>
                    <th>-</th>
                </tr>
                </thead>
                <tbody>
                @foreach($props as $k=>$p)
                    <tr>
                        <td scope="row">{{$p->id}}</td>
                        <td>
                            {{$p->name}}
                        </td>
                        <td>
                            {{$p->label}}
                        </td>
                        <td>
                            {{$p->type}}
                        </td>
                        <td>
                            @if(isset($p->category))
                                @foreach($p->category as $c)
                                    <a href="{{route('admin.props.sort',$c->id)}}">
                                        {{$c->name}}
                                        <i class="fa fa-sort"></i>
                                    </a>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="btn-group"
                                 role="group">
                                <a title="Edit"
                                   class="btn btn-secondary ad-accept-btn"
                                   href="{{route('admin.props.edit',$p->id)}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                &nbsp;
                                <a title="Dlete"
                                   class="btn btn-danger cdelete"
                                   href="{{route('admin.props.delete',$p->id)}}">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pt-2">
                {{$props->links()}}
            </div>
        </div>
    </div>
@endsection
