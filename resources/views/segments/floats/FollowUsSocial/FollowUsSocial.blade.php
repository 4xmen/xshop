<section id='FollowUsSocial'>
    <span>
        {{__("Follow us")}}
    </span>
    @foreach(getSettingsGroup('social_')??[] as $k => $social)
        <a href="{{$social}}">
            <i class="ri-{{$k}}-line"></i>
        </a>
    @endforeach
</section>
