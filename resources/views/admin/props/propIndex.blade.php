@extends('admin.adminlayout')

@section('content')
    <div class="container">
        <h5 class="text-center">
            {{__("Properties list")}}
        </h5>

        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
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
                        <td class="no-dec">
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
                                   class="btn btn-primary ad-accept-btn"
                                   href="{{route('admin.props.edit',$p->id)}}">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                &nbsp;
                                <a title="Dlete"
                                   class="btn btn-danger cdelete"
                                   href="{{route('admin.props.delete',$p->id)}}">
                                    <i class="ri-close-line"></i>
                                </a>
                                @if(config('app.xlang'))
                                    <a href="{{route('admin.lang.model',[$p->id,\App\Models\Prop::class])}}"
                                       class="btn btn-outline-dark translat-btn mx-1">
                                        <i class="ri-translate"></i>
                                    </a>
                                @endif
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


    <a class="btn-add" href="{{route('admin.props.create')}}">
        <i class="ri-add-line"></i>
    </a>
@endsection
