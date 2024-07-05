<div class='TopSimple'>
   <div class="{{gfx()['container']}}">
       <div class="row">
           <div class="col-md-3 pt-2 text-lg-start">
               <i class="ri-mail-line"></i>
               <a href="mailto:{{getSetting('email')}}" class="other-link">
                   {{getSetting('email')}}
               </a>
           </div>
           <div class="col-md-3 pt-2 text-lg-start">
               <i class="ri-phone-line"></i>
               <a href="tel:{{getSetting('tel')}}" class="other-link">
               {{getSetting('tel')}}
               </a>
           </div>
           <div class="col-md-6 pt-2">
              <ul class="justify-content-lg-end justify-content-center">
                  @foreach(getSettingsGroup('social_')??[] as $k => $social)
                      <li>
                          <a href="{{$social}}">
                              <i class="ri-{{$k}}-line"></i>
                          </a>
                      </li>
                  @endforeach
              </ul>
           </div>
       </div>
   </div>
</div>
