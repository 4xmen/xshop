@if(session()->has('message'))
    <div class="alert alert-info">
        <i class="ri-check-double-line"></i>
        {{ session()->get('message') }}
    </div>
@endif
@foreach($errors->all() as $err)
    <div class="alert alert-danger">
        <i class="ri-error-warning-line"></i>
        {{$err}}
    </div>
@endforeach
