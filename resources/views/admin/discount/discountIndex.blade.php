@extends('admin.adminlayout')
@section('page_title')
    {{__("Discounts")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <form action="{{route('admin.discount.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>
                        {{__("Type")}}
                    </th>
                    <th>
                        {{__("Amount")}}
                    </th>
                    <th>
                        {{__("Product")}}
                    </th>
                    <th>
                        {{__("Expire")}}
                    </th>
                    <th>
                        {{__("Action")}}
                        <a href="{{route('admin.discount.create')}}" class="btn btn-success float-right"><i
                                class="fa fa-plus"></i></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($discounts as $n)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$n->id}}" class="m-2 chkbox"/>
                            {{$n->id}}
                        </td>
                        <td>
                            {{__($n->type)}}
                        </td>
                        <td>
                            @if($n->type == 'percent')
                                {{$n->amount}}%
                            @else
                                {{number_format($n->amount)}}
                                {{config('app.currency_type')}}
                            @endif
                        </td>
                        <td>
                            @if($n->product != null)
                                <a href="{{route('admin.product.edit',$n->product->slug)}}">
                                    {{$n->product->name}}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($n->expire == null)
                                -
                            @else
                                {{\App\Helpers\time2persian($n->expire)}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.discount.edit',$n->id)}}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> &nbsp;
                                {{__("Edit")}}
                            </a>
                            <a href="{{route('admin.discount.delete',$n->id)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="fa fa-times"></i> &nbsp;
                                {{__("Delete")}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' => []])
        </form>
        <div class="text-center pt-3">
            {{$discounts->links()}}
        </div>
    </div>
@endsection
