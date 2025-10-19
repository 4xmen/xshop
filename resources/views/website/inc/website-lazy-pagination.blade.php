<div class="row" id="place-holder">
    @for($i = 0; $i < 3; $i++)
    <div class="{{getSetting('grid-class')}}">
        <img class="placeholder-img"  src="{{asset('assets/default/placeholder.svg')}}" alt="placholder">
    </div>
    @endfor
</div>
<div id="active-pagination">
    {{$items->withQueryString()->links()}}
</div>
<input type="hidden" id="max-page" value="{{ $items->lastPage() }}">
