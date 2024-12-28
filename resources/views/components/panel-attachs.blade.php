<h4>
    {{__("Attachments")}}
    <a href="{{route('admin.attachment.create')}}?" id="show-attach-form" class="btn btn-light float-end mb-2">
        <i class="ri-add-line"></i>
        <i class="ri-attachment-line"></i>

        <span id="attach-number">
            ({{count($attachs)}})
        </span>
    </a>
</h4>
<div class="clearfix"></div>
{{--<ul class="list-group">--}}
{{--    @foreach($attachs as $attach)--}}

{{--        <li class="list-group-item">--}}
{{--            <a href="{{route('admin.attachment.detach',$attach->slug)}}" class="btn btn-danger float-end btn-sm" data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"--}}
{{--               data-bs-title="{{__("Detach")}}">--}}
{{--                <i class="ri-close-line"></i>--}}
{{--            </a>--}}
{{--            <div class="p-2">--}}

{{--            <a href="{{$attach->url()}}">--}}
{{--                {{$attach->file}}--}}
{{--            </a>--}}
{{--            [ {{formatFileSize($attach->size)}} ]--}}
{{--            [ {{$attach->ext}} ]--}}
{{--            </div>--}}

{{--        </li>--}}
{{--    @endforeach--}}
{{--</ul>--}}
