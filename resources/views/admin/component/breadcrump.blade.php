<div class="x-breadcrumb">
    <ul class="steps">
        <li class="step">
            <a href="{{route('welcome')}}" target="_blank">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </li>
        <li class="step">
            <a href="{{route('admin.home')}}">
                <i class="fa fa-dashboard" aria-hidden="true"></i>
                {{__("Dashboard")}}
            </a>
        </li>

        {{App\Helpers\lastCrump()}}
    </ul>
</div>
