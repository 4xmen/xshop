<section class="SimpleUnderConstruction live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
   <div class="container">
       <h1>
           {{$title}}
       </h1>
       <h2>
           {{getSetting('desc')}}
       </h2>
       <img src="{{asset('assets/default/under-construction.svg')}}" alt="under-construction">
       <div class="my-3">
       {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
       </div>
       <ul class="social-list">
           @foreach(getSettingsGroup('social_')??[] as $k => $social)
               <li>
                   <a href="{{$social}}">
                       <i class="ri-{{$k}}-line"></i>
                   </a>
               </li>
           @endforeach
           <li>
               <a href="tel:{{getSetting('tel')}}">
                   <i class="ri-phone-line"></i>
               </a>
           </li>
           <li>
               <a href="mailto:{{getSetting('email')}}">
                   <i class="ri-mail-line"></i>
               </a>
           </li>
       </ul>
   </div>
</section>
