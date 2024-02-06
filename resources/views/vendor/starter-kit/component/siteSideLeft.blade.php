@foreach(\App\Adv::where('active',1)->get() as $ad)
    <div class="mb-2">
        <a href="{{route('goadv',$ad->id)}}" class="adv">
            <img src="{{$ad->imgUrl()}}" alt="[{{$ad->title}}]" title="{{$ad->title}}">
        </a>
    </div>
@endforeach
