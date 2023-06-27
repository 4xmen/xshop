<div id="nav-menu">
    <ul>
        @foreach(\App\Helpers\getMainCats(12) as $mcat)
        <li>
            <a href="{{route('cat',$mcat->slug)}}">
                {{$mcat->name}}
                <i class="ri-arrow-drop-left-line"></i>
            </a>
            <div class="sub-item">
                <h3>
                    {{$mcat->name}}
                </h3>
                <div class="grid">
                    <div>

                        <ul>
                            @foreach(\App\Helpers\getSubCats($mcat->id) as $subcat)
                                <li>
                                    <a href="{{route('cat',$subcat->slug)}}">
                                        <i class="fa fa-external-link"></i>
                                        {{$subcat->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <ul>
                            @foreach(\App\Helpers\getSubCats($mcat->id) as $subcat)
                                <li>
                                    <a href="{{route('cat',$subcat->slug)}}">
                                        <i class="fa fa-external-link"></i>
                                        {{$subcat->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <img src="{{$mcat->thumbUrl()}}" class="img-fluid" alt="">
{{--                        {{$mcat->description}}--}}
                    </div>
                </div>
            </div>

        </li>
        @endforeach
    </ul>
</div>
