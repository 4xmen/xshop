<nav id="panel-breadcrumb">
    <ul>
        <li>
            <a href="{{url('/')}}" target="_blank">
                <i class="ri-home-3-line"></i>
                <span>
                    {{config('app.name')}}
                </span>
            </a>
        </li>
        <li>
            <a href="{{route('admin.home')}}">
                <i class="ri-dashboard-3-line"></i>
                <span>
                    {{__("Dashboard")}}
                </span>
            </a>
        </li>
        {{lastCrump()}}
{{--        <li>--}}
{{--            <a href="#3">--}}
{{--                <i class="ri-user-3-line"></i>--}}
{{--                {{__("Users")}}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <span>--}}
{{--                    <i class="ri-add-line"></i>--}}
{{--                {{__("Add new user")}}--}}
{{--            </span>--}}
{{--        </li>--}}
    </ul>
</nav>
