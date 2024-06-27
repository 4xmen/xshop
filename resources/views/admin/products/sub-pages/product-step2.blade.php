<div class="alert alert-info pt-4">
    <p>&check; &nbsp; {{__("The first and/or second image will be index image")}} <br>
        &check; &nbsp; {{__("You can choose one or more image together")}} <br>
        &check; &nbsp; {{__("Double click on image to change index image")}}
    </p>
</div>
<div class="uploader-images">
    <input type="file" multiple accept=".jpg,.png,.gif" id="upload-image-select"/>
</div>
<div id="upload-drag-drop">
    <h2>
        {{__("Click here to upload or drag and drop here")}}
    </h2>
</div>
<div id="uploading-images" class="row">
    @if (isset($item))
        @foreach($item->getMedia() as $k => $media)
            <div data-id="-1" data-key="{{$k}}"
                 class="image-index col-xl-3 col-md-4 border p-3 @if($k == $item->image_index) indexed @endif">
                <img class="img-list" src="{{$media->getUrl('product-image')}}" alt="{{$k}}">
                <div class="btn btn-danger upload-remove-image d-block">
                     <span class="ri-close-line"></span>
                </div>
                <input type="hidden" name="medias[]" value="{{$media->id}}"/>
            </div>
        @endforeach
       <input type="hidden" name="index_image"  id="index-image" value="{{$item?->image_index}}">
    @endif
</div>

