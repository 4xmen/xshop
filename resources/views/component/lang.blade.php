<script>
    var isInit = false;
    var uploadFormData = [];
    var appName = `{{config('app.name')}}`;
    window.translate = {};
    window.translate.next = `{{__('Next')}}`;
    window.translate.prev = `{{__('Previous')}}`;
    window.translate.finishAndSave = `{{__('Finish and save')}}`;
    window.translate.specialQuantity = `{{__('Special quantity')}}`;
    window.translate.choose = `{{__('Choose one')}}`;
    window.translate.remove = `{{__('Remove')}}`;
    window.translate.price = `{{__('Price')}}`;
    window.translate.count = `{{__('Count')}}`;
    window.translate.from = `{{__('From')}}`;
    window.translate.to = `{{__('To')}}`;
    window.translate.all = `{{__('All')}}`;
    window.translate.priceRange = `{{__('Price range')}}`;
    window.translate.true = `{{  __('True') }}`;
    window.translate.false = `{{ __('False') }}`;
    window.translate.errMobile = `{{ __('Incorrect mobile number') }}`;
    window.translate.discountCodeError= `{{ __('Discount code  incorrect') }}`;
    window.translate.discountCodeAccept= `{{ __('Discount code accepted') }}`;

    @if(request()->route('lang') != null)
        // Get all anchor elements on the page
        let links = document.getElementsByTagName('a');

        const webBase = window.location.protocol + '//' + window.location.host;
        // Loop through each anchor element
        for (let i = 0; i < links.length; i++) {
            let link = links[i];

            // Check if the href attribute starts with webBase
            if (link.href.indexOf(webBase) === 0) {
                // Prefix '/en' to the href attribute
                link.href = '/{{request()->route('lang')}}' + link.href.substring(webBase.length);
            }
        }
    @endif
</script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
