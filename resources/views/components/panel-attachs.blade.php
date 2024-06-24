<h4>
    {{__("Attachments")}}
    <a href="{{route('admin.attachment.create')}}?" class="btn btn-light float-end mb-2">
        <i class="ri-add-line"></i>
        <i class="ri-attachment-line"></i>
    </a>
</h4>
<div class="clearfix"></div>
<ul class="list-group">
    @foreach($attachs as $attach)

        <li class="list-group-item">
            <a href="{{route('admin.attachment.deattach',$attach->slug)}}" class="btn btn-danger float-end btn-sm" data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
               data-bs-title="{{__("Deattach")}}">
                <i class="ri-close-line"></i>
            </a>
            <div class="p-2">

            <a href="{{$attach->url()}}">
                {{$attach->file}}
            </a>
            [ {{formatFileSize($attach->size)}} ]
            [ {{$attach->ext}} ]
            </div>

        </li>
    @endforeach
</ul>
