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
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                <tr>
                    <th>
                        #
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
                    </th>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($discounts as $n)
                    <tr>
                        <td>
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
                                {{$n->expire->jdate('Y/m/d')}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.discount.edit',$n->id)}}" class="btn btn-primary">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.discount.delete',$n->id)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="ri-close-line"></i>
                            </a>
                        </td>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$n->id}}" class="m-2 chkbox"/>
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
    <a class="btn-add" href="{{route('admin.discount.create')}}">
        <i class="ri-add-line"></i>
    </a>
@endsection
