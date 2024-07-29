<section class='SimpleAttachmentList'>
    <div class="{{gfx()['container']}}">
    @if(count($data['attachs']) > 0)
        <h2 class="my-3">
            {{__("Attachments")}}
        </h2>
        <table class="table table-striped attach-table table-hover">
            <tr>
                <th>
                    {{__("Name")}}
                </th>
                <th>
                    {{__("File name")}}
                </th>
                <th>
                    {{__("Size")}}
                </th>
                <th>
                    -
                </th>
            </tr>
            @foreach($data['attachs'] as $attach)
                <tr>
                    <th>
                        {{$attach->title}}
                    </th>
                    <th>
                        {{$attach->title}} <span> [ {{$attach->ext}} ] </span>
                    </th>
                    <th>
                        {{formatFileSize($attach->size)}}
                    </th>
                    <th>
                        <a href="{{$attach->tempUrl()}}" class="btn btn-sm btn-outline-primary">
                            <i class="ri-download-2-line"></i>
                        </a>
                    </th>
                </tr>
            @endforeach
        </table>
    @endif
    </div>
</section>
