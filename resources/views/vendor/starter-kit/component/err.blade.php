@if(session()->has('message'))
    <div class="alert alert-info">
        {{ session()->get('message') }}
    </div>
@endif
@foreach($errors->all() as $err)
    <div class="alert alert-danger">
        {{$err}}
    </div>
@endforeach
