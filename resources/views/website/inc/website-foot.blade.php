</div>
@yield('custom-foot')
<input type="hidden" id="api-display-url" value="{{route('v1.visitor.display')}}">
<input type="hidden" id="api-fav-toggle" value="{{route('client.product-fav-toggle','')}}/">
<input type="hidden" id="api-compare-toggle" value="{{route('client.product-compare-toggle','')}}/">

@if(auth()->check() && (auth()->user()->hasRole('developer') || auth()->user()->hasRole('admin')))
<a id="do-edit" data-bs-custom-class="custom-tooltip"
   data-bs-toggle="tooltip" data-bs-placement="auto"
   title="{{__("Customize theme")}}">
    <i class="ri-settings-2-line"></i>
</a>
<input type="hidden" id="live-url" value="{{route('admin.setting.live','')}}/">
@endif
<div id="live-card-modal">
    <div id="live-card-container">
        <a href="{{ route('client.card') }}" class="btn btn-outline-primary d-block">
            <i class="ri-shopping-bag-2-line"></i>
            {{__("Go to card")}}
        </a>
        <div id="live-card-list">
            @include('components.card-items')
        </div>
    </div>
</div>
<div id="live-search-content">
    <div id="live-search-data">
        {{__("You need to type at least 4 characters to perform a search...")}}
    </div>
    <div class="text-center">
        <i class="ri-loader-4-line" id="search-ajax-loader"></i>
    </div>
</div>
<div id="share-modal">
<div id="share-box">
    <i class="ri-close-line" id="share-close"></i>
    <h3>
        {{__("Share this page")}}
    </h3>
    <img src="{{asset('upload/images/logo.svg')}}" id="share-image" class="float-start mx-3" alt="[image page]">
    <b>
        {{__("Share here")}}:
    </b>
    <div class="social-list">
        <a  target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->full())}}">
          <i class="ri-linkedin-line"></i>
        </a>
        <a  target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->full())}}">
            <i class="ri-facebook-line"></i>
        </a>
        <a  target="_blank" href="https://x.com/share?url={{urlencode(url()->full())}}">
           <i class="ri-twitter-x-line"></i>
        </a>
        <a  target="_blank" href="https://telegram.me/share/url?url={{urlencode(url()->full())}}">
          <i class="ri-telegram-line"></i>
        </a>
        <a  target="_blank" href="https://web.whatsapp.com/send?text={{urlencode(url()->full())}}">
            <i class="ri-whatsapp-line"></i>
        </a>
    </div>

    <div class="clearfix"></div>
    <h3 class="pb-0">
        {{__("Direct link")}}:
    </h3>
    <div class="p-3 pt-0">
        <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="share-copy" >
                <i class="ri-file-copy-line"></i>
            </button>
            <input type="text" id="share-link" class="form-control" dir="ltr" readonly value="{{(url()->full())}}">
        </div>
    </div>
</div>
</div>
</body>
</html>
