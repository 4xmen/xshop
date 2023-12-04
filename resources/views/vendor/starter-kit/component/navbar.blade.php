<nav id="navbar" class="">
    <ul>
        <li>
            <a href="{{ url('/') }}">
                <i class="fa fa-atom"></i>
                {{ config('app.name', 'Laravel') }}
            </a>
        </li>
        <li id="catalog" class="main-nav">
            <a>
                <i class="fab fa-apple"></i>
                &nbsp;
                {{__("Catalog")}}
            </a>
            <ul>
                @if(auth()->user()->hasAnyAccess('product'))
                    <li id="product-li">
                        <a>
                            <i class="fa fa-gem"></i>
                            {{__('Products')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.product.index')}}">
                                    {{__('Products list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.product.create')}}">
                                    {{__('New Product')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('invoice'))
                    <li id="invoices-li">
                        <a>
                            <i class="fa fa-file-invoice"></i>
                            {{__('Invoices')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.invoice.index')}}">
                                    {{__('Invoices list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.invoice.create')}}">
                                    {{__('New Invoice')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('customer'))
                    <li>
                        <a>
                            <i class="fa fa-users"></i>
                            {{__('Customers')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.customer.index')}}">
                                    {{__('Customers list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.customer.create')}}">
                                    {{__('New Customer')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('discount'))
                    <li id="discount-li">
                        <a>
                            <i class="fa fa-percent"></i>
                            {{__('Discounts')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.discount.index')}}">
                                    {{__('Discounts list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.discount.create')}}">
                                    {{__('New discount')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('question'))
                    <li id="questions-li">
                        <a href="{{route('admin.question.index')}}">
                            <i class="fa fa-question"></i>
                            {{__('Questions')}}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('ticket'))
                    <li id="tickets-li">
                        <a href="{{route('admin.ticket.index')}}">
                            <i class="fa fa-envelope"></i>
                            {{__('Tickets')}}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('cat'))
                    <li>
                        <a>
                            <i class="fa fa-cubes"></i>
                            {{__('Product categories')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.cat.index')}}">
                                    {{__('Product categories list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.cat.create')}}">
                                    {{__('New Product category')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.cat.sort')}}">
                                    {{__('Product categories node')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('transport'))

                    <li>
                        <a>
                            <i class="fa fa-truck"></i>
                            {{__('Transports')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.transport.index')}}">
                                    {{__('Transports list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.transport.create')}}">
                                    {{__('New transport')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('props'))
                    <li>
                        <a>
                            <i class="fa fa-project-diagram"></i>
                            {{__("Properties meta")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.props.index')}}">
                                    {{__("Properties list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.props.create')}}">
                                    {{__("New Property")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
            </ul>
        </li>


        <li id="cms" class="main-nav">
            <a>
                <i class="fab fa-internet-explorer"></i>
                &nbsp;
                {{__("Website contents")}}
            </a>
            <ul>
                @if(auth()->user()->hasAnyAccess('post'))
                    <li id="posts-li">
                        <a>
                            <i class="fa fa-bullhorn"></i>
                            {{__('Post')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.post.index')}}">
                                    {{__('Post list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.post.create')}}">
                                    {{__('New Post')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('category'))
                    <li>
                        <a>
                            <i class="fa fa-book"></i>
                            {{__('Categories')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.category.index')}}">
                                    {{__('Categories list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.category.create')}}">
                                    {{__('New category')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.category.sort')}}">
                                    {{__('Categories node')}}
                                </a>
                            </li>
                        </ul>


                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('gallery'))


                    <li>
                        <a>
                            <i class="fa fa-images"></i>
                            {{__("Galleries")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.gallery.all')}}">
                                    {{--                           <i class="fa fa-list-alt"></i> --}}
                                    {{__("Gallery list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.gallery.create')}}">
                                    {{--                            <i class="fa fa-plus-square"></i>--}}
                                    {{__("New gallery")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('clip'))
                    <li>
                        <a>
                            <i class="fa fa-file-video"></i>
                            {{__("Video clips")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.clip.index')}}">
                                    {{__("Video list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.clip.create')}}">
                                    {{__("New Video")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('adv'))
                    <li>
                        <a>
                            <i class="fa fa-atom"></i>
                            {{__("Advertise")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.adv.index')}}">
                                    {{__("Advertise list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.adv.create')}}">
                                    {{__("New Advertise")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('menu'))
                    <li>
                        <a href="{{route('admin.menu.index')}}">
                            <i class="fa fa-list-alt"></i>
                            {{__("Menus")}}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('props'))
                    <li>
                        <a>
                            <i class="fa fa-file-image"></i>
                            {{__("Slider")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.slider.index')}}">
                                    {{__("Slider list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.slider.create')}}">
                                    {{__("New Slider")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('poll'))
                    <li>
                        <a>
                            <i class="fa fa-vote-yea"></i>
                            {{__("Poll")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.poll.index')}}">
                                    {{__("Polls list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.poll.create')}}">
                                    {{__("New Poll")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
            </ul>
        </li>

        @if(auth()->user()->hasAnyAccess('comment'))
            <li>
                <a href="{{route('admin.comment.index')}}">
                    <i class="fa fa-comments"></i>
                    {{__('Comments')}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('setting'))
            <li>
                <a href="{{route('admin.setting.index')}}">
                    <i class="fa fa-cogs"></i>
                    {{__("Setting")}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('attachment'))
            <li>
                <a href="{{route('admin.attachment.index')}}">
                    <i class="fa fa-paperclip"></i>
                    {{__("Attachments")}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('contact'))
            <li>
                <a href="{{route('admin.contact.index')}}">
                    <i class="fa fa-envelope"></i>
                    {{__("Contact us")}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('logs'))
            <li>
                <a href="{{route('admin.logs.index')}}">
                    <i class="fa fa-list-alt"></i>
                    {{__('Logs')}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasRole('super-admin'))
            <li>
                <a>
                    <i class="fa fa-users"></i>
                    {{__("Users")}}
                </a>
                <ul>
                    <li>
                        <a href="{{route('admin.user.all')}}">
                            {{--                           <i class="fa fa-list-alt"></i> --}}
                            {{__("Users list")}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.user.create')}}">
                            {{--                            <i class="fa fa-plus-square"></i>--}}
                            {{__("New user")}}
                        </a>
                    </li>
                </ul>

            </li>
            @if(config('app.xlang'))
                <li>
                    <a>
                        <i class="fa fa-language"></i>
                        {{__("Languages")}}
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.lang.index')}}">
                                {{--                           <i class="fa fa-list-alt"></i> --}}
                                {{__("Language list")}}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.lang.create')}}">
                                {{--                            <i class="fa fa-plus-square"></i>--}}
                                {{__("New language")}}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.lang.translate')}}">
                                {{--                            <i class="fa fa-plus-square"></i>--}}
                                {{__("Translates")}}
                            </a>
                        </li>
                    </ul>

                </li>
            @endif
        @endif

        @guest
            <li>
                <a href="{{ route('login') }}"> <i class="fa fas fa-sign-in"></i> {{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li>
                    <a href="{{ route('register') }}"> <i class="fa fas fa-sign-in"></i> {{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fa fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest

    </ul>

</nav>
